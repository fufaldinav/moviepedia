<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TmdbLanguage.
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TmdbMovie[] $movies
 * @property-read int|null $movies_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbLanguage query()
 * @mixin \Eloquent
 */
class TmdbLanguage extends Model
{
    protected $guarded = [];

    public function movies()
    {
        return $this->belongsToMany('App\TmdbMovie', 'language_movie', 'language_id', 'movie_id');
    }
}
