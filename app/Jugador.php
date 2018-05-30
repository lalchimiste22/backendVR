<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Jugador extends Model
{
    use SoftDeletes;

    protected $table = 'jugadores';

    protected $fillable = ['nombre','user_id'];

    /**
     * Belongs To User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function usuario() {
        return $this->belongsTo('App\User');
    }

    public function overrides() {
        return $this->belongsToMany('App\RecursoOverride','jugadores_recurso_overrides');
    }
}
