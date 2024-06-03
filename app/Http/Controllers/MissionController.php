<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Enums\JsonResponse as EnumsJsonResponse;
use App\Enums\JsonStatus;
use App\Models\Mission;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MissionController extends Controller
{
	use JsonResponseTrait;

	private Mission $mission;

	private array $validatorRules = [
		'mission' => 'required|array',
		'mission.start_date' => 'required|date',
		'mission.end_date' => 'required|date',
		'mission.title' => 'required|string|max:450',
	];

	public function __construct()
	{
		$this->mission = new Mission;
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

		$this->mission->
			create([
				'start_date' => $request->mission['start_date'],
				'end_date' => $request->mission['end_date'],
				'title' => $request->mission['title'],
				'candidate_id' => $request->mission['candidate_id'],
			]);

		return $this->JsonResponseBuilder(
			EnumsJsonResponse::CREATE_MISSION_SUCCESS->value,
			JsonStatus::SUCCESS->value
		);
	}

	public function update(Request $request, string $missionId): JsonResponse
	{
		$this->mission->
			where('id', $missionId)->
			update([
				'start_date' => $request->mission['start_date'],
				'end_date' => $request->mission['end_date'],
				'title' => $request->mission['title'],
				'candidate_id' => $request->mission['candidate_id'],
			]);

		return $this->JsonResponseBuilder(
			EnumsJsonResponse::UPDATE_MISSION_SUCCESS->value,
			JsonStatus::SUCCESS->value
		);
	}

	public function destroy(string $missionId): JsonResponse
	{
		$isDelete = $this->mission->
			where('id', $missionId)->
			delete();

		if (!$isDelete) {
			return $this->JsonResponseBuilder(
				EnumsJsonResponse::MISSION_NOT_FOUND->value,
				JsonStatus::NOT_FOUND->value
			);
		}

		return $this->JsonResponseBuilder(
			EnumsJsonResponse::DELETE_MISSION_SUCCESS->value,
			JsonStatus::SUCCESS->value
		);
	}
}
