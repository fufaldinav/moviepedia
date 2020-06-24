<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\TmdbMovie
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TmdbGenre[] $genres
 * @property-read int|null $genres_count
 * @property-read mixed $belongs_to_collection
 * @property-read mixed $original_language
 * @property-read \App\LocalMovie $local
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TmdbCompany[] $productionCompanies
 * @property-read int|null $production_companies_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TmdbCountry[] $productionCountries
 * @property-read int|null $production_countries_count
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\TmdbLanguage[] $spokenLanguages
 * @property-read int|null $spoken_languages_count
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbMovie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbMovie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\TmdbMovie query()
 * @mixin \Eloquent
 */
class TmdbMovie extends Model
{
    public $incrementing = false;

    protected $guarded = [];

    protected $casts = [
        'adult' => 'boolean',
        'budget' => 'integer',
        'popularity' => 'float',
        'release_date' => 'date',
        'revenue' => 'integer',
        'runtime' => 'integer',
        'video' => 'boolean',
        'vote_average' => 'float',
        'vote_count' => 'integer',
    ];

    public function getBelongsToCollectionAttribute()
    {
        return $this->belongsTo('App\TmdbCollection', 'belongs_to_collection', 'id');
    }

    public function productionCompanies()
    {
        return $this->belongsToMany('App\TmdbCompany', 'company_movie', 'movie_id', 'company_id');
    }

    public function genres()
    {
        return $this->belongsToMany('App\TmdbGenre', 'genre_movie', 'movie_id', 'genre_id');
    }

    public function getOriginalLanguageAttribute()
    {
        return $this->belongsTo('App\TmdbLanguage', 'original_language', 'id');
    }

    public function spokenLanguages()
    {
        return $this->belongsToMany('App\TmdbLanguage', 'language_movie', 'genre_id', 'language_id');
    }

    public function productionCountries()
    {
        return $this->belongsToMany('App\TmdbCountry', 'country_movie', 'movie_id', 'country_id');
    }

    public function local()
    {
        return $this->belongsTo('App\LocalMovie', 'id', 'id');
    }
}
