<?php
namespace App\Services\Location;

interface GeocodingServiceInterfaces {

    public function getCoordinatesFromPostcode(string $postcode): array;

}