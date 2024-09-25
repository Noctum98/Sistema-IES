<?php

namespace App\Models\Ticket;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
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
        'url',
        'last_estado_ticket_id'
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
        return $this->belongsTo(User::class, 'user_id');
    }

    public function categoria(): BelongsTo
    {
        return $this->belongsTo(CategoriaTicket::class, 'categoria_id');
    }

    public function estados_ticket(): HasMany
    {
        return $this->hasMany(TicketEstadoTicket::class, 'ticket_id')->orderBy('created_at', 'desc');
    }

    public function last_estado_ticket(): BelongsTo
    {
        return $this->belongsTo(EstadoTicket::class,'last_estado_ticket_id');
    }


    public function derivaciones(): HasMany
    {
        return $this->hasMany(DerivacionTi::class);
    }

    public function last_derivacion(): HasOne
    {
        return $this->hasOne(DerivacionTicket::class)
        ->orderBy('created_at', 'desc')
        ->latestOfMany();
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
        return $this->hasMany(RespuestaTicket::class, 'ticket_id');
    }
}
