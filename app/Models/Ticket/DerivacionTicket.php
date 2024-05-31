<?php

namespace App\Models\Ticket;

use App\Models\Carrera;
use App\Models\Rol;
use App\Models\Sede;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DerivacionTicket extends Model
{
    use HasFactory;
    protected $table = 'derivaciones_tickets';
    protected $fillable = ['ticket_id','rol_id','sede_id','carrera_id','general'];


    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class,'ticket_id');
    }
    
    public function rol(): BelongsTo
    {
        return $this->belongsTo(Rol::class,'rol_id');
    }

    public function sede(): BelongsTo
    {
        return $this->belongsTo(Sede::class,'sede_id');
    }

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class,'carrera_id');
    }
}
