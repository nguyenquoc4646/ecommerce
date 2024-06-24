<?php

namespace App\Listeners;

use App\Events\RegisterSuccess;
use App\Mail\RegisterMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class VerifyMailAfterRegisterSuccess implements ShouldQueue
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
    public function handle(RegisterSuccess $event): void // truyền vào đối tượng sự kiện để lấy ra thông tin user
    {
        $user = $event->user;
        $mail = new RegisterMail($user);
        Mail::to($user->email)->send($mail);
    }
}
