<?php

declare(strict_types = 1);

use App\Enums\JsonResponse;
use App\Enums\JsonStatus;
use App\Models\Candidate;
use App\Models\Mission;
use Carbon\Carbon;

uses(
	Illuminate\Foundation\Testing\RefreshDatabase::class
);

const URL_BEGIN_CANDIDATE = '/api/candidates';
const ID = 1;
const NEGATIVE_ID = -1;

dataset('Case of error', function () {
	return require './tests/dataset/WrongCandidateData.php';
});

beforeEach(function (): void {
	Candidate::factory()->
		has(
			Mission::factory()->
				count(2),
			'missions'
		)->
		count(2)->
		create();

	$this->updateCandidateData = [
		'first_name' => fake()->firstName(),
		'name' => fake()->name(),
	];

	$this->oldCandidateData = Candidate::where('id', ID)->
	first()->
	toArray();
});

test('See all the candidates and their missions ', function (): void {
	$response = $this->getJson(URL_BEGIN_CANDIDATE);

	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJsonCount(2, 'data');

	$responseData = $response->json('data');

	foreach ($responseData as $candidate) {
		$this->assertCount(2, $candidate['missions']);
	}
});

test('Delete one candidate ', function (): void {

	$candidate = Candidate::where('id', ID)->
		first()->
		toArray();

	$response = $this->deleteJson(URL_BEGIN_CANDIDATE . '/delete/' . ID);

	$candidateMissions = Mission::where('id', ID)->
		get();

	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJson([
		'message' => JsonResponse::DELETE_CANDIDATE_SUCCESS->value,
	]);

	$this->assertDatabaseMissing('missions', $candidate);
	expect(count($candidateMissions))->toBe(0);
});

test('Try delete a candidate with negative id ', function (): void {
	$response = $this->deleteJson(URL_BEGIN_CANDIDATE . '/delete/' . NEGATIVE_ID);

	$response->assertStatus(JsonStatus::NOT_FOUND->value);
	$response->assertJson([
		'message' => JsonResponse::CANDIDATE_NOT_FOUND->value,
	]);
});

test('See all the candidates who have their mission who expired ', function (): void {
	$expiryDate = Carbon::now()->
		addYears(3);

	Mission::factory()->
		create([
			'start_date' => fake()->dateTimeBetween('-1 year', 'now'),
			'end_date' => $expiryDate,
			'title' => fake()->word(),
			'candidate_id' => ID,
		]);

	$response = $this->getJson(URL_BEGIN_CANDIDATE . "/expiring/{$expiryDate}");
	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJsonCount(1, 'data');
	$this->assertCount(1, $response['data'][0]['missions']);
});

test('Create one candidate ', function (): void {
	$response = $this->postJson(
		URL_BEGIN_CANDIDATE . '/create',
		['candidate' => $this->updateCandidateData]
	);

	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJson([
		'message' => JsonResponse::CREATE_CANDIDATE_SUCCESS->value,
	]);

	$this->assertDatabaseHas('candidates', $this->updateCandidateData);
});

test('Try create one candidate with wrong information ', function (array $newCandidateData): void {
	$response = $this->postJson(
		URL_BEGIN_CANDIDATE . '/create',
		[$newCandidateData]
	);

	$response->assertStatus(JsonStatus::UNPROCESSABLE->value);
	$response->assertJson([
		'message' => JsonResponse::CREATE_ERROR->value,
	]);
})->with('Case of error');

test('Modify one candidate ', function (): void {
	$this->oldCandidateData = Candidate::where('id', ID)->
		first()->
		toArray();

	$response = $this->patchJson(
		URL_BEGIN_CANDIDATE . '/update/' . ID,
		['candidate' => $this->updateCandidateData]
	);

	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJson([
		'message' => JsonResponse::UPDATE_CANDIDATE_SUCCESS->value,
	]);

	$this->assertDatabaseHas('candidates', $this->updateCandidateData);
	$this->assertDatabaseMissing('candidates', $this->oldCandidateData);
});

test('Try modify one candidate with wrong information ', function (array $updateCandidateData): void {
	$response = $this->patchJson(
		URL_BEGIN_CANDIDATE . '/update/' . ID,
		['candidate' => $updateCandidateData]
	);

	$response->assertStatus(JsonStatus::UNPROCESSABLE->value);
	$response->assertJson([
		'message' => JsonResponse::CREATE_ERROR->value,
	]);
})->with('Case of error');

test('Try modify one candidate with negative id ', function (): void {
	$response = $this->patchJson(
		URL_BEGIN_CANDIDATE . '/update/' . NEGATIVE_ID,
		['candidate' => $this->updateCandidateData]
	);

	$response->assertStatus(JsonStatus::NOT_FOUND->value);
	$response->assertJson([
		'message' => JsonResponse::CANDIDATE_NOT_FOUND->value,
	]);

	$this->assertDatabaseMissing('candidates', $this->updateCandidateData);
});
