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
    // public $geocodingService;

    public function mount(GeocodingService $geocodingService)
    {
        $this->geocodingService = $geocodingService;
    }

    public function updatedTerm()
    {
        dd($this->term);
        if (strlen($this->term) > 2) {
            try {
                $this->suggestions = app(GeocodingService::class)->addressAutoComp($this->term);
            } catch (\Exception $e) {
                session()->flash('error', 'Failed to fetch address suggestions.');
            }
        }
    }

    public function setSelectedAddress($placeId)
    {
        try {
            $addressDetails = $this->geocodingService->findAddress($placeId);
            // Assuming you have a Location model ready to store the address details
            Location::create($addressDetails);
            $this->selectedAddress = implode(', ', $addressDetails);
            session()->flash('success', 'Address selected successfully.');
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