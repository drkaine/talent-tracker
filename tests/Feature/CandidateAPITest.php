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

const URL_BEGIN = '/api/candidates';
const CANDIDATE_ID = 1;
const NEGATIVE_CANDIDATE_ID = -1;

beforeEach(function (): void {
	Candidate::factory()->
		has(
			Mission::factory()->
				count(2),
			'missions'
		)->
		count(2)->
		create();
});

test('See all the candidates and their missions ', function (): void {
	$response = $this->getJson(URL_BEGIN);

	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJsonCount(2, 'data');

	$responseData = $response->json('data');

	foreach ($responseData as $candidate) {
		$this->assertCount(2, $candidate['missions']);
	}
});

test('Delete one candidate ', function (): void {

	$candidate = Candidate::where('id', CANDIDATE_ID)->
		first()->
		toArray();

	$response = $this->deleteJson(URL_BEGIN . '/delete/' . CANDIDATE_ID);

	$candidateMissions = Mission::where('candidate_id', CANDIDATE_ID)->get();

	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJson([
		'message' => JsonResponse::DELETE_SUCCESS->value,
	]);

	$this->assertDatabaseMissing('missions', $candidate);
	expect(count($candidateMissions))->toBe(0);
});

test('Try delete a candidate with negative id ', function (): void {
	$response = $this->deleteJson(URL_BEGIN . '/delete/' . NEGATIVE_CANDIDATE_ID);

	$response->assertStatus(JsonStatus::NOT_FOUND->value);
	$response->assertJson([
		'message' => JsonResponse::NOT_FOUND->value,
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
			'candidate_id' => CANDIDATE_ID,
		]);

	$response = $this->getJson(URL_BEGIN . "/expiring/{$expiryDate}");
	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJsonCount(1, 'data');
	$this->assertCount(1, $response['data'][0]['missions']);
});

test('Create one candidate ', function (): void {
	$newCandidateData = [
		'first_name' => fake()->firstName(),
		'name' => fake()->name(),
	];

	$response = $this->postJson(URL_BEGIN . '/create', ['candidate' => $newCandidateData]);

	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJson([
		'message' => JsonResponse::CREATE_SUCCESS->value,
	]);

	$this->assertDatabaseHas('candidates', $newCandidateData);
});

dataset('Case of error', function () {
	return require './tests/dataset/CreateCandidate.php';
});

test('Try create one candidate with wrong information ', function (array $newCandidateData): void {
	$response = $this->postJson(URL_BEGIN . '/create', [
		$newCandidateData]);

	$response->assertStatus(JsonStatus::UNPROCESSABLE->value);
	$response->assertJson([
		'message' => JsonResponse::CREATE_ERROR->value,
	]);
})->with('Case of error');

test('Modify one candidate ', function (): void {
	$updateCandidateData = [
		'first_name' => fake()->firstName(),
		'name' => fake()->name(),
	];

	$response = $this->patchJson(URL_BEGIN . '/update/' . CANDIDATE_ID, ['candidate' => $updateCandidateData]);

	$response->assertStatus(JsonStatus::SUCCESS->value);
	$response->assertJson([
		'message' => JsonResponse::UPDATE_SUCCESS->value,
	]);

	$this->assertDatabaseHas('candidates', $updateCandidateData);
});

test('Try modify one candidate with wrong information ', function (array $updateCandidateData): void {
	$response = $this->patchJson(URL_BEGIN . '/update/' . CANDIDATE_ID, ['candidate' => $updateCandidateData]);

	$response->assertStatus(JsonStatus::UNPROCESSABLE->value);
	$response->assertJson([
		'message' => JsonResponse::CREATE_ERROR->value,
	]);
})->with('Case of error');

test('Try modify one candidate with negative id ', function (): void {
	$updateCandidateData = [
		'first_name' => fake()->firstName(),
		'name' => fake()->name(),
	];

	$response = $this->patchJson(URL_BEGIN . '/update/' . NEGATIVE_CANDIDATE_ID, ['candidate' => $updateCandidateData]);

	$response->assertStatus(JsonStatus::NOT_FOUND->value);
	$response->assertJson([
		'message' => JsonResponse::NOT_FOUND->value,
	]);

	$this->assertDatabaseMissing('candidates', $updateCandidateData);
});
