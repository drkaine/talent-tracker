<?php

declare(strict_types = 1);

use App\Enums\JsonResponse;
use App\Enums\JsonStatus;

uses(
	Illuminate\Foundation\Testing\RefreshDatabase::class
);

dataset('Case for mission', function () {
	return require './tests/dataset/MissionModel.php';
});

test('Create one mission ', function (array $newMissionData): void {
	$response = $this->postJson('/api/missions/create', ['mission' => $newMissionData]);

	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJson([
		'message' => JsonResponse::CREATE_SUCCESS->value,
	]);

	$this->assertDatabaseHas('missions', $newMissionData);
})->with('Case for mission');
