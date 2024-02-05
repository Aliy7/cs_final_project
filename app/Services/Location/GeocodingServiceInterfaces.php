<?php
namespace App\Services\Location;

interface GeocodingServiceInterfaces {

    public function adrressAutoComp(string $term);
    public function findAddress(string $id);

}