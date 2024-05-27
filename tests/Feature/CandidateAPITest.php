<?php

declare(strict_types = 1);

use App\Models\Candidate;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('See all the candidates ', function (): void {
	Candidate::factory()->count(5)->create();

	$response = $this->getJson('/api/candidates');

	$response->assertStatus(200);
	$response->assertJsonCount(5);
});
