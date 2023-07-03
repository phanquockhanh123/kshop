<?php

namespace Database\Seeders;

use App\Models\Patient;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ScenarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // truncate tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        \App\Models\Admin::truncate();
        \App\Models\Patient::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // call seeder class
        $this->call([
            AdminSeeder::class,
            PatientSeeder::class,
        ]);
    }
}