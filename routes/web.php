<?php

use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

use App\Http\Controllers\SearchController;

use App\Http\Controllers\SearchResultsController;

Route::get('/', [SearchController::class, 'index'])->name('search.index');


Route::post('/search', [SearchController::class, 'search'])->name('search');
Route::get('/search/results', [SearchController::class, 'showResults'])->name('search.results');

Route::post('/export-results', [SearchResultsController::class, 'export'])->name('export');

