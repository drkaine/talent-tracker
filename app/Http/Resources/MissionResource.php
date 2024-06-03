<?php

declare(strict_types = 1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MissionResource extends JsonResource
{
	public function toArray(Request $request): array
	{
		return [
			'id' => $this->id,
			'candidate_id' => $this->candidate_id,
			'title' => $this->title,
			'start_date' => $this->start_date,
			'end_date' => $this->end_date,
		];
	}
}
