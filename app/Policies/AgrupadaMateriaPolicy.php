<?php

namespace App\Policies;

use App\Models\AgrupadaMateria;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AgrupadaMateriaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, AgrupadaMateria $agrupadaMateria): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, AgrupadaMateria $agrupadaMateria): bool
    {
    }

    public function delete(User $user, AgrupadaMateria $agrupadaMateria): bool
    {
    }

    public function restore(User $user, AgrupadaMateria $agrupadaMateria): bool
    {
    }

    public function forceDelete(User $user, AgrupadaMateria $agrupadaMateria): bool
    {
    }
}
