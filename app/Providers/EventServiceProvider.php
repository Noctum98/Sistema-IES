<?php

namespace App\Providers;

use App\Models\Alumno;
use App\Models\AlumnoCarrera;
use App\Models\Proceso;
use App\Observers\AlumnoCarreraObserver;
use App\Observers\AlumnoObserver;
use App\Observers\ProcesoObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        Login::class => [
            'App\Listeners\SaveRolesSession',
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Proceso::observe(ProcesoObserver::class);
        Alumno::observe(AlumnoObserver::class);
        AlumnoCarrera::observe(AlumnoCarreraObserver::class);
    }
}
