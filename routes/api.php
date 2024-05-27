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