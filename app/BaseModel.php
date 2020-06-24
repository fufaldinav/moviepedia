<?php

namespace App;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

abstract class BaseModel extends Model
{
    public $incrementing = false;

    protected $guarded = [
        'created_at', 'updated_at',
    ];

    protected static $tmdbModelClassName;

    protected static function getTmdbModelClassBaseName()
    {
        return 'Tmdb'.class_basename(static::class);
    }

    protected static function getTmdbModelClassName()
    {
        return Str::replaceLast(class_basename(static::class), static::getTmdbModelClassBaseName(), static::class);
    }

    protected static function hasTmdbModel()
    {
        return class_exists(static::$tmdbModelClassName);
    }

    public function tmdb()
    {
        if (static::hasTmdbModel()) {
            return $this->hasOne(static::$tmdbModelClassName, 'id', 'id');
        }
    }

    protected static function booted()
    {
        parent::booted();

        static::$tmdbModelClassName = static::getTmdbModelClassName();

        if (static::hasTmdbModel()) {
            static::addGlobalScope('tmdb', function (Builder $builder) {
                $builder->with('tmdb');
            });
        }

        static::retrieved(function ($baseModel) {
            if (! is_null($baseModel->tmdb()) && ! $baseModel->tmdb()->exists()) {
                $baseModel->tmdb()->create([$baseModel->getKeyName() => $baseModel->getKey()]);
            }
        });
    }
}
