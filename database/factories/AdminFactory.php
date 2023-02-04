<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => 'VI' . $this->faker->unique()->numerify('######'),
            'name' => $this->faker->name(),
            'gender' => $this->faker->randomElement(array_keys(Admin::$genders)),
            'date_of_birth' => $this->faker->date(),
            'email_address' => $this->faker->unique()->safeEmail(),
            'telephone' => $this->faker->numerify('0#########'),
            'role' => $this->faker->randomElement(array_keys(Admin::$roles)),
            'status' => $this->faker->randomElement(array_keys(Admin::$status)),
            'first_login_flag' => $this->faker->boolean(),
        ];
    }
}
