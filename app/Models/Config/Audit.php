<?php

namespace App\Models\Config;

use App\Models\AlumnoCarrera;
use App\Models\Proceso;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Audit extends Model
{
    use HasFactory;
    protected $table = 'audits';
    protected $fillable = ['table','table_id','user_id','changes','model','table_created_at','table_updated_at','table_deleted_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function proceso(): BelongsTo
    {
        return $this->belongsTo(Proceso::class,'table_id');
    }

    public function inscripcion(): BelongsTo
    {
        return $this->belongsTo(AlumnoCarrera::class,'table_id');
    }
}
