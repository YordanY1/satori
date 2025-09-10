<?php

namespace App\Livewire\Pages;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Stripe\StripeClient;
use App\Support\PayPal;
use App\Support\Cart;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\Shipping\EcontDirectoryService;
use App\Services\Shipping\ShippingCalculator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderPlacedAdminMail;
use App\Mail\OrderPlacedCustomerMail;

class Checkout extends Component
{

    protected $listeners = ['cart-updated' => 'recalcShipping'];

    public function recalcShipping()
    {
        $this->calculateShippingSafely();
    }

    // Default shipping method: "address" or "econt_office"
    public string $shipping_method = 'address';

    // --- City selection (structured from Econt directory) ---
    public string $citySearch = '';
    public ?int $cityId = null;          // Econt city internal ID (our DB PK)
    public string $cityLabel = '';
    public ?string $cityPostCode = null;
    public array $cityOptions = [];

    // --- Customer info ---
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';         // Notes (floor, apt, entrance)
    public string $payment_method = 'cod'; // "cod", "stripe", "paypal"

    // --- Econt office selection ---
    public string $officeSearch = '';
    public ?string $officeCode = null;   // Econt office code
    public string $officeLabel = '';
    public array $officeOptions = [];
    public bool $officeDropdownOpen = false;

    // --- Street selection (requires city) ---
    public string $streetSearch = '';
    public ?int $streetId = null;        // our streets table PK (if any)
    public ?int $streetCode = null;      // Econt street ID (if any)
    public string $streetLabel = '';
    public array $streetOptions = [];
    public string $streetNum = '';       // e.g. "12A"

    // Shipping
    public float $shippingCost = 0.00;

    public bool $accept_terms = false;

    public function mount(): void
    {
        if (Auth::check()) {
            $u = Auth::user();
            $this->name  = (string) ($u->name ?? '');
            $this->email = (string) ($u->email ?? '');
            $this->phone = (string) (data_get($u, 'phone', '') ?? '');
        }
    }

    /**
     * Validation rules depending on selected shipping method.
     */
    protected function rules(): array
    {
        $base = [
            'name'            => 'required|string|min:3',
            'email'           => 'required|email',
            'phone'           => 'required|string|min:8',
            'payment_method'  => 'required|in:cod,stripe,paypal',
            'shipping_method' => 'required|in:econt_office,address',
            'accept_terms'    => 'accepted',
        ];

        if ($this->shipping_method === 'address') {
            $base['cityId']     = 'required|integer|min:1';
            $base['streetCode'] = 'nullable|integer|min:1';
            $base['streetNum']  = 'nullable|string|max:20';
            $base['address'] = 'nullable|string|max:255';
        } else {
            $base['officeCode'] = 'required|string|min:1';
        }

        return $base;
    }

    /**
     * Switch shipping method + reset unrelated fields + auto recalc.
     */
    public function updatedShippingMethod(string $value): void
    {
        if ($value === 'address') {
            // Reset office fields
            $this->officeSearch = '';
            $this->officeCode   = null;
            $this->officeLabel  = '';
            $this->officeOptions = [];
            $this->officeDropdownOpen = false;

            // Reset city fields
            $this->citySearch = '';
            $this->cityId = null;
            $this->cityLabel = '';
            $this->cityPostCode = null;
            $this->cityOptions = [];

            $this->dispatch('focus-city-input');
        } else {
            // Reset address fields
            $this->address = '';
            $this->citySearch = '';
            $this->cityId = null;
            $this->cityLabel = '';
            $this->cityPostCode = null;
            $this->cityOptions = [];
            $this->officeDropdownOpen = true;
        }

        $this->calculateShippingSafely();
    }

    /**
     * Resolve the Econt directory service (DI).
     */
    private function dir(): EcontDirectoryService
    {
        return app(EcontDirectoryService::class);
    }

    /**
     * Search Econt offices by query.
     */
    public function updatedOfficeSearch(): void
    {
        $q = trim($this->officeSearch);

        if ($q === '' || ($this->officeCode && $q === $this->officeLabel)) {
            $this->officeOptions = [];
            return;
        }

        $this->officeOptions = array_values($this->dir()->searchOffices($q, 300)->toArray());
    }

    /**
     * Select office from dropdown + auto recalc.
     */
    public function selectOffice($code, $label): void
    {
        $this->officeCode         = (string) $code;
        $this->officeLabel        = (string) $label;
        $this->officeSearch       = (string) $label;
        $this->officeOptions      = [];
        $this->officeDropdownOpen = false;

        $this->resetValidation('officeCode');
        $this->calculateShippingSafely();
    }

