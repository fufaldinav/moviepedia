<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    public $timestamps = false;

    public function movies()
    {
        return $this->belongsToMany('App\TmdbMovie', 'language_movie', 'language_id', 'movie_id');
    }
}
