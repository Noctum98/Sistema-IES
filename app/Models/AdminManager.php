<?php

namespace App\Models;

use DateTime;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class AdminManager extends Model
{

    use SoftDeletes, HasFactory;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'admin_managers';

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
            $model->{$model->getKeyName()} = (string)Uuid::uuid4();
        });
    }


    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = [
        'enabled',
        'icon',
        'link',
        'model',
        'name'
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
     * Get deleted_at in array format
     *
     * @param string|null $value
     * @return string|null
     */
    public function getDeletedAtAttribute(string $value = null): ?string
    {
        if (!$value) {
            return $value;
        }
        return DateTime::createFromFormat($this->getDateFormat(), $value)->format('d/m/Y H:i:s');
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
