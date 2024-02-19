<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GooglePlacesController extends Controller
{
    // i can use __invoke instead of function name becuase it is only one single function
    public function autocomplete(Request $request)  //later on replace it with __invoke
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
