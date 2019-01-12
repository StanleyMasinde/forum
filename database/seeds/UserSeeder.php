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
        factory('App\User', 100)->create()->each(function($user){
            $user->topics()->save(factory('App\Topic')->make());
        });
    }
}
