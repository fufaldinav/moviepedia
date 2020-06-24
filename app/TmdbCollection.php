<?php

namespace App;

use Tmdb\Laravel\Facades\Tmdb;

class TmdbCollection extends TmdbModel
{
    protected $fillable = [
        'id', 'name', 'overview', 'poster_path', 'backdrop_path',
    ];

    protected static $api;

    protected static function booted()
    {
        parent::booted();

        static::$api = Tmdb::getCollectionsApi();

        static::creating(function ($collection) {
            foreach (static::$api->getCollection($collection->getKey()) as $key => $value) {
                $collection->setAttribute($key, $value);
            }
        });
    }

    public function movies()
    {
        return $this->hasMany('App\TmdbMovie', 'belongs_to_collection', 'id');
    }
}
