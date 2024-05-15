<?php

namespace App\Policies;

use App\Models\Resoluciones;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class resolucionesPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Resoluciones $resoluciones): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Resoluciones $resoluciones): bool
    {
    }

    public function delete(User $user, Resoluciones $resoluciones): bool
    {
    }

    public function restore(User $user, Resoluciones $resoluciones): bool
    {
    }

    public function forceDelete(User $user, Resoluciones $resoluciones): bool
    {
    }
}
