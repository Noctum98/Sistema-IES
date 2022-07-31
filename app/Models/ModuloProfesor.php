<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModuloProfesor extends Model
{
    use HasFactory;

    protected $table = "modulo_profesor";

    protected $fillable = ["user_id", "modulo_id"];

    public $timestamps = false;
}
