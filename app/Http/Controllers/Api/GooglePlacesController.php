<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GooglePlacesController extends Controller
{
    public function autocomplete(Request $request)
    {

        // I can use __invoke instead of function name because it is only one single function
        //later on replace it with __invoke

        $input = $request->input('input');
//        $apiKey = env('GOOGLE_MAPS_API_KEY');
        $apiKey = config('services.googleMaps.key');

        $response = Http::get("https://maps.googleapis.com/maps/api/place/autocomplete/json", [
            'input' => $input,
            'key' => $apiKey,
            'types' => 'geocode', // You can specify the type of place you want to search for
        ]);

        return $response->json()['predictions'];
    }
}
