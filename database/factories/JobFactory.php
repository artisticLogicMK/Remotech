<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Job>
 */
class JobFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
      return [
          'user_id' => 1,
          'title' => $this->faker->sentence(),
          'companyName' => 'Artistic',
          'type' => 'Full Time',
          'skills' => $this->faker->word().' '.$this->faker->word().' '.$this->faker->word(),
          'description' => $this->faker->paragraph(5),
          'salary' => 34000,
          'qualifications' => $this->faker->paragraph(8),
          'close_date' => '2022-12-04',
          'close_time' => time() * 5000
      ];
    }
}
