<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder
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
                'name' => 'Màu đỏ',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Màu vàng',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Màu xanh lục',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Màu lam',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Màu đen',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Màu trắng',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Màu tím',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ]);
    }
}
