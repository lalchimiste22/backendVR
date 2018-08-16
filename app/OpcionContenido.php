<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OpcionContenido extends Model
{
    use SoftDeletes;

    public static $TIPO_TEXTO = 'texto';
    public static $TIPO_PREGUNTA = 'pregunta';
    public static $TIPO_VOF = 'vof';
    public static $TIPO_PARES = 'pares';

    public static $SUBTIPO_TXT = 'txt';
    public static $SUBTIPO_IMG = 'img';

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

    /**
     * @return bool
     */
    public function containsImageOnPrimaryData()
    {
        if($this->tipo !== self::$TIPO_PARES)
            return false;

        $subtipos = explode('|',$this->tipo);
        $subtipos = explode('-', $subtipos[1]);

        return $subtipos[0] === 'img' && strlen($this->data) > 0;
    }

    /**
     * @return bool
     */
    public function containsImageOnSecondaryData()
    {
        if($this->tipo !== self::$TIPO_PARES)
            return false;

        $subtipos = explode('|',$this->tipo);
        $subtipos = explode('-', $subtipos[1]);

        return $subtipos[1] === 'img' && strlen($this->data_secundaria) > 0;
    }
}
