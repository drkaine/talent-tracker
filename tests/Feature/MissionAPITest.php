<?php

declare(strict_types = 1);

use App\Enums\JsonResponse;
use App\Enums\JsonStatus;
use App\Models\Mission;
use Carbon\Carbon;

uses(
	Illuminate\Foundation\Testing\RefreshDatabase::class
);

const URL_BEGIN_MISSION = '/api/missions';

dataset('Case for mission', function () {
	return require './tests/dataset/GoodMissionData.php';
});

dataset('Case of error', function () {
	return require './tests/dataset/WrongMissionData.php';
});

beforeEach(function (): void {
	Mission::factory(2)->create();

	$this->mission = Mission::where('id', ID)->
		first()->
		toArray();

	$this->updateMissionData = [
		'start_date' => Carbon::parse(
			fake()->
				dateTimeBetween('-1 year', 'now')
		)->
			format('Y/m/d'),
		'end_date' => Carbon::parse(
			fake()->
				dateTimeBetween('now', '+1 year')
		)->
			format('Y/m/d'),
		'title' => fake()->
			word(),
		'candidate_id' => 1,
	];
});

test('Create one mission ', function (array $newMissionData): void {
	$response = $this->postJson(
		URL_BEGIN_MISSION . '/create',
		['mission' => $newMissionData]
	);

	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJson([
		'message' => JsonResponse::CREATE_MISSION_SUCCESS->value,
	]);

	$this->assertDatabaseHas('missions', $newMissionData);
})->with('Case for mission');

test('Try create one mission with wrong information ', function (array $newMissionData): void {
	$response = $this->postJson(
		URL_BEGIN_MISSION . '/create',
		[$newMissionData]
	);

	$response->assertStatus(JsonStatus::UNPROCESSABLE->value);
	$response->assertJson([
		'message' => JsonResponse::CREATE_ERROR->value,
	]);
})->with('Case of error');

test('Delete one mission ', function (): void {
	$response = $this->deleteJson(URL_BEGIN_MISSION . '/delete/' . ID);

	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJson([
		'message' => JsonResponse::DELETE_MISSION_SUCCESS->value,
	]);

	$this->assertDatabaseMissing('missions', $this->mission);
});

test('Try delete a candidate with negative id ', function (): void {
	$response = $this->deleteJson(URL_BEGIN_MISSION . '/delete/' . NEGATIVE_ID);

	$response->assertStatus(JsonStatus::NOT_FOUND->value);
	$response->assertJson([
		'message' => JsonResponse::MISSION_NOT_FOUND->value,
	]);
});

test('Modify one mission ', function (): void {

	$response = $this->patchJson(
		URL_BEGIN_MISSION . '/update/' . ID,
		['mission' => $this->updateMissionData]
	);

	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJson([
		'message' => JsonResponse::UPDATE_MISSION_SUCCESS->value,
	]);

	$this->assertDatabaseMissing('missions', $this->mission);
	$this->assertDatabaseHas('missions', $this->updateMissionData);
});

test('Try modify one mission with negative id ', function (): void {
	$response = $this->patchJson(
		URL_BEGIN_MISSION . '/update/' . NEGATIVE_ID,
		['mission' => $this->updateMissionData]
	);

	$response->assertStatus(JsonStatus::NOT_FOUND->value);
	$response->assertJson([
		'message' => JsonResponse::MISSION_NOT_FOUND->value,
	]);

	$this->assertDatabaseMissing('missions', $this->updateMissionData);
});
