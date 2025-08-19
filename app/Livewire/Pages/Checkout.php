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

class Checkout extends Component
{
    // Default shipping method (can be "address" or "econt_office")
    public string $shipping_method = 'address';

    // --- City selection (structured from Econt directory) ---
    public string $citySearch = '';       // User input (search query)
    public ?int $cityId = null;           // Internal Econt city ID
    public string $cityLabel = '';        // Displayed label of the city
    public ?string $cityPostCode = null;  // City postal code
    public array $cityOptions = [];       // Autocomplete dropdown options

    // --- Customer basic info ---
    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $address = '';          // Address notes (floor, apt, etc.)
    public string $payment_method = 'cod'; // "cod", "stripe", or "paypal"

    // --- Econt office selection ---
    public string $officeSearch = '';
    public ?string $officeCode = null;    // Econt office code
    public string $officeLabel = '';
    public array $officeOptions = [];
    public bool $officeDropdownOpen = false;

    // --- Street selection (only after city is selected) ---
    public string $streetSearch = '';
    public ?int $streetId = null;         // Internal PK from our DB
    public ?int $streetCode = null;       // Econt street ID
    public string $streetLabel = '';
    public array $streetOptions = [];
    public string $streetNum = '';        // House/building number (can be "12A")

    /**
     * Validation rules depending on the selected shipping method.
     */
    protected function rules(): array
    {
        $base = [
            'name'            => 'required|string|min:3',
            'email'           => 'required|email',
            'phone'           => 'required|string|min:8',
            'payment_method'  => 'required|in:cod,stripe,paypal',
            'shipping_method' => 'required|in:econt_office,address',
        ];

        if ($this->shipping_method === 'address') {
            // Address delivery requires a city and address details
            $base['cityId']     = 'required|integer|min:1';
            $base['streetCode'] = 'nullable|integer|min:1'; // Some towns have no streets in Econt DB
            $base['streetNum']  = 'nullable|string|max:20';
            $base['address']    = 'required|string|min:5';  // Additional notes or fallback
        } else {
            // Office delivery requires office code
            $base['officeCode'] = 'required|string|min:1';
        }

        return $base;
    }

    /**
     * Called when the user switches shipping method.
     * Reset the irrelevant fields and open correct dropdown.
     */
    public function updatedShippingMethod(string $value): void
    {
        if ($value === 'address') {
            // Reset office-related fields
            $this->officeSearch = '';
            $this->officeCode   = null;
            $this->officeLabel  = '';
            $this->officeOptions = [];
            $this->officeDropdownOpen = false;

            // Reset city-related fields
            $this->citySearch = '';
            $this->cityId = null;
            $this->cityLabel = '';
            $this->cityPostCode = null;
            $this->cityOptions = [];

            $this->dispatch('focus-city-input');
        } else {
            // Reset address-related fields
            $this->address = '';
            $this->citySearch = '';
            $this->cityId = null;
            $this->cityLabel = '';
            $this->cityPostCode = null;
            $this->cityOptions = [];
            $this->officeDropdownOpen = true;
        }
    }

    /**
     * Helper to resolve the Econt directory service (dependency injection).
     */
    private function dir(): EcontDirectoryService
    {
        return app(EcontDirectoryService::class);
    }

    /**
     * Autocomplete search for Econt offices.
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
     * Select office from dropdown.
     */
    public function selectOffice($code, $label): void
    {
        $this->officeCode        = (string) $code;
        $this->officeLabel       = (string) $label;
        $this->officeSearch      = (string) $label;
        $this->officeOptions     = [];
        $this->officeDropdownOpen = false;

        $this->resetValidation('officeCode');
    }

    /**
     * Autocomplete search for cities.
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
     * Autocomplete search for streets (requires city).
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
     * Select street from dropdown.
     */
    public function selectStreet($id, $code, $label): void
    {
        $this->streetId    = (int) $id;
        $this->streetCode  = (int) $code;
        $this->streetLabel = (string) $label;
        $this->streetSearch = (string) $label;
        $this->streetOptions = [];

        $this->resetValidation(['streetCode']);
    }

    /**
     * Select city from dropdown.
     */
    public function selectCity($id, $label, $postCode = null): void
    {
        $this->cityId       = (int) $id;
        $this->cityLabel    = (string) $label;
        $this->cityPostCode = $postCode ? (string) $postCode : null;
        $this->citySearch   = (string) $label;
        $this->cityOptions  = [];

        $this->resetValidation(['cityId', 'address']);
    }

    /**
     * Main order placement logic.
     * - Validate form
     * - Create order and order items in DB
     * - Redirect to payment provider if needed
     */
    public function placeOrder()
    {
        $this->validate();

        if (Cart::count() === 0) {
            $this->addError('cart', 'The cart is empty.');
            return;
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
            $shipping = 0.00;
            $tax      = 0.00;
            $total    = $subtotal - $discount + $shipping + $tax;

            // Create the order record
            $order = Order::create([
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
            ]);

            // Create related order items
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
                            'name'        => $this->name,
                            'phone'       => preg_replace('/\s+/', '', $this->phone),
                            'city_id'     => $this->shipping_method === 'address' ? $this->cityId : null,
                            'office_code' => $this->shipping_method === 'econt_office' ? $this->officeCode : null,
                            'street_label' => $this->streetLabel,
                            'street_num'  => $this->streetNum,
                            'address_note' => $this->address,
                        ],
                        'pack_count'   => 1,
                        'weight'       => 1.0,
                        'description'  => 'Книги',
                        'cod' => [
                            'amount'   => $order->total,
                            'type'     => 'get',
                            'currency' => 'BGN',
                        ],
                    ];


                    $label = $labelService->submit($labelInput);

                    $order->update([
                        'shipping_provider' => 'econt',
                        'shipping_payload'  => json_encode($label),
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

            if ($this->payment_method === 'stripe') {
                try {
                    $stripe = new StripeClient(config('services.stripe.secret'));

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
                            'order_number' => $order->order_number,
                            'order_id'     => (string) $order->id,
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

            if ($this->payment_method === 'paypal') {
                try {
                    $pp = new PayPal();

                    // Convert BGN to EUR
                    $eurTotal = round($order->total / 1.95583, 2);

                    $created = $pp->createOrder(
                        currency: 'EUR',
                        amount: $eurTotal,
                        returnUrl: route('thankyou', $order->id),
                        cancelUrl: route('checkout'),
                        metadata: [
                            'order_number' => $order->order_number,
                            'orig_currency' => 'BGN',
                            'orig_total'    => number_format($order->total, 2, '.', ''),
                        ],
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

            // Fallback: mark as placed
            Cart::clear();
            $this->dispatch('notify', message: 'Thank you! Your order has been placed.');
            return $this->redirectRoute('thankyou', $order->id);
        });
    }

    /**
     * Render the checkout view.
     */
    public function render()
    {
        return view('livewire.pages.checkout', [
            'cart'  => Cart::all(),
            'total' => Cart::total(),
        ])->layout('layouts.app', [
            'title' => 'Checkout — Satori Co',
        ]);
    }

    /**
     * Generate unique order number (sequential per year).
     */
    private function generateOrderNumber(): string
    {
        $seq = (int) ((Order::max('id') ?? 0) + 1);
        return 'SO-' . now()->format('Y') . '-' . str_pad((string) $seq, 6, '0', STR_PAD_LEFT);
    }
}
