<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    protected $table = 'personal';
    use HasFactory;

    public function sede(){
        return $this->belongsTo('App\Models\Sede','sede_id');
    }
}
