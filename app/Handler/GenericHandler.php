<?php

namespace App\Handler;

class GenericHandler
{
    public function convertirNumberToRoman($numero): string
    {
        $mapa = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $resultadoRomanos = '';
        foreach ($mapa as $romano => $valor) {
            $matches = (int)($numero / $valor);
            $resultadoRomanos .= str_repeat($romano, $matches);
            $numero %= $valor;
        }
        return $resultadoRomanos;
    }
}
