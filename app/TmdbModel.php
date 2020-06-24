<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class TmdbModel extends Model
{
    public $incrementing = false;

    protected static $baseModelClassName;

    protected static function getBaseModelClassBaseName()
    {
        return Str::afterLast('Tmdb', class_basename(static::class));
    }

    protected static function getBaseModelClassName()
    {
        return Str::replaceLast(class_basename(static::class), static::getBaseModelClassBaseName(), static::class);
    }

    public function base()
    {
        return $this->belongsTo(static::$baseModelClassName, 'id', 'id');
    }

    protected static function booted()
    {
        parent::booted();

        static::$baseModelClassName = static::getBaseModelClassName();
    }
}
