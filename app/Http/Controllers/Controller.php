<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @param bool $withName
     * @return array
     */
    public function getSedes( bool $withName = false ): array
    {
        $user = auth()->user();
        if($withName) {
            return $user->sedes->pluck('nombre', 'id')->all();
        }


        return $user->sedes->pluck('id')->toArray();
    }
}
