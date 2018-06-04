<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpcionContenido extends Model
{
    use SoftDeletes;

    protected $table = 'opciones_contenido';

    protected $fillable = ['contenido_id','data','indice','correcta'];

    /**
     * Belongs To Contenido
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function contenido() {
        return $this->belongsTo('App\Contenido');
    }
}
