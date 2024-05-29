<?php

declare(strict_types = 1);

use App\Models\Candidate;
use App\Models\Mission;
use Carbon\Carbon;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

const SUCESSFULL_STATUT = 200;
const URL_BEGIN = '/api/candidates';

beforeEach(function (): void {
	Candidate::factory()->
		has(
			Mission::factory()->
				count(5),
			'missions'
		)->
		count(5)->
		create();
});

test('See all the candidates and their missions ', function (): void {
	$response = $this->getJson(URL_BEGIN);

	$response->assertStatus(SUCESSFULL_STATUT);
	$response->assertJsonCount(5, 'data');

	$responseData = $response->json('data');

	foreach ($responseData as $candidate) {
		$this->assertCount(5, $candidate['missions']);
	}
});

test('Delete one candidate ', function (): void {
	$candidate = Candidate::where('id', 1)->
		first()->
		toArray();

	$response = $this->deleteJson(URL_BEGIN . '/delete/1');

	$candidateMissions = Mission::where('candidate_id', 1)->get();

	$response->assertStatus(SUCESSFULL_STATUT);
	$response->assertJson([
		'message' => config('candidate_json_response.delete_success'),
	]);

	$this->assertDatabaseMissing('missions', $candidate);
	expect(count($candidateMissions))->toBe(0);
});

test('See all the candidates who have their mission who expired ', function (): void {
	$expiryDate = Carbon::now()->
		addYears(3);

	Mission::factory()->
		create([
			'start_date' => fake()->dateTimeBetween('-1 year', 'now'),
			'end_date' => $expiryDate,
			'title' => fake()->word(),
			'candidate_id' => 1,
		]);

	$response = $this->getJson(URL_BEGIN . "/expiring/{$expiryDate}");
	$response->assertStatus(SUCESSFULL_STATUT);
	$response->assertJsonCount(1, 'data');
	$this->assertCount(1, $response['data'][0]['missions']);
});
