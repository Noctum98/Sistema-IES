<?php

namespace App\Models\Ticket;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Ticket extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tickets';

    /**
    * The database primary key value.
    *
    * @var string
    */
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::uuid4()->toString();
        });
    }

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
                  'user_id',
                  'estado_id',
                  'categoria_id',
                  'asunto',
                  'descripcion',
                  'captura',
                  'url'
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
     * Get the user for this model.
     *
     * @return App\Models\User
     */
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    /**
     * Get the estado for this model.
     *
     * @return App\Models\Estado
     */
    public function estado()
    {
        return $this->belongsTo(EstadoTicket::class,'estado_id');
    }

    public function derivaciones(): HasMany
    {
        return $this->hasMany(DerivacionTicket::class);
    }

    public function derivacion(): HasOne
    {
        return $this->hasOne(DerivacionTicket::class);
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(AsignacionTicket::class);
    }

    public function responsable(): HasOne
    {
        return $this->hasOne(AsignacionTicket::class)->where('responsable', true)->latest();
    }

    public function respuestas(): HasMany
    {
        return $this->hasMany(RespuestaTicket::class,'ticket_id');
    }

}
