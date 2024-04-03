<?php

namespace App\Policies;

use App\Models\MateriasCorrelativasCursado;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MateriasCorrelativasCursadoPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, MateriasCorrelativasCursado $materiasCorrelativasCursado): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, MateriasCorrelativasCursado $materiasCorrelativasCursado): bool
    {
    }

    public function delete(User $user, MateriasCorrelativasCursado $materiasCorrelativasCursado): bool
    {
    }

    public function restore(User $user, MateriasCorrelativasCursado $materiasCorrelativasCursado): bool
    {
    }

    public function forceDelete(User $user, MateriasCorrelativasCursado $materiasCorrelativasCursado): bool
    {
    }
}
