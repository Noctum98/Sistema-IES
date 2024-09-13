<?php

namespace App\Policies;

use App\Models\FolioNota;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FolioNotaPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {

    }

    public function view(User $user, FolioNota $folioNota): bool
    {
    }

    public function create(User $user): bool
    {
    }

    public function update(User $user, FolioNota $folioNota): bool
    {
    }

    public function delete(User $user, FolioNota $folioNota): bool
    {
    }

    public function restore(User $user, FolioNota $folioNota): bool
    {
    }

    public function forceDelete(User $user, FolioNota $folioNota): bool
    {
    }
}
