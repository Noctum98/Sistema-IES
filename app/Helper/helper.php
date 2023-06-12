<?php

namespace App\Helper;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

trait helper
{
    public function userActual(): ?Authenticatable
    {
        return Auth::user();
    }
}
