<?php
namespace App\Livewire;

use App\Livewire\Dashboard;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Profile\ProfileComponent;
use App\Http\Controllers\ProfileController;
use App\Livewire\FoodListing\CreateFoodListing;

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

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/foodlisting', CreateFoodListing::class)
    ->middleware(['auth']) // Make sure the user is authenticated
    ->name('foodlisting');

    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();
        return redirect('/welcome'); // Or wherever you wish to redirect after logout
    })->name('logout');
 
    Route::get('profile', ProfileComponent::class)->middleware(['auth'])->name('profile.profile-updating');    
    Route::middleware('auth')->group(function () {
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        Route::get('/profile/{id}', [ProfileController::class, 'showProfile'])->name('profile.showProfile');
    });
    
require __DIR__.'/auth.php';
