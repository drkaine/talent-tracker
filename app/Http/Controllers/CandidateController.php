<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\Candidate;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
	private Candidate $candidate;

	public function __construct()
	{
		$this->candidate = new Candidate;
	}

	public function index(): Collection
	{
		return $this->candidate->
			with('assignments')->
			get();
	}

	public function show(string $expiryDate): Collection
	{
		$expiryDate = Carbon::parse($expiryDate);

		$candidates = $this->candidate->
			whereHas(
				'assignments',
				function ($query) use ($expiryDate): void {
					$query->whereDate('end_date', '=', $expiryDate);
				}
			)->
			get();

		return $candidates;
	}

	public function destroy(string $candidateId): JsonResponse
	{
		DB::table('candidates')->
			where('id', $candidateId)->
			delete();

		return response()->
			json(
				[
					'message' => config('candidate_json_response.delete_success'),
				],
				200
			);
	}
}
