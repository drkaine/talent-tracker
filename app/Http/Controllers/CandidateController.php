<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Resources\CandidateResource;
use App\Models\Candidate;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
	private Candidate $candidate;

	public function __construct()
	{
		$this->candidate = new Candidate;
	}

	public function index(): AnonymousResourceCollection
	{
		$candidates = $this->candidate->
			all();

		return CandidateResource::collection($candidates);
	}

	public function show(string $expiryDate): AnonymousResourceCollection
	{
		$expiryDate = Carbon::parse($expiryDate);

		$candidates = $this->candidate->
			whereHas(
				'missions',
				function ($query) use ($expiryDate): void {
					$query->whereDate('end_date', '=', $expiryDate);
				}
			)->
			with([
				'missions' => function ($query) use ($expiryDate): void {
					$query->whereDate('end_date', '=', $expiryDate);
				}])->
			get();

		return CandidateResource::collection($candidates);
	}

	public function destroy(string $candidateId): JsonResponse
	{
		DB::table('candidates')->
			where('id', $candidateId)->
			delete();

		DB::table('missions')->
			where('candidate_id', $candidateId)->
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
