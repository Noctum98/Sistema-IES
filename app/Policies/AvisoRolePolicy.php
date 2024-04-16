<?php

namespace App\Policies;

use App\Models\AvisoRole;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AvisoRolePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, AvisoRole $avisoRole): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, AvisoRole $avisoRole): bool
    {
    }

    public function delete(User $user, AvisoRole $avisoRole): bool
    {
    }

    public function restore(User $user, AvisoRole $avisoRole): bool
    {
    }

    public function forceDelete(User $user, AvisoRole $avisoRole): bool
    {
    }
}
