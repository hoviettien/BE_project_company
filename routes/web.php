<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\Api\SpeakerController;

Route::get('/test-speakers', [SpeakerController::class, 'index']);


use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

Route::get('/cloudinary-test', function () {
    try {
        $upload = Cloudinary::uploadFile('https://upload.wikimedia.org/wikipedia/commons/3/3f/JPEG_example_flower.jpg', [
            'folder' => 'speakers_test'
        ]);

        return response()->json([
            'secure_url' => $upload->getSecurePath(),
            'public_id'  => $upload->getPublicId(),
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'error' => $e->getMessage()
        ]);
    }
});
