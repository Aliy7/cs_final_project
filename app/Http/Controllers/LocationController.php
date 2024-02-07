<?php
namespace App\Http\Controllers;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function saveLocation(Request $request)
    {
        $validatedData = $request->validate([
            'searchName' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            // 'food_listing' => 'optional'
            // 'food_listing_id' => 'required',
        ]);

        // Attempt to save the location data
        Location::create($validatedData);
        // dd($validatedData);

        // Prepare the view with necessary data
        $view = view('livewire.location.location-search', ['message' => 'Location saved successfully!'])->render();

        if ($request->ajax()) {
            return response()->json(['html' => $view]);
        }

        return view('livewire.location.location-search', ['message' => 'Location saved successfully!']);
    }
}