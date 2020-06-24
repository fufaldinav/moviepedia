<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        App\User::updateOrCreate(['email' => 'test@test'], [
            'name' => 'test',
            'email' => 'test@test',
            'email_verified_at' => now(),
            'password' => Hash::make('test'), // password
            'remember_token' => null,
        ]);
    }
}
