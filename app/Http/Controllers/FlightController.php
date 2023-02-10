<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;

class FlightController extends Controller
{
    public function searchFlights(Request $request)
    {
        // API key for Ryanair's API
        $apiKey = "your_api_key";

        // Set the departure and arrival airports
        $departureAirport = "MXP";
        $arrivalAirport = "VIE";

        // Set the departure date
        $departureDate = $request->input('departure_date');

        // Create a Guzzle client
        $client = new Client();

        $endpoint = "https://api.ryanair.com/core/3/routes/$departureAirport/destinations";

        // Make a GET request to Ryanair's API
        $response = $client->get($endpoint, [
            'query' => [
                'apikey' => $apiKey,
                'dateFrom' => $departureDate,
                'dateTo' => $departureDate,
            ],
        ]);

        // Decode the JSON response
        $data = json_decode($response->getBody(), true);

        // Find the flight information for the desired route
        $flights = array_filter($data['routes'], function ($route) use ($arrivalAirport) {
            return $route['airportTo'] === $arrivalAirport;
        });

        // Return the flight information
        return response()->json($flights);
    }
}
