<?php

namespace App;

/**
 * App\LocalCompany.
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\TmdbCompany|null $tmdb
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalCompany query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalCompany whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalCompany whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalCompany whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LocalCompany extends LocalObject
{
    public function tmdb()
    {
        return $this->hasOne('App\TmdbCompany', 'id', 'id');
    }
}
