<?php

namespace App;

/**
 * App\LocalPerson
 *
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalPerson newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalPerson newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalPerson query()
 * @mixin \Eloquent
 */
class LocalPerson extends LocalObject
{
    protected $table = 'persons';

    protected $casts = [
        'adult' => 'boolean',
        'popularity' => 'float',
    ];
}
