<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfilePictureController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// Test route
Route::get('/test', function() {
    return 'Test route working';
});

// Main routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/editor', [ProfilePictureController::class, 'editor'])->name('editor');
Route::get('/remove-background', [ProfilePictureController::class, 'backgroundRemover'])->name('background.remover');

// API routes for profile picture manipulation
Route::post('/upload', [ProfilePictureController::class, 'upload'])->name('upload');
Route::post('/enhance', [ProfilePictureController::class, 'enhance'])->name('enhance');
Route::post('/remove-bg', [ProfilePictureController::class, 'removeBg'])->name('remove-bg');
Route::post('/apply-background', [ProfilePictureController::class, 'applyBackground'])->name('apply.background');
Route::post('/apply-custom-background', [ProfilePictureController::class, 'applyCustomBackground'])->name('apply.custom.background');

// Add these routes
Route::post('/save-template', [ProfilePictureController::class, 'saveTemplate'])->name('save.template');
Route::post('/apply-filter', [ProfilePictureController::class, 'applyFilter'])->name('apply.filter');
Route::post('/crop', [ProfilePictureController::class, 'crop'])->name('crop');

// Add social sharing routes
Route::post('/share/{platform}', [SocialController::class, 'share']);
Route::post('/save-to-collection', [ProfileController::class, 'saveToCollection']);

// Client-side error logging
Route::post('/log-error', function (Request $request) {
    Log::error('Client Error:', $request->all());
    return response()->json(['status' => 'logged']);
});
