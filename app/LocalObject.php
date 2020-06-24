<?php

namespace App;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

abstract class LocalObject extends Model
{
    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * @param  string  $filename
     * @return string[]|false
     */
    public static function importFromDailyFile($filename)
    {
        if (! Storage::exists($filename)) {
            Log::debug($filename.' does not exists');

            return false;
        }

        try {
            $contents = Storage::get($filename);
        } catch (FileNotFoundException $e) {
            Log::debug($e->getMessage());

            return false;
        }

        return preg_split('/\n/', $contents);
    }

    /**
     * @param  string  $json
     * @return mixed[]|false
     */
    public static function parseJsonString($json)
    {
        $params = json_decode($json, true);

        if (! is_array($params)) {
            return false;
        }

        return $params;
    }

    /**
     * @param  string  $attr
     * @return bool
     */
    protected function hasAttribute($attr)
    {
        return array_key_exists($attr, $this->attributes);
    }
}
