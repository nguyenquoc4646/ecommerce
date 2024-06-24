<?php

namespace App\Listeners;

use App\Events\ForgotPassword;
use App\Mail\MailableForgotPassword;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
class ChangePasswordAfterForgot implements ShouldQueue
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
    public function handle(ForgotPassword $event): void
    {
        $user = $event->user;
        $mail = new MailableForgotPassword($user);
        Mail::to($user->email)->send($mail);
    }

}
