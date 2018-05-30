<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nombre', 'email', 'password', 'avatar', 'descripcion'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->id == 1;
    }

    /**
     * ManyToMany relation with Recurso
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function recursoOverrides()
    {
        return $this->hasMany('App\RecursoOverride');
    }


    /**
     * Has Many Jugadores
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jugadores()
    {
        return $this->hasMany('App\Jugador');
    }
}
