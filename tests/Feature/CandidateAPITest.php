<?php

declare(strict_types = 1);

use App\Models\Assignment;
use App\Models\Candidate;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('See all the candidates and their assignments ', function (): void {
	Candidate::factory()->count(5)->create();
	Assignment::factory()->count(5)->create(
		[
			'start_date' => '01/01/2024',
			'end_date' => '01/01/2025',
			'title' => 'Mission de test',
			'candidate_id' => 1,
		]
	);
	Assignment::factory()->count(5)->create(
		[
			'start_date' => '01/01/2024',
			'end_date' => '01/01/2025',
			'title' => 'Mission de test',
			'candidate_id' => 2,
		]
	);

	$response = $this->getJson('/api/candidates');

	$response->assertStatus(200);
	$response->assertJsonCount(5);

	expect(count($response[0]['assignments']))->toBe(5);
	expect(count($response[1]['assignments']))->toBe(5);
});

test('Delete one candidate ', function (): void {
	Candidate::factory()->count(5)->create();

	$candidate = Candidate::where('id', 1)->first()->toArray();

	$response = $this->deleteJson('/api/candidates/delete/1');

	$response->assertStatus(200);
	$response->assertJson(['message' => 'Candidate deleted successfully.']);

	$this->assertDatabaseMissing('assignments', $candidate);
});
