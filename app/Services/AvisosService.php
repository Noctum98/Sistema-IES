<?php

namespace App\Services;

use App\Models\Aviso;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AvisosService
{

    public function getAvisos() {

        $avisos = [];
        $now = Carbon::now();

        $avisos_todos = Aviso::where('visible_desde', '<=', $now)
            ->where('visible_hasta', '>=', $now)
            ->where('todos', true)
            ->where('disabled', false)
            ->get();

        $roles_id = Auth::user()->roles->pluck('id');
        $avisos_roles = Aviso::whereHas('roles', function($q) use ($roles_id) {
            $q->whereIn('rol_id', $roles_id);
        })
            ->where('visible_desde', '<=', $now)
            ->where('visible_hasta', '>=', $now)
            ->where('disabled', false)
            ->get();

        return $avisos_todos->merge($avisos_roles)->unique();
    }
}
