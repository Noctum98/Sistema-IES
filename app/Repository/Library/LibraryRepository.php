<?php

namespace App\Repository\Library;

use App\Models\Library;
use Illuminate\Database\Eloquent\Collection;
use LaravelIdea\Helper\App\Models\_IH_Library_C;

class LibraryRepository
{

    /**
     * @param int $orden
     * @return Collection
     */
    public function getLibrariesMayorIgualQue(int $orden): Collection
    {
        return Library::where('orden', '>=', $orden)->get();
    }

    /**
     * @param int $orden
     * @return array
     */
    public function getLibrariesIgualQue(int $orden):array
    {
        return Library::where(['orden' => ['>=', $orden]])->get();
    }

    /**
     * @return mixed
     */
    public function getLibrariesMax()
    {
        return Library::max('orden');
    }

}
