<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GooglePlacesController extends Controller
{
    public function autocomplete(Request $request)
    {
        $input = $request->input('input');
        $apiKey = env('GOOGLE_MAPS_API_KEY');

        $response = Http::get("https://maps.googleapis.com/maps/api/place/autocomplete/json", [
            'input' => $input,
            'key' => $apiKey,
            'types' => 'geocode', // You can specify the type of place you want to search for
        ]);

        return $response->json()['predictions'];
    }
}
