<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GoogleMapController extends Controller
{

    public function index()
    {
        // Fetch data from database, etc.
        $data = [];

        return view('googlemap', compact('data'));
    }
}
