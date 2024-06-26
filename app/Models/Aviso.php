<?php

namespace App\Models;

use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Aviso extends Model
{
    use HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'avisos';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'creador_id',
        'mensaje',
        'visible_desde',
        'visible_hasta',
        'disabled',
        'todos'
    ];

    protected $casts = [
        'disabled' => 'boolean',
        'todos' => 'boolean',
    ];

    protected $dates = [
        'visible_desde' => 'datetime',
        'visible_hasta' => 'datetime',
    ];

    public function creador(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creador_id');
    }


    /**
     * @return BelongsTo
     */
    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creador_id', 'id');
    }

    /**
     * Set the visible_desde.
     *
     * @param string $value
     * @return void
     */
    public function setVisibleDesdeAttribute(string $value)
    {

        $this->attributes['visible_desde'] = !empty($value) ? DateTime::createFromFormat('Y-m-d H:i:s', $value) : null;
    }

    /**
     * Set the visible_hasta.
     *
     * @param string $value
     * @return void
     */
    public function setVisibleHastaAttribute(string $value)
    {
        $this->attributes['visible_hasta'] = !empty($value) ? DateTime::createFromFormat('Y-m-d H:i:s', $value) : null;
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


    /**
     * @return string
     */
    public function getVisibleDesdeAttribute(): string
    {

        return DateTime::createFromFormat($this->getDateFormat(), $this->attributes['visible_desde'])->format('d-m-Y H:i');
    }

    /**
     * Get visible_hasta in array format
     *
     */
    public function getVisibleHastaAttribute(): string
    {
        return DateTime::createFromFormat($this->getDateFormat(), $this->attributes['visible_hasta'])->format('d-m-Y H:i');
    }


    /**
     * @return HasMany
     */
    public function roles(): HasMany
    {
        return $this->hasMany(AvisoRole::class, 'aviso_id', 'id');
    }

    public function getRoles(): string
    {
        $roles = $this->roles()->get();
        $tableRoles = "";
        foreach ($roles as $role) {
            $tableRoles .= '<i class="fa-solid fa-check text-success"></i> ' . ucfirst($role->rol->nombre);
        }
        return $tableRoles;
    }

    public function getTodos(): string
    {

        if ($this->todos) {
            return '<i class="fa-solid fa-check text-success"></i> Todos';
        }
        return '';

    }

    public function getActivo(): string
    {

        if (!$this->disabled) {
            return '<i class="fa-solid fa-times text-danger"></i> No';
        }
        return '<i class="fa-solid fa-check text-danger"></i> Si';

    }

    public function isVencido(): bool
    {

        if ($this->visible_hasta < Carbon::now()->format('d-m-Y H:i')) {
            return true;
        }
        return false;
    }

}
