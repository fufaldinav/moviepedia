<?php

namespace App;

/**
 * App\LocalCollection.
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\TmdbCollection|null $tmdb
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalCollection newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalCollection newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalCollection query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalCollection whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalCollection whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalCollection whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalCollection whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LocalCollection extends LocalObject
{
    public function tmdb()
    {
        return $this->hasOne('App\TmdbCollection', 'id', 'id');
    }
}
