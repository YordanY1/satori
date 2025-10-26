<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class OrderPlacedAdminMail extends Mailable
{
    use SerializesModels;

    public Order $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function build()
    {
        $mail = $this->subject('🛒 Нова поръчка: '.$this->order->order_number)
            ->from('support@izdatelstvo-satori.com', 'Издателство Сатори')
            ->to('info@izdatelstvo-satori.com')
            ->view('emails.orders.admin')
            ->with([
                'order' => $this->order,
            ]);

        $pdfUrl = data_get($this->order->shipping_payload, 'label.pdfURL');

        if ($pdfUrl) {
            try {
                $response = Http::get($pdfUrl);

                if ($response->ok()) {
                    $mail->attachData(
                        $response->body(),
                        'econt-label-'.$this->order->order_number.'.pdf',
                        ['mime' => 'application/pdf']
                    );
                }
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return $mail;
    }
}
