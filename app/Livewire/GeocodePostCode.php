<?php

namespace App\Livewire;

use App\Service\Location\GeoCodingServiceInterface;
use Livewire\Component;

class GeocodePostCode extends Component
{
    // public $postcode;
    // public $latitude;
    // public $longitude;

    // public $rule = [
    //     'postcode' => 'required|string|max:8',
    // ];
    
    // public function mount(GeoCodingServiceInterface $geocodingService)
    // {
    //     $this->geocodingService = $geocodingService;
    // }

    // public function getCoordinates()
    // {
    //     $this->validate();
    //     $coordinates = $this->geocodingService->getCoordinatesFromPostcode($this->postcode);
    //     $this->latitude = $coordinates['latitude'];
    //     $this->longitude = $coordinates['longitude'];
    // }
    
    // public function render()
    // {
    //     return view('livewire.geocode-post-code');
    // }
}
