<?php
namespace App\Services\Location;

use Illuminate\Support\Facades\Http;

class GeocodingService implements GeocodingServiceInterfaces
{
    protected $api_key;

    public function __construct()
    {
        // Ensure your Google Maps API key is stored in your .env file for security
        $this->api_key = env('GOOGLE_MAPS_API_KEY'); 
    }

    public function adrressAutoComp($term)
    {
        // Using Google Places API for autocomplete. Note: You might need to adjust parameters as per your needs.
        $response = Http::get("https://maps.googleapis.com/maps/api/place/autocomplete/json", [
            'input' => $term,
            'key' => $this->api_key,
            'types' => 'geocode', // Adjust if you're looking for other types of places
        ]);

        if ($response->successful()) {
            return array_map(function ($item) {
                return ['id' => $item['place_id'], 'text' => $item['description']];
            }, $response->json()['predictions']);
        } else {
            throw new \Exception("Unable to autocomplete address: " . $response->body());
        }
    }

    public function findAddress($placeId)
    {
        $response = Http::get("https://maps.googleapis.com/maps/api/geocode/json", [
            'place_id' => $placeId,
            'key' => $this->api_key,
        ]);

        if ($response->successful()) {
            $details = $response->json()['results'][0];
            $addressComponents = $details['address_components'];
            $locationData = [];

            foreach ($addressComponents as $component) {
                $types = $component['types'];
                if (in_array('postal_code', $types)) {
                    $locationData['postcode'] = $component['long_name'];
                } elseif (in_array('locality', $types) || in_array('postal_town', $types)) {
                    $locationData['city'] = $component['long_name'];
                } elseif (in_array('country', $types)) {
                    $locationData['country'] = $component['long_name'];
                } elseif (in_array('administrative_area_level_1', $types)) {
                    $locationData['state'] = $component['long_name'];
                }
            }

            return $locationData;
        } else {
            throw new \Exception("Unable to get address details: " . $response->body());
        }
    }

}