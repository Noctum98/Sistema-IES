<?php

namespace App\Policies;

use App\Models\AdminManager;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminManagerPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, AdminManager $adminManager): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, AdminManager $adminManager): bool
    {
    }

    public function delete(User $user, AdminManager $adminManager): bool
    {
    }

    public function restore(User $user, AdminManager $adminManager): bool
    {
    }

    public function forceDelete(User $user, AdminManager $adminManager): bool
    {
    }
}
