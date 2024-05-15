<?php

namespace App\Policies;

use App\Models\Regimen;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class RegimenPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Regimen $regimen): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Regimen $regimen): bool
    {
    }

    public function delete(User $user, Regimen $regimen): bool
    {
    }

    public function restore(User $user, Regimen $regimen): bool
    {
    }

    public function forceDelete(User $user, Regimen $regimen): bool
    {
    }
}
