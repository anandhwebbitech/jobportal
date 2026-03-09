<?php

use App\Http\Controllers\Api\JobApiController as ApiJobApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route to get authenticated user
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route to get a job by ID
Route::get('/jobs/{id}', [ApiJobApiController::class, 'show']);