<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SpeakerController;

Route::apiResource('speakers', SpeakerController::class);

// Route::get('/cloudinary-debug', function () {
//     return response()->json([
//         'env_value' => env('CLOUDINARY_URL'),
//         'config_value' => config('cloudinary.url')
//     ]);
// });

use App\Http\Controllers\Api\ArticleController;

Route::apiResource('articles', ArticleController::class);

use App\Http\Controllers\Api\StartupController;

Route::apiResource('startups', StartupController::class);

use App\Http\Controllers\Api\PartnerController;

Route::apiResource('partners', PartnerController::class);

use App\Http\Controllers\SearchController;

// routes/api.php
Route::get('/search', [SearchController::class, 'search']);

