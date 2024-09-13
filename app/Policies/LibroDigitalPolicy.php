<?php

namespace App\Policies;

use App\Models\LibroDigital;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LibroDigitalPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, LibroDigital $libroDigital): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, LibroDigital $libroDigital): bool
    {
    }

    public function delete(User $user, LibroDigital $libroDigital): bool
    {
    }

    public function restore(User $user, LibroDigital $libroDigital): bool
    {
    }

    public function forceDelete(User $user, LibroDigital $libroDigital): bool
    {
    }
}
