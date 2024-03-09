<?php
namespace App\Services\Location;



interface GeoCodingServiceInterface
{
    public function getCoordinatesFromPostcode(string $postcode): array;
}
