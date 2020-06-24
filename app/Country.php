<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    public $timestamps = false;

    public function movies()
    {
        return $this->belongsToMany('App\TmdbMovie', 'country_movie', 'country_id', 'movie_id');
    }
}
