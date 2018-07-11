<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contenido extends Model
{
    use SoftDeletes;

    protected $table = 'contenidos';

    protected $fillable = ['tipo','data','indice','recurso_id'];

    /**
     * Belongs To Recurso
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function recurso() {
        return $this->belongsTo('App\Recurso');
    }

    /**
     * Has Many OpcionContenido
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function opciones(){
        return $this->hasMany('App\OpcionContenido');
    }

    public function getTypeDisplayName() {
        switch($this->attributes['tipo'])
        {
            case 'texto':
                return 'Texto';
            case 'pregunta':
                return 'Pregunta';
            case 'vof':
                return 'Verdadero/Falso';
            case'pares':
                return 'Unir Pares';
            default:
                return 'unknown';
        }
    }
}
