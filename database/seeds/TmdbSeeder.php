<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;

class TmdbSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (Storage::files('tmdb') as $file) {
            preg_match('/^tmdb\/(\w*)\.json$/', $file, $matches);

            if (! ($table = $matches[1])) {
                continue;
            }

            if (Schema::hasTable($table)) {
                $contents = Storage::get($file);

                $data = preg_split('/\r\n|\r|\n/', $contents);

                foreach ($data as $key => $row) {
                    if (is_array($item = json_decode($row, true))) {
                        DB::table($table)->insert($item);
                    }
                }
            } else {
                echo 'Table not found';
            }
        }
    }
}
