<?php

namespace App\Mail;

use App\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\App;

class OrderShipped extends Mailable
{
    use Queueable, SerializesModels;


    /**
     * The order instance.
     *
     * @var Order
     */
    protected $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
//        return $this->from('example@example.com')
//            ->view('emails.orders.shipped');

//        return $this->view('mail.useremail')
//            ->with([
//                'productName' => $this->order->name,
//                'orderPrice' => $this->order->price,
//            ]);

        return $this->from('azam.arid1144@gmail.com')
            ->view('mail.useremail')
            ->with([
                'productName' => $this->order->name,
                'orderPrice' => $this->order->price,
            ]);

    }
}
