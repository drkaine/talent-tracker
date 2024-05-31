<?php

declare(strict_types = 1);

use App\Enums\JsonResponse;
use App\Enums\JsonStatus;
use App\Models\Mission;

uses(
	Illuminate\Foundation\Testing\RefreshDatabase::class
);

const URL_BEGIN_MISSION = '/api/missions';

dataset('Case for mission', function () {
	return require './tests/dataset/MissionModel.php';
});

test('Create one mission ', function (array $newMissionData): void {
	$response = $this->postJson(URL_BEGIN_MISSION . '/create', ['mission' => $newMissionData]);

	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJson([
		'message' => JsonResponse::MISSION_CREATE_SUCCESS->value,
	]);

	$this->assertDatabaseHas('missions', $newMissionData);
})->with('Case for mission');

dataset('Case of error', function () {
	return require './tests/dataset/WrongMissionData.php';
});

test('Try create one mission with wrong information ', function (array $newMissionData): void {
	$response = $this->postJson(URL_BEGIN_MISSION . '/create', [
		$newMissionData]);

	$response->assertStatus(JsonStatus::UNPROCESSABLE->value);
	$response->assertJson([
		'message' => JsonResponse::CREATE_ERROR->value,
	]);
})->with('Case of error');

test('Delete one mission ', function (): void {
	Mission::factory(2)->create();
	$mission = Mission::where('id', 1)->
		first()->
		toArray();

	$response = $this->deleteJson(URL_BEGIN_MISSION . '/delete/1');

	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJson([
		'message' => JsonResponse::DELETE_MISSION_SUCCESS->value,
	]);

	$this->assertDatabaseMissing('missions', $mission);
});

test('Try delete a candidate with negative id ', function (): void {
	$response = $this->deleteJson(URL_BEGIN_MISSION . '/delete/-1');

	$response->assertStatus(JsonStatus::NOT_FOUND->value);
	$response->assertJson([
		'message' => JsonResponse::MISSION_NOT_FOUND->value,
	]);
});
