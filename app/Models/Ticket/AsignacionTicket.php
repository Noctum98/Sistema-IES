<?php

namespace App\Models\Ticket;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AsignacionTicket extends Model
{
    use HasFactory;
    protected $table = 'asignaciones_tickets';
    protected $fillable = ['user_id','derivacion_id','ticket_id','responsable'];


    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class,'ticket_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function derivacion(): BelongsTo
    {
        return $this->belongsTo(DerivacionTicket::class,'derivacion_id');
    }
}
