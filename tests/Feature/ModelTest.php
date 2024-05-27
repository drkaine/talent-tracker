<?php

declare(strict_types = 1);

use App\Models\Assignment;
use App\Models\Candidate;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

dataset('data for test asssignment model', function () {
	return [
		[
			[
				'start_date' => '01/01/2024',
				'end_date' => '01/01/2025',
				'title' => 'Mission de test',
				'candidate_id' => 1,
			],
		],
		[
			[
				'start_date' => '01/01/2024',
				'end_date' => '01/01/2025',
				'title' => 'Mission de test',
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
		'first_name' => 'Franck',
		'name' => 'Dubois',
	];

	$candidate = new Candidate;

	$candidate->factory()->create($candidateData);

	$this->assertDatabaseHas('candidates', $candidateData);
});
