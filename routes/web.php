<?php
namespace App\Livewire;

use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Livewire\reserve\ShowReservation;
use App\Livewire\GeocodePostCode\Location;
use App\Livewire\Profile\ProfileComponent;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\GoogleMapController;
use App\Livewire\Application\ApplicationComponent;
use App\Livewire\FoodListing\CreateFoodListing;
use App\Livewire\FoodListing\ShowFoodListing;

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

Route::view('/', 'welcome');

Route::get('/welcome', function(){
    return view('welcome');
})->name('welcome');

Route::get('/dashboard', Dashboard::class)
    ->middleware(['auth'])
    ->name('dashboard');



Route::get('/foodlisting', CreateFoodListing::class)
    ->middleware(['auth']) // Make sure the user is authenticated
    ->name('foodlisting');
Route::get('/showFoodListing', ShowFoodListing::class)
    ->middleware(['auth']) // Make sure the user is authenticated
    ->name('showFoodListing');

    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/welcome'); // Or wherever you wish to redirect after logout
    })->name('logout');
 
    Route::get('/profile', ProfileComponent::class)->middleware(['auth'])->name('profile.profile-updating');    
    Route::middleware('auth')->group(function () {
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('profile.showProfile');
    });

    
    // In routes/web.php

Route::get('/google-map', function () {
    return view('googlemaps');
})->name('google-map');

Route::post('/save-location', [LocationController::class, 'saveLocation'])->name('saveLocation');

Route::get('/reservations', ShowReservation::class)
    ->middleware(['auth'])
    ->name('reservations');

Route::get('/application-form', ApplicationComponent::class)->name('application');

require __DIR__.'/auth.php';
