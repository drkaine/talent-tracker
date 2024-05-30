<?php

declare(strict_types = 1);

use App\Http\Controllers\CandidateController;
use App\Http\Controllers\MissionController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
	return $request->user();
})->middleware('auth:sanctum');

Route::get('/candidates', [CandidateController::class, 'index']);

Route::get('/candidates/expiring/{expiryDate}', [CandidateController::class, 'show']);

Route::post('/candidates/create', [CandidateController::class, 'create']);

Route::patch('/candidates/update/{candidateId}', [CandidateController::class, 'update']);

Route::delete('/candidates/delete/{candidateId}', [CandidateController::class, 'destroy']);

Route::post('/missions/create', [MissionController::class, 'create']);
