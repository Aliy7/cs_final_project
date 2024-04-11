<?php
namespace App\Livewire;

use App\Models\User;
use Livewire\Livewire;
use App\Mail\FoodPosted;
use App\Livewire\Dashboard;
use App\Livewire\Email\EmailSender;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Livewire\Contact\ContactForm;
use App\Livewire\Profile\ShowProfile;
use Illuminate\Support\Facades\Route;
use App\Livewire\Email\EmailComponent;
use App\Http\Controllers\SmsController;
use App\Livewire\Privacy\PrivacyPolicy;
use App\Livewire\CheckApplicationStatus;
use App\Livewire\reserve\ShowReservation;
use App\Livewire\GeocodePostCode\Location;
use App\Livewire\HelpPage\ShowHelpContent;
use App\Livewire\Profile\ProfileComponent;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Notification;
use App\Http\Controllers\GoogleMapController;
use App\Http\Controllers\SmsSenderController;
use App\Livewire\FoodListing\ShowFoodListing;
use App\Livewire\HelpPage\HelpContentManager;
use App\Livewire\Application\ShowApplications;
use App\Notifications\FoodListedNotifications;
use App\Livewire\FoodListing\CreateFoodListing;
use App\Http\Controllers\AutoCompleteController;
use App\Livewire\Application\ApplicationComponent;

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


// Route::get('/send-email', function() {
//     Mail::send(new FoodPosted());
//     return 'Email sent successfully!';
// });
Route::get('/send-email', EmailSender::class)->middleware(['auth'])->name('sendEmail');




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
        Route::get('/show-profile/{profileId}', ShowProfile::class)->name('profile.showProfile');

    });

    
    // In routes/web.php

Route::get('/google-map', function () {
    return view('googlemaps');
})->name('google-map');


Route::get('/reservations', ShowReservation::class)
    ->middleware(['auth'])
    ->name('reservations');

Route::get('/application-form', ApplicationComponent::class)->name('application-form')->middleware(['auth']);

Route::get('/show-application', ShowApplications::class)->middleware(['auth'])->name('show-application');

// Within routes/web.php

Route::middleware(['auth'])->group(function () {
    // Auto complete routes
    Route::get('/api/autocomplete/cities', [AutoCompleteController::class, 'getCities'])->name('autocomplete.cities');
    Route::get('/api/autocomplete/counties', [AutoCompleteController::class, 'getCounties'])->name('autocomplete.counties');
    Route::get('/api/autocomplete/countries', [AutoCompleteController::class, 'getCountries'])->name('autocomplete.countries');

    Route::get('/api/autocomplete/foodNames', [AutoCompleteController::class, 'autoFoodNames'])->name('autocomplete.foodNames');
    Route::get('/api/autocomplete/foodIngredients', [AutoCompleteController::class, 'autoIngredients'])->name('autocomplete.ingredients');
    Route::get('/api/autocomplete/description', [AutoCompleteController::class, 'autoDescription'])->name('autocomplete.description');
    Route::get('/api/autocomplete/allergens', [AutoCompleteController::class, 'autoAllergens'])->name('autocomplete.allergens');

    // Specific allergen description route
    Route::get('/api/allergens/description-for-allergen', [AutoCompleteController::class, 'getDescriptionForAllergen']);
});


//Contact us Route


Route::get('/contact-email', ContactForm::class)->name('contactUs-email');


//help page Route

Route::get('/help-page/create-content', HelpContentManager::class)->name('helpPage-createContent');
Route::get('/show/help-page', ShowHelpContent::class)->name('showHelp-page');
Route::get('/privacy-policy', PrivacyPolicy::class)->name('privacy-policy');
require __DIR__.'/auth.php';
