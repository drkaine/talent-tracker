<?php

declare(strict_types = 1);

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait JsonResponseTrait
{
	public function JsonResponseBuilder(string $message, int $responseStatus): JsonResponse
	{
		return response()->
			json(
				[
					'message' => $message,
				],
				$responseStatus
			);
	}
}
