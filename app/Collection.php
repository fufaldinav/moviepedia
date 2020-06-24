<?php

namespace App;

class Collection extends BaseModel
{
    public function movies()
    {
        return $this->hasMany('App\TmdbMovie', 'belongs_to_collection', 'id');
    }
}
