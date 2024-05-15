<?php

namespace App\Providers;

use App\Models\AvisoRole;
use App\Models\MasterMateria;
use App\Models\MateriasCorrelativasCursado;
use App\Models\Regimen;
use App\Models\Resoluciones;
use App\Models\TipoCarrera;
use App\Policies\AvisoRolePolicy;
use App\Policies\MasterMateriaPolicy;
use App\Policies\MateriasCorrelativasCursadoPolicy;
use App\Policies\RegimenPolicy;
use App\Policies\resolucionesPolicy;
use App\Policies\TipoCarreraPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        MateriasCorrelativasCursado::class => MateriasCorrelativasCursadoPolicy::class,
        AvisoRole::class => AvisoRolePolicy::class,
        Resoluciones::class => resolucionesPolicy::class,
        TipoCarrera::class => TipoCarreraPolicy::class,
        Regimen::class => RegimenPolicy::class,
        MasterMateria::class => MasterMateriaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
