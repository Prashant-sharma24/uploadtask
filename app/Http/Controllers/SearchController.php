<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;


class SearchController extends Controller
{
    public function index()
    {
        return view('search.index');
    }





    public function search(Request $request)
{
    // Validate the form input
    $request->validate([
        'queries' => 'required|string',
    ]);

    // Get the search queries from the form input
    $queries = $request->input('queries');
    $searchResults = [];

    // Split the queries by comma
    $queryArray = explode(',', $queries);

    foreach ($queryArray as $query) {
        $response = Http::withHeaders([
            'apikey' => '5ceae9f0-f664-11ee-9887-2b9de4672714',
        ])->get('https://app.zenserp.com/api/v2/search', [
            'q' => $query,
        ])->json();

        // Process the JSON response and extract relevant data
        $organicResults = isset($response['organic']) ? $response['organic'] : [];
        $processedResults = [];

        foreach ($organicResults as $result) {
            if (isset($result['title'])) {
                $processedResult = [
                    'title' => $result['title'],
                    'link' => $result['url'] ?? '',
                    'snippet' => $result['description'] ?? '',
                ];

                // Add the processed result to the array
                $processedResults[] = $processedResult;
            }
        }

        // Store the processed results in the searchResults array
        $searchResults[$query] = $processedResults;
    }

    // Return the search results to the view
    return view('search.results', compact('searchResults'));
}


//

public function showResults()
{
    // Retrieve the search results from the session
    $searchResults = Session::get('searchResults', []);

    return view('search.results', compact('searchResults'));
}


}
