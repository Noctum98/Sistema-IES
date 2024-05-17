<?php

namespace App\Policies;

use App\Models\MasterMateria;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MasterMateriaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, MasterMateria $masterMateria): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, MasterMateria $masterMateria): bool
    {
    }

    public function delete(User $user, MasterMateria $masterMateria): bool
    {
    }

    public function restore(User $user, MasterMateria $masterMateria): bool
    {
    }

    public function forceDelete(User $user, MasterMateria $masterMateria): bool
    {
    }
}
