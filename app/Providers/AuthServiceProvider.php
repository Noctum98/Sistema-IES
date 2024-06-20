<?php

namespace App\Providers;

use App\Models\AdminManager;
use App\Models\AgrupadaMateria;
use App\Models\AvisoRole;
use App\Models\CorrelatividadAgrupada;
use App\Models\EstadoCarrera;
use App\Models\EstadoResoluciones;
use App\Models\Library;
use App\Models\MasterMateria;
use App\Models\MateriasCorrelativasCursado;
use App\Models\LibroDigital;
use App\Models\Regimen;
use App\Models\Resoluciones;
use App\Models\TipoCarrera;
use App\Policies\AdminManagerPolicy;
use App\Policies\AgrupadaMateriaPolicy;
use App\Policies\AvisoRolePolicy;
use App\Policies\CorrelatividadAgrupadaPolicy;
use App\Policies\EstadoCarreraPolicy;
use App\Policies\EstadoResolucionesPolicy;
use App\Policies\LibraryPolicy;
use App\Policies\MasterMateriaPolicy;
use App\Policies\MateriasCorrelativasCursadoPolicy;
use App\Policies\LibroDigitalPolicy;
use App\Policies\RegimenPolicy;
use App\Policies\resolucionesPolicy;
use App\Policies\TipoCarreraPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

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
        EstadoResoluciones::class => EstadoResolucionesPolicy::class,
        EstadoCarrera::class => EstadoCarreraPolicy::class,
        CorrelatividadAgrupada::class => CorrelatividadAgrupadaPolicy::class,
        AgrupadaMateria::class => AgrupadaMateriaPolicy::class,
        Library::class => LibraryPolicy::class,
        AdminManager::class => AdminManagerPolicy::class,
        LibroDigital::class => LibroDigitalPolicy::class,
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
