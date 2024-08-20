<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Libro extends Model
{
    use HasFactory;
    protected $table = 'libros';
    protected $fillable = ['mesa_id','llamado','numero','folio','orden'];

    public function mesa(): BelongsTo
    {
        return $this->belongsTo(Mesa::class,'mesa_id');
    }
    public function actasVolantes(): HasMany
    {
        return $this->hasMany(ActaVolante::class,'libro_id');
    }

}
