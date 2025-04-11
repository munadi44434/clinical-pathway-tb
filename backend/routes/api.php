<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClinicalPathwayController;

Route::prefix('clinical-pathway')->group(function () {
    Route::get('/', [ClinicalPathwayController::class, 'index']);
    Route::post('/', [ClinicalPathwayController::class, 'store']);
    Route::get('/{id}', [ClinicalPathwayController::class, 'show']);
    Route::put('/{id}', [ClinicalPathwayController::class, 'update']);
    Route::delete('/{id}', [ClinicalPathwayController::class, 'destroy']);
    Route::get('/export/{id}', [ClinicalPathwayController::class, 'export']);
});
