<?php

namespace App\Models\Ticket;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Nonstandard\Uuid;

class AsignacionTicket extends Model
{
    use HasFactory;
    protected $table = 'asignaciones_tickets';
    protected $fillable = ['user_id','derivacion_id','ticket_id','responsable','asignante_id'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) Uuid::uuid4()->toString();
        });
    }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class,'ticket_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function asignante(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function derivacion(): BelongsTo
    {
        return $this->belongsTo(DerivacionTicket::class,'derivacion_id');
    }
}
