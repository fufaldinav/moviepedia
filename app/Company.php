<?php

namespace App;

class Company extends BaseModel
{
    public function movies()
    {
        return $this->belongsToMany('App\Movie');
    }
}
