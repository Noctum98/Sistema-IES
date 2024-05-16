<?php

namespace App\Policies;

use App\Models\EstadoResoluciones;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstadoResolucionesPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, EstadoResoluciones $estadoResoluciones): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, EstadoResoluciones $estadoResoluciones): bool
    {
    }

    public function delete(User $user, EstadoResoluciones $estadoResoluciones): bool
    {
    }

    public function restore(User $user, EstadoResoluciones $estadoResoluciones): bool
    {
    }

    public function forceDelete(User $user, EstadoResoluciones $estadoResoluciones): bool
    {
    }
}
