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
    //begin: export as csv routes
    Route::post('/exportascsv', [WordController::class,"exportascsv"])->name('exportascsv');
    Route::get('/exportascsv', [WordController::class,"exportCSV"])->name('exportCSV');
    //end exporting as csv routes
    //begin restore csv
    Route::get('/restore', [WordController::class,"restore"])->name('restore');
    Route::post('/restore', [WordController::class,"executerestore"])->name('executerestore');
    //end restorecsv
     //begin delete all secrets
     Route::get('/emptysecrets', [WordController::class,"emptysecretsview"])->name('emptysecretsview');
     Route::post('/emptysecrets', [WordController::class,"emptysecrets"])->name('emptysecrets');
     //end delete all secrets

    //protecting showall route
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
    return view('vendor/laravelpwa/offline');
    });
