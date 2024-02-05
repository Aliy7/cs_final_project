<?php

namespace App\Livewire\Location;

use Livewire\Component;
use App\Models\Location;
use Illuminate\Support\Facades\Http;

class LocationSearch extends Component
{
    public $searchName = '';
    public $latitude = '';
    public $longitude = '';

    // public function saveLocation()
    // {
    //     $this->validate([
    //         'searchName' => 'required',
    //         'latitude' => 'required',
    //         'longitude' => 'required',
    //     ]);

    //     Location::create([
    //         'searchName' => $this->searchAddress,
    //         'latitude' => $this->latitude,
    //         'longitude' => $this->longitude,
    //     ]);

    //     $this->reset(['searchName', 'latitude', 'longitude']);
    // }
    public $food_listing_id;

    public function saveLocation()
    {
        $this->validate([
            'searchName' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);
    
        $location = Location::create([
            'searchName' => $this->searchName,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'food_listing_id' => $this->food_listing_id,
        ]);
    
        $this->reset(['searchName', 'latitude', 'longitude']);
    
        $this->dispatch('food-listing-component', 'locationUpdated');
    }
    
    public function mount()
{
    $this->fill([
        'latitude' => request()->get('latitude', ''), 
        'longitude' => request()->get('longitude', ''),
    ]);
}

protected $listeners = ['setLocationCoordinates'];

public function setLocationCoordinates($latitude, $longitude)
{
    $this->latitude = $latitude;
    $this->longitude = $longitude;
}
public function updateLocation($key, $lat, $lng)
{
    $this->latitude = $lat;
    $this->longitude = $lng;
}
    public function render()
    {
        return view('livewire.location.location-search')
        ->layout('layouts.app');

    }
}
