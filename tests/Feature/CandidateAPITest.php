<?php

declare(strict_types = 1);

use App\Models\Assignment;
use App\Models\Candidate;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function (): void {
	Candidate::factory()->has(Assignment::factory()->count(5), 'assignments')->count(5)->create();
});

test('See all the candidates and their assignments ', function (): void {
	$response = $this->getJson('/api/candidates');

	$response->assertStatus(200);
	$response->assertJsonCount(5);

	expect(count($response[0]['assignments']))->toBe(5);
	expect(count($response[1]['assignments']))->toBe(5);
});

test('Delete one candidate ', function (): void {
	$candidate = Candidate::where('id', 1)->first()->toArray();

	$response = $this->deleteJson('/api/candidates/delete/1');

	$response->assertStatus(200);
	$response->assertJson(['message' => 'Candidate deleted successfully.']);

	$this->assertDatabaseMissing('assignments', $candidate);
});

test('See all the candidates who have their assignment who expired ', function (): void {
	$expiryDate = '2030-01-01';

	Assignment::factory()->create([
		'start_date' => '01-01-2024',
		'end_date' => $expiryDate,
		'title' => 'Mission de test',
		'candidate_id' => 1,
	]);

	$response = $this->getJson("/api/candidates/expiring/{$expiryDate}");
	$response->assertStatus(200);
	$response->assertJsonCount(1);
});
