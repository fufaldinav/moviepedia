<?php

namespace App;

/**
 * App\LocalMovie
 *
 * @property int $id
 * @property bool $adult
 * @property string $original_title
 * @property float $popularity
 * @property bool $video
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 * @property-read \App\TmdbMovie|null $tmdb
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalMovie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalMovie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalMovie query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalMovie whereAdult($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalMovie whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalMovie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalMovie whereOriginalTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalMovie wherePopularity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalMovie whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalMovie whereVideo($value)
 * @mixin \Eloquent
 */
class LocalMovie extends LocalObject
{
    protected $casts = [
        'adult' => 'boolean',
        'popularity' => 'float',
        'video' => 'boolean',
    ];

    public function tmdb()
    {
        return $this->hasOne('App\TmdbMovie', 'id', 'id');
    }
}
