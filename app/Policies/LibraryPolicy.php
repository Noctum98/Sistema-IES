<?php

namespace App\Policies;

use App\Models\Library;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LibraryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, Library $library): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, Library $library): bool
    {
    }

    public function delete(User $user, Library $library): bool
    {
    }

    public function restore(User $user, Library $library): bool
    {
    }

    public function forceDelete(User $user, Library $library): bool
    {
    }
}
