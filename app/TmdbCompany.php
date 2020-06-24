<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TmdbCompany
 *
 * @property int $id
 * @property string $description
 * @property string $headquarters
 * @property string $homepage
 * @property string $logo_path
 * @property string $name
 * @property int $origin_country
 * @property int|null $parent_company
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\LocalCompany $local
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TmdbMovie[] $movies
 * @property-read int|null $movies_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCompany newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCompany newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCompany query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCompany whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCompany whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCompany whereHeadquarters($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCompany whereHomepage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCompany whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCompany whereLogoPath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCompany whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCompany whereOriginCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCompany whereParentCompany($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbCompany whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class TmdbCompany extends Model
{
    public $incrementing = false;

    protected $guarded = [];

    public function getOriginCountryAttribute()
    {
        return $this->belongsTo('App\TmdbCountry', 'origin_country', 'id');
    }

    public function getParentCompanyAttribute()
    {
        return $this->belongsTo('App\TmdbCompany', 'id', 'parent_company');
    }

    public function movies()
    {
        return $this->belongsToMany('App\TmdbMovie', 'genre_movie', 'company_id', 'movie_id');
    }

    public function local()
    {
        return $this->belongsTo('App\LocalCompany', 'id', 'id');
    }
}
