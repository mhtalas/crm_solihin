<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ExportTask;
use App\Http\Controllers\ExportVisit;
use App\Http\Controllers\ExportProposed;
use App\Http\Controllers\ExportActual;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/export-report-task', [ExportTask::class, 'export'])->name('task.export');
Route::get('/export-report-visit', [ExportVisit::class, 'export'])->name('visit.export');
Route::get('/export-report-proposed', [ExportProposed::class, 'export'])->name('proposed.export');
Route::get('/export-report-actual', [ExportActual::class, 'export'])->name('actual.export');