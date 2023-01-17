<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\VisitReportController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/visitreport/datatable', [VisitReportController::class, 'datatable']);
    Route::get('/visitreport/{id}', [VisitReportController::class, 'show']);
    Route::put('/visitreport/{id}', [VisitReportController::class, 'update']);
    Route::put('/visitreport/{id}/finalise', [VisitReportController::class, 'finalise']);
});


require __DIR__.'/auth.php';
