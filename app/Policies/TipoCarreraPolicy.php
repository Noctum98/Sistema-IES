<?php

namespace App\Policies;

use App\Models\TipoCarrera;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TipoCarreraPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, TipoCarrera $tipoCarrera): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, TipoCarrera $tipoCarrera): bool
    {
    }

    public function delete(User $user, TipoCarrera $tipoCarrera): bool
    {
    }

    public function restore(User $user, TipoCarrera $tipoCarrera): bool
    {
    }

    public function forceDelete(User $user, TipoCarrera $tipoCarrera): bool
    {
    }
}
