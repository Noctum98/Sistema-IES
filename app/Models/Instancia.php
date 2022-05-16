<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instancia extends Model
{
    use HasFactory;
    protected $table = 'instancias';
    protected $fillable = ['nombre','tipo','estado','cierre','limite','segundo_llamado'];
}
