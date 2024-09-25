<?php

namespace App\Models\Ticket;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Ramsey\Uuid\Uuid;

class TicketEstadoTicket extends Model
{
    use HasFactory;
    protected $table = 'ticket_estado_ticket';
    protected $fillable = ['ticket_id','from_estado_ticket_id','to_estado_ticket_id','user_id'];


    public function toEstadoTicket():BelongsTo
    {
        return $this->belongsTo(EstadoTicket::class,'to_estado_ticket_id');
    }

    public function fromEstadoTicket():BelongsTo
    {
        return $this->belongsTo(EstadoTicket::class,'from_estado_ticket_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

}
