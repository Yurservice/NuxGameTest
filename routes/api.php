<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiUniqueLinkController;
use App\Http\Controllers\Api\ApiGameController;

Route::post('link-store', [ApiUniqueLinkController::class, 'store'])->name('link.store');
Route::post('link-deactivate', [ApiUniqueLinkController::class, 'deactivate'])->name('link.deactivate');
Route::post('get_result', [ApiGameController::class, 'store'])->name('game.result');
Route::get('get_history', [ApiGameController::class, 'index'])->name('game.history');
