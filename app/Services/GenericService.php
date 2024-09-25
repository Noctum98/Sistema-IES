<?php

namespace App\Services;

class GenericService
{

    /**
     * @param $str
     * @return string|null
     */
    public function findNumber($str): ?string
    {
        if ($str === '-') {
            return null;
        }
        preg_match('/(^-?\d+)|(\d+)/', $str, $matches);
        return $matches[0] ?? null;
    }
}
