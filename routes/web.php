<?php

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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['auth', 'verified']], function(){

    Route::group(['middleware' => ['registration_completed']], function(){

        //All routs are here
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        Route::get('listings/{listingId}/photos/{photoId}/delete', [
            \App\Http\Controllers\ListingController::class, 'deletePhoto'
        ])->name('listing.delete-photo');
        Route::resource('listings', \App\Http\Controllers\ListingController::class);


        Route::resource('messages', \App\Http\Controllers\MessageController::class)
        ->only('create', 'store');


    });

    Route::get('register-step2',[\App\Http\Controllers\RegisterStepTwoController::class, 'create'])
    ->name('register-step-two.create');
    Route::post('register-step2',[\App\Http\Controllers\RegisterStepTwoController::class, 'store'])
    ->name('register-step-two.store');

});
