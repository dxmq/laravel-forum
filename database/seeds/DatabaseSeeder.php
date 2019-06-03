<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(AdminTablesSeeder::class);

        factory('App\Thread', 20)->create();

        factory('App\Post', 20)->create();

        factory('App\Topic', 5)->create();
    }
}
