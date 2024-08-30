<?php

namespace App\Policies;

use App\Models\MesaFolio;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MesaFolioPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, MesaFolio $mesaFolio): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, MesaFolio $mesaFolio): bool
    {
    }

    public function delete(User $user, MesaFolio $mesaFolio): bool
    {
    }

    public function restore(User $user, MesaFolio $mesaFolio): bool
    {
    }

    public function forceDelete(User $user, MesaFolio $mesaFolio): bool
    {
    }
}
