<?php

namespace App;

class Genre extends BaseModel
{
    public function movies()
    {
        return $this->belongsToMany('App\Movie');
    }
}
