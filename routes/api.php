<?php

declare(strict_types = 1);

use App\Http\Controllers\CandidateController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
	return $request->user();
})->middleware('auth:sanctum');

Route::get('/candidates', [CandidateController::class, 'index']);

Route::get('/candidates/expiring/{expiryDate}', [CandidateController::class, 'show']);

Route::delete('/candidates/delete/{candidate_id}', [CandidateController::class, 'destroy']);
