<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TmdbCountry.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TmdbMovie[] $movies
 * @property-read int|null $movies_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCountry newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCountry newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCountry query()
 * @mixin \Eloquent
 */
class TmdbCountry extends Model
{
    protected $guarded = [];

    public function movies()
    {
        return $this->belongsToMany('App\TmdbMovie', 'country_movie', 'country_id', 'movie_id');
    }
}
