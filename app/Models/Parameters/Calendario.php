<?php

namespace App\Models\Parameters;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
    use HasFactory;
    protected $table = 'calendarios';
    protected $fillable = ['dia','mes','fecha','descripcion','tipo'];
}
