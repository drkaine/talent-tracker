<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Enums\JsonResponse as EnumsJsonResponse;
use App\Enums\JsonStatus;
use App\Http\Resources\CandidateResource;
use App\Models\Candidate;
use App\Models\Mission;
use App\Traits\JsonResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
	use JsonResponseTrait;

	private Candidate $candidate;

	private array $validatorRules = [
		'candidate' => 'required|array',
		'candidate.first_name' => 'required|string|max:255',
		'candidate.name' => 'required|string|max:255',
	];

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
		$validator = Validator::make($request->all(), $this->validatorRules);

		if ($validator->fails()) {
			return $this->JsonResponseBuilder(
				EnumsJsonResponse::CREATE_ERROR->value,
				JsonStatus::UNPROCESSABLE->value
			);
		}

		$this->candidate->
			create([
				'first_name' => $request->candidate['first_name'],
				'name' => $request->candidate['name'],
			]);

		return $this->JsonResponseBuilder(
			EnumsJsonResponse::CREATE_CANDIDATE_SUCCESS->value,
			JsonStatus::SUCCESS->value
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
		$validator = Validator::make($request->all(), $this->validatorRules);

		if ($validator->fails()) {
			return $this->JsonResponseBuilder(
				EnumsJsonResponse::CREATE_ERROR->value,
				JsonStatus::UNPROCESSABLE->value
			);
		}

		$isUpdate = $this->candidate->
			where('id', $candidateId)->
			update([
				'first_name' => $request->candidate['first_name'],
				'name' => $request->candidate['name'],
			]);

		if (!$isUpdate) {
			return $this->JsonResponseBuilder(
				EnumsJsonResponse::CANDIDATE_NOT_FOUND->value,
				JsonStatus::NOT_FOUND->value
			);
		}

		return $this->JsonResponseBuilder(
			EnumsJsonResponse::UPDATE_CANDIDATE_SUCCESS->value,
			JsonStatus::SUCCESS->value
		);
	}

	public function destroy(string $candidateId): JsonResponse
	{
		$isDelete = $this->candidate->
			where('id', $candidateId)->
			delete();

		if (!$isDelete) {
			return $this->JsonResponseBuilder(
				EnumsJsonResponse::CANDIDATE_NOT_FOUND->value,
				JsonStatus::NOT_FOUND->value
			);
		}

		Mission::where('candidate_id', $candidateId)->
			delete();

		return $this->JsonResponseBuilder(
			EnumsJsonResponse::DELETE_CANDIDATE_SUCCESS->value,
			JsonStatus::SUCCESS->value
		);
	}
}
