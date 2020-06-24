<?php

namespace App;

class Person extends BaseModel
{
    protected $casts = [
        'adult' => 'boolean',
        'popularity' => 'float',
    ];
}
