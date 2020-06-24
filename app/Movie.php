<?php

namespace App;

class Movie extends BaseModel
{
    protected $casts = [
        'adult' => 'boolean',
        'popularity' => 'float',
        'video' => 'boolean',
    ];

    public function genres()
    {
        return $this->belongsToMany('App\Genre');
    }
}
