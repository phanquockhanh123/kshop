<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // truncate tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Color::truncate();
        \App\Models\Size::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call([
            ColorSeeder::class,
            SizeSeeder::class,
        ]);
    }
}