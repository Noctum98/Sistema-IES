<?php

namespace App\Models\Trianual;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacionesTrianual extends Model
{
    use HasFactory;
    protected $fillable = [
      'trianual_id',
      'year',
      'observaciones',
      'operador_id'
    ];
}
