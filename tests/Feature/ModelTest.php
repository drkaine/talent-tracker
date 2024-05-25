<?php

declare(strict_types = 1);

use App\Models\Assignment;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('Assignment ', function (): void {
	$assignmentData = [
		'start_date' => '01/01/2024',
		'end_date' => '01/01/2025',
		'title' => 'Mission de test',
		'candidate_id' => 1,
	];

	$assignment = new Assignment;

	$assignment->factory()->create($assignmentData);

	$this->assertDatabaseHas('assignments', $assignmentData);
});
