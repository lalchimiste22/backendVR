<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recurso extends Model
{
    use SoftDeletes;

    protected $table = 'recursos';

    protected $fillable = ['codigo', 'nombre', 'descripcion'];

    /**
     * ManyToMany relation with User
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function overridedBy()
    {
        return $this->belongsToMany('App\User')->withPivot(['nombre','descripcion'])->withTimestamps();
    }
}
