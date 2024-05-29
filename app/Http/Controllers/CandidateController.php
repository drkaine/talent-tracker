<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Http\Resources\CandidateResource;
use App\Models\Candidate;
use App\Traits\JsonResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
	use JsonResponseTrait;

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

	public function create(Request $request): JsonResponse
	{
		$this->candidate->
			create([
				'first_name' => $request->candidate['first_name'],
				'name' => $request->candidate['name'],
			]);

		return $this->JsonResponseBuilder(
			config('candidate_json_response.create_success'),
			config('response_status.sucessfull_status')
		);
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

	public function update(Request $request, string $candidateId): JsonResponse
	{
		$isUpdate = $this->candidate->
			where('id', $candidateId)->
			update([
				'first_name' => $request->candidate['first_name'],
				'name' => $request->candidate['name'],
			]);

		if (!$isUpdate) {
			return $this->JsonResponseBuilder(
				config('candidate_json_response.update_error'),
				config('response_status.not_found_status')
			);
		}

		return $this->JsonResponseBuilder(
			config('candidate_json_response.update_success'),
			config('response_status.sucessfull_status')
		);
	}

	public function destroy(string $candidateId): JsonResponse
	{
		$isDelete = DB::table('candidates')->
			where('id', $candidateId)->
			delete();

		if (!$isDelete) {
			return $this->JsonResponseBuilder(
				config('candidate_json_response.delete_error'),
				config('response_status.not_found_status')
			);
		}

		DB::table('missions')->
			where('candidate_id', $candidateId)->
			delete();

		return $this->JsonResponseBuilder(
			config('candidate_json_response.delete_success'),
			config('response_status.sucessfull_status')
		);
	}
}
