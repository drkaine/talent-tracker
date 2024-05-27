<?php

declare(strict_types = 1);

use App\Models\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
	return $request->user();
})->middleware('auth:sanctum');

Route::get('/candidates', function () {
	$candidate = new Candidate;

	return $candidate->with('assignments')->get();
});

Route::delete('/candidates/delete/{candidate_id}', function (int $candidate_id) {
	$candidate = new Candidate;
	$candidate->where('id', $candidate_id)->delete();

	return response()->json(['message' => 'Candidate deleted successfully.'], 200);
});
