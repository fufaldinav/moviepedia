<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TmdbGenre
 *
 * @property int $id
 * @property string $name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TmdbMovie[] $movies
 * @property-read int|null $movies_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbGenre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbGenre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbGenre query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbGenre whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbGenre whereName($value)
 * @mixin \Eloquent
 */
class TmdbGenre extends Model
{
    protected $guarded = [];

    public function movies()
    {
        return $this->belongsToMany('App\TmdbMovie', 'genre_movie', 'genre_id', 'movie_id');
    }
}
