<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Enums\JsonResponseEnum;
use App\Enums\JsonStatusEnum;
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
		'data' => 'required|array',
		'data.start_date' => 'required|date|date_format:Y-m-d',
		'data.end_date' => 'required|date|date_format:Y-m-d',
		'data.title' => 'required|string|max:450',
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
				JsonResponseEnum::CREATE_ERROR->value,
				JsonStatusEnum::UNPROCESSABLE->value
			);
		}

		$this->mission->
			create([
				'start_date' => $request->data['start_date'],
				'end_date' => $request->data['end_date'],
				'title' => $request->data['title'],
				'candidate_id' => $request->data['candidate_id'],
			]);

		return $this->JsonResponseBuilder(
			JsonResponseEnum::CREATE_MISSION_SUCCESS->value,
			JsonStatusEnum::SUCCESS->value
		);
	}

	public function update(Request $request, string $missionId): JsonResponse
	{
		$isUpdate = $this->mission->
			where('id', $missionId)->
			update([
				'start_date' => $request->data['start_date'],
				'end_date' => $request->data['end_date'],
				'title' => $request->data['title'],
				'candidate_id' => $request->data['candidate_id'],
			]);

		if (!$isUpdate) {
			return $this->JsonResponseBuilder(
				JsonResponseEnum::MISSION_NOT_FOUND->value,
				JsonStatusEnum::NOT_FOUND->value
			);
		}

		return $this->JsonResponseBuilder(
			JsonResponseEnum::UPDATE_MISSION_SUCCESS->value,
			JsonStatusEnum::SUCCESS->value
		);
	}

	public function destroy(string $missionId): JsonResponse
	{
		$isDelete = $this->mission->
			where('id', $missionId)->
			delete();

		if (!$isDelete) {
			return $this->JsonResponseBuilder(
				JsonResponseEnum::MISSION_NOT_FOUND->value,
				JsonStatusEnum::NOT_FOUND->value
			);
		}

		return $this->JsonResponseBuilder(
			JsonResponseEnum::DELETE_MISSION_SUCCESS->value,
			JsonStatusEnum::SUCCESS->value
		);
	}
}
