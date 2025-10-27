<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderPlacedCustomerMail extends Mailable
{
    use SerializesModels;

    public function __construct(public Order $order) {}

    public function build()
    {
        return $this->subject('🧾 Вашата поръчка №'.$this->order->order_number)
            ->from('support@izdatelstvo-satori.com', 'Издателство Сатори')
            ->to($this->order->customer_email)
            ->view('emails.orders.customer')
            ->with([
                'order' => $this->order,
            ]);
    }
}
