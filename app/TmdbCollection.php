<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TmdbCollection.
 *
 * @property int $id
 * @property string $name
 * @property string $overview
 * @property string $poster_path
 * @property string $backdrop_path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\LocalCollection $local
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TmdbMovie[] $movies
 * @property-read int|null $movies_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCollection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCollection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCollection query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCollection whereBackdropPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCollection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCollection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCollection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCollection whereOverview($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCollection wherePosterPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCollection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TmdbCollection extends Model
{
    public $incrementing = false;

    protected $guarded = [];

    public function movies()
    {
        return $this->hasMany('App\TmdbMovie', 'collection_id', 'id');
    }

    public function local()
    {
        return $this->belongsTo('App\LocalCollection', 'id', 'id');
    }
}
