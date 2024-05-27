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
	public function index(): Collection
	{
		$candidate = new Candidate;

		return $candidate->with('assignments')->get();
	}

	public function show(string $expiryDate): Collection
	{
		$candidate = new Candidate;

		$expiry_date = Carbon::parse($expiryDate);

		$candidates = $candidate->whereHas('assignments', function ($query) use ($expiry_date): void {
			$query->whereDate('end_date', '=', $expiry_date);
		})->get();

		return $candidates;
	}

	public function destroy(string $candidate_id): JsonResponse
	{
		DB::table('candidates')->where('id', $candidate_id)->delete();

		return response()->json(['message' => 'Candidate deleted successfully.'], 200);
	}
}
