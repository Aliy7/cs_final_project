<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\FoodListing;
use Illuminate\Http\Request;

class AutoCompleteController extends Controller
{
    public function getCities(Request $request)
    {
        $query = $request->get('q');
        $cities = Address::where('city', 'like', "%{$query}%")
                         ->groupBy('city')
                         ->pluck('city')
                         ->take(5);

        return response()->json($cities);
    }

    public function getCounties(Request $request)
    {
        $query = $request->get('q');
        $counties = Address::where('county', 'like', "%{$query}%")
                           ->groupBy('county')
                           ->pluck('county')
                           ->take(5);

        return response()->json($counties);
    }

    public function getCountries(Request $request)
    {
        $query = $request->get('q');
        $countries = Address::where('country', 'like', "%{$query}%")
                            ->groupBy('country')
                            ->pluck('country')
                            ->take(5);

        return response()->json($countries);
    }


    public function autoFoodNames(Request $request) {
        $query = $request->get('q');
        $foodNames = FoodListing::where('name', 'like', "%{$query}%")
                                ->groupBy('name')
                                ->pluck('name')
                                ->take(5);
        return response()->json($foodNames);
    }

    
    public function autoIngredients(Request $request) {
        $query = $request->get('q');
        $ingredients = FoodListing::where('ingredients', 'like', "%{$query}%")
                                  ->groupBy('ingredients')
                                  ->pluck('ingredients')
                                  ->take(5);
        return response()->json($ingredients);
    }
    
    public function autoDescription(Request $request) {
        $query = $request->get('q');
        $descriptions = FoodListing::where('description', 'like', "%{$query}%")
                                   ->groupBy('description')
                                   ->pluck('description')
                                   ->take(5);
        return response()->json($descriptions);
    }
    public function autoAllergens(Request $request) {
        $query = $request->get('q');
        $descriptions = FoodListing::where('allergen', 'like', "%{$query}%")
                                   ->groupBy('allergen')
                                   ->pluck('allergen')
                                   ->take(5);
        return response()->json($descriptions);
    }

    public function getDescriptionForAllergen(Request $request) {
        $allergen = $request->input('allergen');
    
        // Assuming there's a method in FoodListing to get the description based on allergen
        $description = FoodListing::where('allergen', $allergen)->first()->description ?? '';
    
        return response()->json(['description' => $description]);
    }
    


}
