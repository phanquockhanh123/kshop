<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now  = now();
        \App\Models\Color::insert([
            [
                'name' => 'Size S',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Size M',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Size L',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Size XL',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Màu 2XL',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Màu 3XL',
                'created_at' => $now,
                'updated_at' => $now,
            ]
        ]);
    }
}
