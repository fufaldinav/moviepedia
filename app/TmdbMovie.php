<?php

namespace App;

use App;
use Tmdb\Laravel\Facades\Tmdb;

class TmdbMovie extends TmdbModel
{
    protected $guarded = ['created_at', 'updated_at'];

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

    protected static $api;

    protected static function booted()
    {
        parent::booted();

        static::$api = Tmdb::getMoviesApi();

        static::creating(function ($movie) {
            foreach (static::$api->getMovie($movie->getKey()) as $key => $value) {
                $movie->setAttribute($key, $value);
            }
        });
    }

    public function getBelongsToCollectionAttribute()
    {
        $this->collection();
    }

    public function setBelongsToCollectionAttribute(array $tmdbCollection = null)
    {
        if (is_null($tmdbCollection)) {
            $this->collection()->dissociate();
        } else {
            $collection = App\Collection::find($tmdbCollection['id']);

            $this->collection()->associate($collection);
        }
    }

    public function collection()
    {
        return $this->belongsTo('App\Collection', 'collection_id', 'id');
    }

    public function getGenresAttribute()
    {
        $this->genres();
    }

    public function setGenresAttribute(array $tmdbGenres = [])
    {
        foreach ($tmdbGenres as $tmdbGenre) {
            $genre = App\Genre::firstOrCreate(['id' => $tmdbGenre['id']], ['name' => $tmdbGenre['name']]);
            $this->genres()->attach($genre->id);
        }
    }

    public function genres()
    {
        return $this->belongsToMany('App\Genre', 'genre_movie', 'movie_id', 'genre_id');
    }

    public function getOriginalLanguageAttribute()
    {
        return $this->language();
    }

    public function setOriginalLanguageAttribute(string $iso_639_1 = null)
    {
        if (is_null($iso_639_1)) {
            $this->language()->dissociate();
        } elseif ($language = App\Language::where('iso_639_1', $iso_639_1)->first()) {
            $this->language()->associate($language);
        }
    }

    public function language()
    {
        return $this->belongsTo('App\Language', 'original_language_id', 'id');
    }

    public function getProductionCompaniesAttribute()
    {
        return $this->companies();
    }

    public function setProductionCompaniesAttribute(array $tmdbCompanies = [])
    {
        foreach ($tmdbCompanies as $tmdbCompany) {
            $company = App\Company::find($tmdbCompany['id']);
            $this->companies()->attach($company->id);
        }
    }

    public function companies()
    {
        return $this->belongsToMany('App\Company', 'company_movie', 'movie_id', 'company_id');
    }

    public function getProductionCountriesAttribute()
    {
        return $this->countries();
    }

    public function setProductionCountriesAttribute(array $tmdbCountries = [])
    {
        foreach ($tmdbCountries as $tmdbCountry) {
            $country = App\Country::where('iso_3166_1', $tmdbCountry['iso_3166_1'])->first();
            $this->countries()->attach($country->id);
        }
    }

    public function countries()
    {
        return $this->belongsToMany('App\Country', 'country_movie', 'movie_id', 'country_id');
    }

    public function getSpokenLanguagesAttribute()
    {
        return $this->countries();
    }

    public function setSpokenLanguagesAttribute(array $tmdbLanguages = [])
    {
        foreach ($tmdbLanguages as $tmdbLanguage) {
            $language = App\Language::where('iso_639_1', $tmdbLanguage['iso_639_1'])->first();
            $this->languages()->attach($language->id);
        }
    }

    public function languages()
    {
        return $this->belongsToMany('App\Language', 'language_movie', 'movie_id', 'language_id');
    }
}
