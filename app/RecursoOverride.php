<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RecursoOverride extends Model
{
    use SoftDeletes;

    protected $table = 'recurso_overrides';

    protected $fillable = ['nombre','descripcion','user_id','recurso_id'];

    /**
     * Belongs To User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo('App\User');
    }

    /**
     * Belongs To Recurso
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recurso() {
        return $this->belongsTo('App\Recurso');
    }

    public function jugadores() {
        return $this->belongsToMany('App\Jugador','jugadores_recurso_overrides');
    }
}
