<?php

namespace App\Policies;

use App\Models\CorrelatividadAgrupada;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CorrelatividadAgrupadaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, CorrelatividadAgrupada $correlatividadAgrupada): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, CorrelatividadAgrupada $correlatividadAgrupada): bool
    {
    }

    public function delete(User $user, CorrelatividadAgrupada $correlatividadAgrupada): bool
    {
    }

    public function restore(User $user, CorrelatividadAgrupada $correlatividadAgrupada): bool
    {
    }

    public function forceDelete(User $user, CorrelatividadAgrupada $correlatividadAgrupada): bool
    {
    }
}
