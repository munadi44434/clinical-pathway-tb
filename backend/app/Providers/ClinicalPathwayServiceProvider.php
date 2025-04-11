<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class ClinicalPathwayServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Route::prefix('api/clinical-pathway')
            ->middleware('api')
            ->group(base_path('routes/clinical_pathway.php'));
    }
}
