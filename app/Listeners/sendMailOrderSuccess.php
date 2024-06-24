<?php

namespace App\Listeners;

use App\Events\OrderSuccess;
use App\Mail\SendMailAfterOrderSuccess;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class sendMailOrderSuccess implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //order
    }

    /**
     * Handle the event.
     */
    public function handle(OrderSuccess $event): void
    {

        $orders = $event->orders;

        // Pass necessary data to the Mailable class
        $mail = new SendMailAfterOrderSuccess($orders);

        // Send the email
        Mail::to($orders->email)->send($mail);
    }
}
