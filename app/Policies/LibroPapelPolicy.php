<?php

namespace App\Policies;

use App\Models\LibroPapel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LibroPapelPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, LibroPapel $libroPapel): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, LibroPapel $libroPapel): bool
    {
    }

    public function delete(User $user, LibroPapel $libroPapel): bool
    {
    }

    public function restore(User $user, LibroPapel $libroPapel): bool
    {
    }

    public function forceDelete(User $user, LibroPapel $libroPapel): bool
    {
    }
}
