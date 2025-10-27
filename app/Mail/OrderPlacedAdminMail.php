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

        \Log::info('📦 Econt PDF DEBUG: build started', [
            'order' => $this->order->order_number,
            'pdf_url' => $pdfUrl,
        ]);

        if ($pdfUrl) {
            try {
                $pdfData = @file_get_contents($pdfUrl);
                $size = $pdfData ? strlen($pdfData) : 0;
                $startsWith = $pdfData ? substr($pdfData, 0, 10) : '';

                \Log::info('📦 Econt PDF DEBUG: file_get_contents result', [
                    'success' => $pdfData !== false,
                    'length' => $size,
                    'starts_with' => $startsWith,
                ]);

                if ($pdfData !== false && $size > 1000) {
                    $mail->attachData(
                        $pdfData,
                        'econt-label-'.$this->order->order_number.'.pdf',
                        ['mime' => 'application/pdf']
                    );

                    \Log::info('📎 Econt PDF DEBUG: attached successfully', [
                        'filename' => 'econt-label-'.$this->order->order_number.'.pdf',
                        'size' => $size,
                    ]);
                } else {
                    \Log::warning('⚠️ Econt PDF DEBUG: PDF not fetched or too small', [
                        'url' => $pdfUrl,
                        'length' => $size,
                    ]);
                }
            } catch (\Throwable $e) {
                \Log::error('💥 Econt PDF DEBUG: exception', [
                    'message' => $e->getMessage(),
                    'trace' => $e->getTraceAsString(),
                ]);
                report($e);
            }
        } else {
            \Log::warning('⚠️ Econt PDF DEBUG: No pdfURL found in order payload', [
                'order' => $this->order->order_number,
            ]);
        }

        \Log::info('✅ Econt PDF DEBUG: build complete', [
            'order' => $this->order->order_number,
        ]);

        return $mail;
    }
}
