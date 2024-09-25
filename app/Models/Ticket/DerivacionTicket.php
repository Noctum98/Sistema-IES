<?php
namespace App\Models\Ticket;

use App\Models\Carrera;
use App\Models\Rol;
use App\Models\Sede;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Ramsey\Uuid\Nonstandard\Uuid;

class DerivacionTicket extends Model
{
    use HasFactory;
    protected $table = 'derivaciones_tickets';
    protected $fillable = ['ticket_id','operador_id','rol_id','sede_id','carrera_id','general','activa'];

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
    
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class,'rol_id');
    }

    public function operador(): BelongsTo
    {
        return $this->belongsTo(User::class,'operador_id');
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class,'sede_id');
    }

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class,'carrera_id');
    }

    public function asignaciones(): HasMany
    {
        return $this->hasMany(AsignacionTicket::class,'derivacion_id')->orderBy('responsable','desc');
    }

    public function responsable(): HasOne
    {
        return $this->hasOne(AsignacionTicket::class, 'derivacion_id')->where('responsable', true)->latest();
    }
}
