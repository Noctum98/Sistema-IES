<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Notifications\ResetPassword;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'nombre',
        'apellido',
        'email',
        'telefono',
        'rol',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function usersPersonal()
    {
        $users = User::whereDoesntHave('roles', function ($query) {
            return $query->where('nombre', 'alumno');
        })->orderBy('apellido', 'ASC')->paginate(20);

        return $users;
    }
    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class)->withTimestamps();
    }

    public function alumno()
    {
        $alumno = Alumno::where('user_id', Auth::user()->id)->first();
        if ($alumno) {
            return $alumno;
        }
        return false;
    }
    //============================ SEDES ====================================//
    public function sedes(){
        return $this->belongsToMany(Sede::class)->withTimestamps();
    }
    public function hasSede($sede)
    {

        if ($this->sedes->where('id', $sede)->first()) {
            return true;
        }
        return false;
    }
    //============================ CARRERAS ====================================//
    public function carreras()
    {
        return $this->belongsToMany(Carrera::class)->withTimestamps();
    }

    public function hasCarrera($carrera_id)
    {

        if ($this->carreras->where('id', $carrera_id)->first()) {
            return true;
        }
        return false;
    }


    //============================ MATERIAS ====================================//
    public function materias()
    {
        return $this->belongsToMany(Materia::class)->withTimestamps();
    }
    public function hasMateria($materia_id)
    {

        if ($this->materias->where('id', $materia_id)->first()) {
            return true;
        }
        return false;
    }
    //============================= ROLES ===================================//
    public function roles()
    {
        return $this->belongsToMany(Rol::class)->withTimestamps();
    }
    public function authorizeRoles($roles)
    {
        if($this->hasAnyRole($roles)){
            return true;
        }else{
            return false;
        }

    }
    public function hasAnyRole($roles)
    {
        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }
        } else {
            if ($this->hasRole($roles)) {
                 return true;
            }
        }
        return false;
    }

    public function hasRole($role)
    {

        if ($this->roles->where('nombre', $role)->first()) {
            return true;
        }
        return false;
    }
    //============================= CARGOS ===================================//
    public function cargos(){
        return $this->belongsToMany(Cargo::class)->withTimestamps();
    }
    public function hasCargo($cargo)
    {

        if ($this->sedes->where('id', $cargo)->first()) {
            return true;
        }
        return false;
    }
    //=
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
