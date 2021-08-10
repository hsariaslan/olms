<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//        Schema::disableForeignKeyConstraints();
//        DB::table('users')->truncate();
//        Schema::enableForeignKeyConstraints();

        $this->call(PublishersSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(BooksSeeder::class);
        $this->call(AuthorsSeeder::class);
        $this->call(GenresSeeder::class);
    }
}
