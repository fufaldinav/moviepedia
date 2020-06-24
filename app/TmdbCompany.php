<?php

namespace App;

use App;
use Tmdb\Laravel\Facades\Tmdb;

class TmdbCompany extends TmdbModel
{
    protected $fillable = [
        'id', 'description', 'headquarters', 'homepage', 'logo_path', 'name',
    ];

    protected static $api;

    protected static function booted()
    {
        parent::booted();

        static::$api = Tmdb::getCompaniesApi();

        static::creating(function ($company) {
            foreach (static::$api->getCompany($company->getKey()) as $key => $value) {
                $company->setAttribute($key, $value);
            }
        });
    }

    public function getParentCompanyAttribute()
    {
        return $this->company();
    }

    public function setParentCompanyAttribute(array $tmdbCompany = null)
    {
        if (is_null($tmdbCompany)) {
            $this->company()->dissociate();
        } else {
            $company = App\Company::find($tmdbCompany['id']);

            $this->company()->associate($company);
        }
    }

    public function company()
    {
        return $this->belongsTo('App\Company', 'parent_company_id', 'id');
    }

    public function getOriginCountryAttribute()
    {
        return $this->country();
    }

    public function setOriginCountryAttribute(string $iso_3166_1 = null)
    {
        if (is_null($iso_3166_1)) {
            $this->country()->dissociate();
        } elseif ($country = App\Country::where('iso_3166_1', $iso_3166_1)->first()) {
            $this->country()->associate($country);
        }
    }

    public function country()
    {
        return $this->belongsTo('App\Country', 'origin_country_id', 'id');
    }

    public function movies()
    {
        return $this->belongsToMany('App\Movie', 'company_movie', 'movie_id', 'company_id');
    }
}
