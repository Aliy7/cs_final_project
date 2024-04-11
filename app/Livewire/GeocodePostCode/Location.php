<?php

namespace App\Livewire\GeocodePostCode;

use Log;
use Livewire\Component;
use App\Services\Location\GeocodingService;
use App\Services\Location\GeocodingServiceInterfaces;

class Location extends Component
{

    public $term;
    public $suggestions = [];
    public $selectedAddress;
     public $geocodingService;
     protected $street, $city, $state, $postalCode, $country;

    public function mount(GeocodingService $geocodingService)
    {
        $this->geocodingService = $geocodingService;
    }

    public function updatedPostalCode($value)
    {
        if (strlen($value) >= 5) { // Assuming postal codes have at least 5 characters.
            try {
                // Replace 'GeocodingService' with the actual service class you're using.
                $addressDetails = app(GeocodingService::class)->findAddress($value);
                $this->street = $addressDetails['street'] ?? '';
                $this->city = $addressDetails['city'] ?? '';
                $this->state = $addressDetails['state'] ?? '';
                $this->country = $addressDetails['country'] ?? '';
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to fetch address details.');
            }
            $this->dispatch('addressUpdated', $addressDetails);
        }
    }

    public function setSelectedAddress($placeId)
    {
        try {
            $addressDetails = app(GeocodingService::class)->findAddress($placeId);
            // Populate your address fields with the returned data
            $this->street = $addressDetails['street'] ?? '';
            $this->city = $addressDetails['city'] ?? '';
            $this->state = $addressDetails['state'] ?? '';
            $this->postalCode = $addressDetails['postcode'] ?? '';
            $this->country = $addressDetails['country'] ?? '';
        } catch (\Exception $e) {
            session()->flash('error', 'Failed to fetch address details.');
        }
    }


    public function render()
    {
        // dd("Rendering Location component");
        return view('livewire.geocode-post-code.location');
        // ->layout('layouts.app');
    }
}