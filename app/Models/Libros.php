<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Libros extends Model
{


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'libros';

    /**
     * The database primary key value.
     *
     * @var string
     */
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'folio',
        'llamado',
        'mesa_id',
        'numero',
        'orden'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];


    /**
     * Get the mesa that owns the Libros
     *
     * @return BelongsTo
     */
    public function mesa(): BelongsTo
    {
        return $this->belongsTo(Mesa::class, 'mesa_id');
    }


    /**
     * Get created_at in array format
     *
     * @param string $value
     * @return string
     */
    public function getCreatedAtAttribute(string $value): string
    {
        return DateTime::createFromFormat($this->getDateFormat(), $value)->format('d/m/Y H:i:s');
    }

    /**
     * Get updated_at in array format
     *
     * @param string $value
     * @return string
     */
    public function getUpdatedAtAttribute(string $value): string
    {
        return DateTime::createFromFormat($this->getDateFormat(), $value)->format('d/m/Y H:i:s');
    }

}
