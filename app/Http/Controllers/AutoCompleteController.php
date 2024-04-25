<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\FoodListing;
use Illuminate\Http\Request;

/**
 * This controller is used for auto populating purpose with the app web 
 * Such as food listing form filling and application form submission.
 */
class AutoCompleteController extends Controller
{

    /**
     * This function auto populates cities from database 
     * Based on user's key word used within application section.
     */
    public function getCities(Request $request)
    {
        $query = $request->get('q');
        $cities = Address::where('city', 'like', "%{$query}%")
            ->groupBy('city')
            ->pluck('city')
            ->take(5);

        return response()->json($cities);
    }


    /**
     * This function auto populates counties from database 
     * Based on user's key word used within application section.
     */
    public function getCounties(Request $request)
    {
        $query = $request->get('q');
        $counties = Address::where('county', 'like', "%{$query}%")
            ->groupBy('county')
            ->pluck('county')
            ->take(5);

        return response()->json($counties);
    }

    /**
     * This function auto populates country from database 
     * Based on user's key word used within application section.
     */
    public function getCountries(Request $request)
    {
        $query = $request->get('q');
        $countries = Address::where('country', 'like', "%{$query}%")
            ->groupBy('country')
            ->pluck('country')
            ->take(5);

        return response()->json($countries);
    }

    /**
     * This function auto populates food names 
     * based on user's entery into the form field.
     */
    public function autoFoodNames(Request $request)
    {
        $query = $request->get('q');
        $foodNames = FoodListing::where('name', 'like', "%{$query}%")
            ->groupBy('name')
            ->pluck('name')
            ->take(5);
        return response()->json($foodNames);
    }

    /**
     * This function auto populates the ingredient section 
     * when creating food listing based on user's selection
     */

    public function autoIngredients(Request $request)
    {
        $query = $request->get('q');
        $ingredients = FoodListing::where('ingredients', 'like', "%{$query}%")
            ->groupBy('ingredients')
            ->pluck('ingredients')
            ->take(5);
        return response()->json($ingredients);
    }

    /**
     * This function auto-populates allergen description from dabase
     * where available
     */
    public function autoDescription(Request $request)
    {
        $query = $request->get('q');
        $descriptions = FoodListing::where('description', 'like', "%{$query}%")
            ->groupBy('description')
            ->pluck('description')
            ->take(5);
        return response()->json($descriptions);
    }

    /**
     * This fucntion auto populates allergen form field when
     * Creating food listing with the web ap.
     */
    public function autoAllergens(Request $request)
    {
        $query = $request->get('q');
        $descriptions = FoodListing::where('allergen', 'like', "%{$query}%")
            ->groupBy('allergen')
            ->pluck('allergen')
            ->take(5);
        return response()->json($descriptions);
    }

    /**
     * This function auto fills allergen description based on selected allergen from db
     */
    public function getDescriptionForAllergen(Request $request)
    {
        $allergen = $request->input('allergen');

        $description = FoodListing::where('allergen', $allergen)->first()->description ?? '';

        return response()->json(['description' => $description]);
    }
}