    /**
     * Search cities.
     */
    public function updatedCitySearch(): void
    {
        $q = trim($this->citySearch);

        if ($q === '' || ($this->cityId && $q === $this->cityLabel)) {
            $this->cityOptions = [];
            return;
        }

        $this->cityOptions = array_values(
            $this->dir()->searchCities($q, 50)->map(function ($c) {
                return [
                    'id'        => $c['id'],
                    'label'     => $c['label'],
                    'post_code' => $c['post_code'] ?? null,
                ];
            })->toArray()
        );
    }

    /**
     * Search streets (requires city).
     */
    public function updatedStreetSearch(): void
    {
        if (!$this->cityId) {
            $this->streetOptions = [];
            return;
        }

        $q = trim($this->streetSearch);

        if ($q === '' || ($this->streetId && $q === $this->streetLabel)) {
            $this->streetOptions = [];
            return;
        }

        $this->streetOptions = array_values(
            $this->dir()->streetsByCity($this->cityId, $q, 100)->toArray()
        );
    }

    /**
     * Select street + auto recalc.
     */
    public function selectStreet($id, $code, $label): void
    {
        $this->streetId     = (int) $id;
        $this->streetCode   = (int) $code;
        $this->streetLabel  = (string) $label;
        $this->streetSearch = (string) $label;
        $this->streetOptions = [];

        $this->resetValidation(['streetCode']);
        $this->calculateShippingSafely();
    }

    /**
     * Select city + auto recalc.
     */
    public function selectCity($id, $label, $postCode = null): void
    {
        $this->cityId       = (int) $id;
        $this->cityLabel    = (string) $label;
        $this->cityPostCode = $postCode ? (string) $postCode : null;
        $this->citySearch   = (string) $label;
        $this->cityOptions  = [];

        $this->resetValidation(['cityId', 'address']);
        $this->calculateShippingSafely();
    }

    /**
     * Recalculate shipping when address details change (only for "address" method).
     */
    public function updatedStreetNum(): void
    {
        $this->calculateShippingSafely();
    }

    public function updatedAddress(): void
    {
        if ($this->shipping_method === 'address') {
            $this->calculateShippingSafely();
        }
    }

    public function updatedName(): void
    {
        $this->calculateShippingSafely();
    }

    public function updatedPhone(): void
    {
        $this->calculateShippingSafely();
    }

    /**
     * Cheap guard to avoid hitting API without required data.
     */
    private function canCalculateShipping(): bool
    {
        if (trim($this->name) === '' || trim($this->phone) === '') {
            return false;
        }

        if ($this->shipping_method === 'address') {
            return (bool) $this->cityId;
        }

        if ($this->shipping_method === 'econt_office') {
            return (bool) $this->officeCode;
        }

        return false;
    }

    /**
     * Safe wrapper to recalc shipping (resets to 0 if insufficient data).
     */
    private function calculateShippingSafely(): void
    {
        if (!$this->canCalculateShipping()) {
            $this->shippingCost = 0.00;
            return;
        }
        $this->calculateShipping();
    }

    /**
     * Compute total shipment weight from cart. Adjust to your domain (Book weight, default fallback, etc.)
     */
    private function computeCartWeight(): float
    {
        $items = Cart::all();
        if (empty($items)) return 0.5;

        $totalWeight = 0.0;
        foreach ($items as $id => $item) {
            $qty   = max(1, (int) ($item['quantity'] ?? 1));
            $unitW = (float) ($item['weight'] ?? 0.5);
            $totalWeight += $unitW * $qty;
        }
        $totalWeight += 0.10;
        $totalWeight = max(0.3, round($totalWeight, 2));

        \Log::debug('CHECKOUT:computeCartWeight', [
            'cart' => $items,
            'computed_weight_kg' => $totalWeight,
        ]);

        return $totalWeight;
    }


    /**
     * Call Econt CALCULATE via ShippingCalculator and set $shippingCost.
     */
    public function calculateShipping(): void
    {
        try {
            $calculator = app(ShippingCalculator::class);

            $labelInput = [
                'sender' => [
                    'name'      => config('shipping.econt.sender_name'),
                    'phone'     => config('shipping.econt.sender_phone'),
                    'city_name' => config('shipping.econt.sender_city'),
                    'post_code' => config('shipping.econt.sender_post'),
                    'street'    => config('shipping.econt.sender_street'),
                    'num'       => config('shipping.econt.sender_num'),
                ],
                'receiver' => [
                    'name'         => $this->name,
                    'phone'        => preg_replace('/\s+/', '', $this->phone),
                    'city_id'      => $this->shipping_method === 'address' ? $this->cityId : null,
                    'office_code'  => $this->shipping_method === 'econt_office' ? $this->officeCode : null,
                    'street_label' => $this->streetLabel ?: null,
                    'street_num'   => $this->streetNum ?: null,
                ],
                'pack_count'  => 1,
                'weight'      => $this->computeCartWeight(),
                'description' => 'Книги',
            ];

            $this->shippingCost = $calculator->calculate($labelInput);
        } catch (\Throwable $e) {
            report($e);
            $this->shippingCost = 0.00;
            $this->addError('shipping', 'Не успяхме да изчислим доставка: ' . $e->getMessage());
        }
    }

