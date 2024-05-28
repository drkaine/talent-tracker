<?php

declare(strict_types = 1);

use App\Models\Candidate;
use App\Models\Mission;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

dataset('data for test asssignment model', function () {
	return [
		[
			[
				'start_date' => fake()->dateTimeBetween('-1 year', 'now'),
				'end_date' => fake()->dateTimeBetween('now', '+1 year'),
				'title' => fake()->word(),
				'candidate_id' => 1,
			],
		],
		[
			[
				'start_date' => fake()->dateTimeBetween('-1 year', 'now'),
				'end_date' => fake()->dateTimeBetween('now', '+1 year'),
				'title' => fake()->word(),
				'candidate_id' => null,
			],
		],
	];
});

test('Mission ', function (array $missionData): void {
	$mission = new Mission;

	$mission->factory()->create($missionData);

	$this->assertDatabaseHas('missions', $missionData);
})->with('data for test asssignment model');

test('Candidate ', function (): void {
	$candidateData = [
		'first_name' => fake()->firstName(),
		'name' => fake()->name(),
	];

	$candidate = new Candidate;

	$candidate->factory()->create($candidateData);

	$this->assertDatabaseHas('candidates', $candidateData);
});
