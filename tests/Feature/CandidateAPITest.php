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
