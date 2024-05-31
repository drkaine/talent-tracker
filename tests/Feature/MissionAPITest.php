<?php

declare(strict_types = 1);

use App\Enums\JsonResponse;
use App\Enums\JsonStatus;

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
	$response = $this->postJson(URL_BEGIN . '/create', [
		$newMissionData]);

	$response->assertStatus(JsonStatus::UNPROCESSABLE->value);
	$response->assertJson([
		'message' => JsonResponse::CREATE_ERROR->value,
	]);
})->with('Case of error');
