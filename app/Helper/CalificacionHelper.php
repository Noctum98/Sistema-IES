<?php

namespace App\Helper;

class CalificacionHelper
{

    /**
     * Formatea el color de una nota basado en su valor.
     *
     * @param float $value El valor de la nota.
     * @return string El color formateado de la nota.
     */
    public function formatoColorNota(float $value): string
    {
        $textClass = 'text-info';
        $displayValue = $value;

        if ($value < 0) {
            $textClass = 'text-danger';
            $displayValue = 'A';
        } elseif ($value < 4) {
            $textClass = 'text-danger';
        } elseif ($value > 4) {
            $textClass = 'text-success';
        }

        return "<span class='$textClass bg-white p-1'>$displayValue</span>";
    }
}
