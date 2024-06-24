<?php

namespace App\Providers;

use App\Events\ForgotPassword;
use App\Events\OrderSuccess;
use App\Events\RegisterSuccess;
use App\Events\UpdateStatusOrderSuccess;
use App\Listeners\ChangePasswordAfterForgot;
use App\Listeners\OrderSuccessSendMail;
use App\Listeners\sendMailOrderSuccess;
use App\Listeners\SendMailUpdateStatusOrderSuccess;
use App\Listeners\VerifyMailAfterRegisterSuccess;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        OrderSuccess::class => [
            sendMailOrderSuccess::class,
        ], // matching listener vào event

        RegisterSuccess::class=>[
            VerifyMailAfterRegisterSuccess::class
        ],
        ForgotPassword::class => [
            ChangePasswordAfterForgot::class
        ],
        UpdateStatusOrderSuccess::class => [
            SendMailUpdateStatusOrderSuccess::class
        ]

    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
