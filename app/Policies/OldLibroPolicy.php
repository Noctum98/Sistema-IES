<?php

namespace App\Policies;

use App\Models\OldLibro;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class OldLibroPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, OldLibro $oldLibro): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, OldLibro $oldLibro): bool
    {
    }

    public function delete(User $user, OldLibro $oldLibro): bool
    {
    }

    public function restore(User $user, OldLibro $oldLibro): bool
    {
    }

    public function forceDelete(User $user, OldLibro $oldLibro): bool
    {
    }
}
