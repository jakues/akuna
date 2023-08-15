<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Artisan;

class DashboardController extends Controller
{
    private function scrapInsta()
    {
        $client = new Client();

        $response = $client->request('GET', 'https://instagram-scraper-2022.p.rapidapi.com/ig/web_profile_info/?user=akunaindonesia', [
            'headers' => [
                'X-RapidAPI-Host' => 'instagram-scraper-2022.p.rapidapi.com',
                'X-RapidAPI-Key' => 'd5d4e9bb7cmshfb961a1e2c72fd1p13586fjsn984a527fb6cb',
            ],
        ]);

        return $response->getBody();
    }

    // Function to provide followers count
    public function getFollowers()
    {
        // Define the path to the followers.json file
        $filePath = storage_path('app/followers.json');

        // Check if the followers.json file exists
        if (file_exists($filePath)) {
            // Read the content of the file
            $jsonData = file_get_contents($filePath);

            // Decode the JSON data into an array of associative arrays
            $data = json_decode($jsonData, true);

            // Check if the JSON data was successfully decoded
            if (json_last_error() !== JSON_ERROR_NONE) {
                // Handle the case when JSON decoding fails
                return response()->json(['error' => 'Invalid JSON data in followers.json'], 500);
            }

            // Get today's date in the 'Y-m-d' format
            $currentDate = now()->format('Y-m-d');

            // Search for today's entry in the data array
            $edgeFollowedByCount = null;
            foreach ($data as $entry) {
                if ($entry['date'] === $currentDate) {
                    $edgeFollowedByCount = $entry['followers'];
                    break;
                }
            }

            // If today's entry is not found in the data, call scrapInsta() to get the count
            if ($edgeFollowedByCount === null) {
                $jsonData = $this->scrapInsta(); // Make sure scrapInsta() is defined and returning JSON data as a string.

                // Extract the "edge_followed_by" value using regular expressions
                $pattern = '/"edge_followed_by":\s*{"count":(\d+)}/'; // Regular expression pattern
                $matches = [];

                if (preg_match($pattern, $jsonData, $matches)) {
                    $edgeFollowedByCount = $matches[1];

                    // Add today's entry to the data array
                    $data[] = [
                        'date' => $currentDate,
                        'followers' => $edgeFollowedByCount,
                    ];

                    // Write the updated data array back to the followers.json file
                    file_put_contents($filePath, json_encode($data));
                } else {
                    // Handle the case when the pattern is not found in the JSON data
                    return response()->json(['error' => 'Pattern not found in JSON data'], 500);
                }
            }

            // Now you have the "edge_followed_by" count either from the file or by calling scrapInsta()
            // You can use it as needed, for example, return it as a response
            return response()->json(['ig_followers' => $edgeFollowedByCount]);
        } else {
            // Handle the case when followers.json file is not found
            return response()->json(['error' => 'File not found'], 500);
        }
    }

    // Function to fetch db health
    private function getDbHealth()
    {
        try {
            DB::connection()->getPdo();
            $status = 'healthy';
            $message = 'Database connection is healthy.';
        } catch (\Exception $e) {
            $status = 'unhealthy';
            $message = 'Database connection failed.';
        }

        return [
            'status' => $status,
            'message' => $message,
        ];
    }

    public function getDashboardData()
    {
        $totalTx = DB::table('pembelian')->count();
        $totalProduct = DB::table('product')->count();
        $totalMember = DB::table('users')->count();
        $dbHealth = $this->getDbHealth();

        $dashboardData = [
            'total_products' => $totalProduct,
            'total_transaction' => $totalTx,
            'total_member' => $totalMember - 1,
            'db_health_status' => $dbHealth['status'],
            'db_health_message' => $dbHealth['message'],
        ];

        return Response::json($dashboardData);
    }
}
