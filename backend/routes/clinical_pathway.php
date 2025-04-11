<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClinicalPathwayController;

Route::prefix('clinical-pathway')->group(function () {
    Route::post('/', [ClinicalPathwayController::class, 'store']);
    Route::post('/export', [ClinicalPathwayController::class, 'export']);
});
