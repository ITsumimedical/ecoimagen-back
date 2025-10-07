<?php

namespace App\Providers;

use App\Events\EnviarKeiron;
use App\Events\FacturaCreadaEvent;
use App\Events\OrdenDispensada;
use App\Listeners\EnviarFacturaDianListener;
use App\Listeners\NotificacionConsultaKeiron;
use App\Listeners\NotificarOrdenDispensada;
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
        'App\Events\SendMenssageBitacoraEvent' => [
            'App\Listeners\SendMenssageBitacoraListener',
        ],
        EnviarKeiron::class => [
            NotificacionConsultaKeiron::class,
        ],
        OrdenDispensada::class => [
            NotificarOrdenDispensada::class,
        ],
        FacturaCreadaEvent::class => [
            EnviarFacturaDianListener::class,
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
