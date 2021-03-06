<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sede extends Model
{
    use HasFactory;
    
    public function carreras(){
        return $this->hasMany('App\Models\Carrera');
    }

    public function users(){
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