    /**
     * Main order placement logic.
     */
    public function placeOrder()
    {
        $this->validate();

        if (Cart::count() === 0) {
            $this->addError('cart', 'The cart is empty.');
            return;
        }

        // Ensure we have a fresh shipping price
        if ($this->shippingCost <= 0) {
            $this->calculateShippingSafely();
        }

        return DB::transaction(function () {
            // Collect cart items
            $items   = Cart::all();
            $bookIds = array_keys($items);
            $books   = Book::whereIn('id', $bookIds)->get(['id', 'title', 'price']);

            $subtotal   = 0.00;
            $normalized = [];

            foreach ($books as $book) {
                $qty  = max(1, (int) ($items[$book->id]['quantity'] ?? 1));
                $unit = (float) $book->price;
                $line = $unit * $qty;

                $subtotal += $line;

                $normalized[] = [
                    'book_id'    => $book->id,
                    'title'      => $book->title,
                    'unit_price' => $unit,
                    'quantity'   => $qty,
                    'line_total' => $line,
                ];
            }

            $discount = 0.00;
            $shipping = $this->shippingCost;
            $tax      = 0.00;
            $total    = $subtotal - $discount + $shipping + $tax;

            // Create order
            $order = Order::create([
                'user_id'         => Auth::id(),
                'public_id'        => (string) Str::uuid(),
                'order_number'     => $this->generateOrderNumber(),
                'customer_name'    => $this->name,
                'customer_email'   => $this->email,
                'customer_phone'   => $this->phone,
                'customer_address' => $this->address,
                'currency'         => 'BGN',
                'subtotal'         => round($subtotal, 2),
                'discount_total'   => round($discount, 2),
                'shipping_total'   => round($shipping, 2),
                'tax_total'        => round($tax, 2),
                'total'            => round($total, 2),
                'status'           => 'pending',
                'payment_method'   => $this->payment_method,
                'payment_status'   => 'pending',
                'terms_accepted_at' => now(),
            ]);

            $order->shipping_draft = [
                'carrier' => 'econt',
                'method'  => $this->shipping_method,
                'receiver_office_code' => $this->shipping_method === 'econt_office' ? $this->officeCode : null,
                'receiver' => [
                    'name'         => $this->name,
                    'phone'        => preg_replace('/\s+/', '', $this->phone),
                    'city_id'      => $this->shipping_method === 'address' ? $this->cityId : null,
                    'street_label' => $this->streetLabel ?: null,
                    'street_num'   => $this->streetNum ?: null,
                ],
                'weight'      => $this->computeCartWeight(),
                'description' => 'Книги',
            ];
            $order->save();

            // Order items
            foreach ($normalized as $n) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'book_id'    => $n['book_id'],
                    'title'      => $n['title'],
                    'unit_price' => round($n['unit_price'], 2),
                    'quantity'   => $n['quantity'],
                    'line_total' => round($n['line_total'], 2),
                ]);
            }

            Mail::to($order->customer_email)->queue(new OrderPlacedCustomerMail($order));
            Mail::to(config('mail.admin_address', 'admin@example.com'))->queue(new OrderPlacedAdminMail($order));


            // COD => create label (CREATE)
            if ($this->payment_method === 'cod') {
                try {
                    $labelService = app(\App\Services\Shipping\EcontLabelService::class);

                    $labelInput = [
                        'sender' => [
                            'name'      => config('shipping.econt.sender_name'),
                            'phone'     => config('shipping.econt.sender_phone'),
                            'city_name' => config('shipping.econt.sender_city'),
                            'post_code' => config('shipping.econt.sender_post'),
                            'street'    => config('shipping.econt.sender_street'),
                            'num'       => config('shipping.econt.sender_num'),
                        ],
                        'receiver' => [
                            'name'         => $this->name,
                            'phone'        => preg_replace('/\s+/', '', $this->phone),
                            'city_id'      => $this->shipping_method === 'address' ? $this->cityId : null,
                            'office_code'  => $this->shipping_method === 'econt_office' ? $this->officeCode : null,
                            'street_label' => $this->streetLabel ?: null,
                            'street_num'   => $this->streetNum ?: null,
                        ],
                        'pack_count'   => 1,
                        'weight'       => $this->computeCartWeight(),
                        'description'  => 'Книги',
                        'cod' => [
                            'amount'   => $order->total,
                            'type'     => 'get',
                            'currency' => 'BGN',
                        ],
                    ];

                    $label = $labelService->validateThenCreate($labelInput);


                    $order->update([
                        'shipping_provider' => 'econt',
                        'shipping_payload'  => $label,
                    ]);

                    Cart::clear();
                    $this->dispatch('notify', message: 'Thank you! Your order has been placed. Econt label created.');
                    return $this->redirectRoute('thankyou', $order->id);
                } catch (\Throwable $e) {
                    report($e);
                    $this->addError('cart', 'Order placed, but Econt label failed: ' . $e->getMessage());
                    return;
                }
            }

