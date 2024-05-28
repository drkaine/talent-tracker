<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mission>
 */
class MissionFactory extends Factory
{
	/**
	 * Define the model's default state.
	 *
	 * @return array<string, mixed>
	 */
	public function definition(): array
	{
		return [
			'start_date' => fake()->dateTimeBetween('-1 year', 'now'),
			'end_date' => fake()->dateTimeBetween('now', '+1 year'),
			'title' => fake()->word(),
			'candidate_id' => Candidate::factory(),
		];
	}
}
