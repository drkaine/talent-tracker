<?php

declare(strict_types = 1);

use App\Models\Assignment;
use App\Models\Candidate;

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

test('Assignment ', function (array $assignmentData): void {
	$assignment = new Assignment;

	$assignment->factory()->create($assignmentData);

	$this->assertDatabaseHas('assignments', $assignmentData);
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