            // Stripe
            if ($this->payment_method === 'stripe') {
                try {
                    $stripe = new StripeClient(config('services.stripe.secret'));

                    $computedWeight = $this->computeCartWeight();

                    $lineItems = array_map(function ($n) {
                        return [
                            'price_data' => [
                                'currency'     => 'bgn',
                                'product_data' => ['name' => $n['title']],
                                'unit_amount'  => (int) round($n['unit_price'] * 100),
                            ],
                            'quantity' => $n['quantity'],
                        ];
                    }, $normalized);

                    $session = $stripe->checkout->sessions->create([
                        'mode'                 => 'payment',
                        'payment_method_types' => ['card'],
                        'line_items'           => $lineItems,
                        'currency'             => 'bgn',
                        'customer_email'       => $this->email,
                        'metadata'             => [
                            'order_number'   => $order->order_number,
                            'order_id'       => (string) $order->id,

                            'shipping_method' => $this->shipping_method,
                            'city_id'        => $this->shipping_method === 'address' ? (string) ($this->cityId ?? '') : '',
                            'office_code'    => $this->shipping_method === 'econt_office' ? (string) ($this->officeCode ?? '') : '',
                            'street_label'   => (string) ($this->streetLabel ?? ''),
                            'street_num'     => (string) ($this->streetNum ?? ''),
                            'weight'         => (string) $computedWeight,
                            'customer_name'  => $this->name,
                            'customer_phone' => preg_replace('/\s+/', '', $this->phone),
                        ],
                        'success_url'          => route('thankyou', $order->id) . '?session_id={CHECKOUT_SESSION_ID}',
                        'cancel_url'           => route('checkout'),
                    ]);


                    return $this->redirect($session->url);
                } catch (\Throwable $e) {
                    report($e);
                    $this->addError('cart', 'Stripe is temporarily unavailable. Please try again later.');
                    return;
                }
            }

            // PayPal
            if ($this->payment_method === 'paypal') {
                try {
                    $pp = new PayPal();

                    // Convert BGN -> EUR
                    $eurTotal = round($order->total / 1.95583, 2);

                    $created = $pp->createOrder(
                        currency: 'EUR',
                        amount: $eurTotal,
                        returnUrl: route('thankyou', $order->id),
                        cancelUrl: route('checkout'),
                        metadata: ['local_order_id' => $order->id],
                        brandName: config('app.name', 'Store')
                    );

                    $approveUrl = PayPal::extractApproveLink($created);
                    if (!$approveUrl) {
                        $this->addError('cart', 'PayPal is temporarily unavailable.');
                        return;
                    }

                    return $this->redirect($approveUrl);
                } catch (\Throwable $e) {
                    report($e);
                    $this->addError('cart', 'PayPal is temporarily unavailable. Please try again later.');
                    return;
                }
            }


            // Fallback
            Cart::clear();
            $this->dispatch('notify', message: 'Thank you! Your order has been placed.');
            return $this->redirectRoute('thankyou', $order->id);
        });
    }

    public function render()
    {
        $subtotal = (float) Cart::total();
        $subtotalEur = (float) Cart::totalEur();
        $total = round($subtotal + $this->shippingCost, 2);
        $totalEur = round($subtotalEur + 0, 2);

        return view('livewire.pages.checkout', [
            'cart'          => Cart::all(),
            'subtotal'      => $subtotal,
            'subtotal_eur'  => $subtotalEur,
            'shippingCost'  => $this->shippingCost,
            'total'         => $total,
            'total_eur'     => $totalEur,
        ])->layout('layouts.app', [
            'title' => 'Checkout — Satori Co',
        ]);
    }



    private function generateOrderNumber(): string
    {
        $seq = (int) ((Order::max('id') ?? 0) + 1);
        return 'SO-' . now()->format('Y') . '-' . str_pad((string) $seq, 6, '0', STR_PAD_LEFT);
    }
}
