<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use App\Models\Candidate;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CandidateController extends Controller
{
	public function index(): Collection
	{
		$candidate = new Candidate;

		return $candidate->with('assignments')->get();
	}

	public function destroy(string $candidate_id): JsonResponse
	{
		DB::table('candidates')->where('id', $candidate_id)->delete();

		return response()->json(['message' => 'Candidate deleted successfully.'], 200);
	}
}
