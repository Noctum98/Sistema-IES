<?php

namespace App\Policies;

use App\Models\EstadoCarrera;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EstadoCarreraPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, EstadoCarrera $estadoCarrera): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, EstadoCarrera $estadoCarrera): bool
    {
    }

    public function delete(User $user, EstadoCarrera $estadoCarrera): bool
    {
    }

    public function restore(User $user, EstadoCarrera $estadoCarrera): bool
    {
    }

    public function forceDelete(User $user, EstadoCarrera $estadoCarrera): bool
    {
    }
}
