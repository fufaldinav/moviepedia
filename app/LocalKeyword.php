<?php

namespace App;

/**
 * App\LocalKeyword.
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalKeyword newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalKeyword newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalKeyword query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalKeyword whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalKeyword whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalKeyword whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\LocalKeyword whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class LocalKeyword extends LocalObject
{
    protected $casts = [];
}
