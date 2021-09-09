<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\WordController;
use Illuminate\Support\Facades\Auth;
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

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', [HomeController::class,"dashboard"])->name('dashboard');
    Route::post('/showall', [WordController::class,"showall"])->name('showall');
    Route::post('/exportascsv', [WordController::class,"exportascsv"])->name('exportascsv');
    Route::get('/exportascsv', function()
    {
            abort(404);
    });

    Route::get('/exportCSV', [WordController::class,"exportCSV"])->name('exportCSV');



    Route::get('/showall',  function()
    {
            return redirect()->route("dashboard");
    });


        Route::get('/',  function()
        {
                return redirect()->route("dashboard");
        });


    Route::resource('word', WordController::class);
});

Route::get('/offline', function () {
    return view('modules/laravelpwa/offline');
    });
