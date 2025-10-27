<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

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
                $pdfData = @file_get_contents($pdfUrl);

                if ($pdfData !== false && strlen($pdfData) > 1000) {
                    $mail->attachData(
                        $pdfData,
                        'econt-label-'.$this->order->order_number.'.pdf',
                        ['mime' => 'application/pdf']
                    );
                } else {
                    \Log::warning('Econt PDF not fetched or empty', ['url' => $pdfUrl]);
                }
            } catch (\Throwable $e) {
                report($e);
            }
        }

        return $mail;
    }
}
