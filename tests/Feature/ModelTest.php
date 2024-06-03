<?php

declare(strict_types = 1);

use App\Models\Candidate;
use App\Models\Mission;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

dataset('Case for mission', function () {
	return require './tests/dataset/GoodMissionData.php';
});

test('Mission ', function (array $missionData): void {
	$mission = new Mission;

	$mission->factory()->create($missionData);

	$this->assertDatabaseHas('missions', $missionData);
})->with('Case for mission');

test('Candidate ', function (): void {
	$candidateData = [
		'first_name' => fake()->firstName(),
		'name' => fake()->name(),
	];

	$candidate = new Candidate;

	$candidate->factory()->create($candidateData);

	$this->assertDatabaseHas('candidates', $candidateData);
});
