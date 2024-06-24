<?php

namespace App\Listeners;

use App\Events\UpdateStatusOrderSuccess;
use App\Mail\SendMailableAfterUpdateStatusOrderSuccesss;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendMailUpdateStatusOrderSuccess implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(UpdateStatusOrderSuccess $event): void
    {
        $order = $event->order;
        $mail = new SendMailableAfterUpdateStatusOrderSuccesss($order);
        Mail::to($order->email)->send($mail);
    }
}
