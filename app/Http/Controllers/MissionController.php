<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Enums\JsonResponse as EnumsJsonResponse;
use App\Enums\JsonStatus;
use App\Models\Mission;
use App\Traits\JsonResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MissionController extends Controller
{
	use JsonResponseTrait;

	public function create(Request $request): JsonResponse
	{
		Mission::create([
			'start_date' => $request->mission['start_date'],
			'end_date' => $request->mission['end_date'],
			'title' => $request->mission['title'],
			'candidate_id' => $request->mission['candidate_id'],
		]);

		return $this->JsonResponseBuilder(
			EnumsJsonResponse::CREATE_SUCCESS->value,
			JsonStatus::SUCCESS->value
		);
	}
}
