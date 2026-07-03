<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class HomeController extends Controller
{
    public function index()
    {
        $weatherData = null;

        try {
            // Weather API Integration (e.g. OpenWeatherMap API)
            // Note: Your actual API Key should be set in the .env file
            $apiKey = config('services.weather.key', 'YOUR_API_KEY');
            $city = "Chennai";
            
            $response = Http::get("https://api.openweathermap.org/data/2.5/weather", [
                'q' => $city,
                'appid' => $apiKey,
                'units' => 'metric'
            ]);

            if ($response->successful()) {
                $weatherData = $response->json();
            }
        } catch (\Exception $e) {
            // Log the error to prevent the page from crashing if the API fails
            logger("Weather API Error: " . $e->getMessage());
        }

        // Send data to Blade view
        return view('index', compact('weatherData'));
    }
}