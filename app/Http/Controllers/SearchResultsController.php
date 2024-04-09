<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class SearchResultsController extends Controller
{
    public function export(Request $request)
    {
        // Retrieve search results from the request
        $searchResults = $request->input('searchResults');

        // Initialize CSV content
        $csvData = '';

        // Add headers to the CSV
        $csvData .= "Title,Link,Snippet\n";

        // Loop through each search result and add to CSV data
        foreach ($searchResults as $query => $results) {
            foreach ($results as $result) {
                // Escape double quotes in the values
                $title = str_replace('"', '""', $result['title']);
                $link = str_replace('"', '""', $result['link']);
                $snippet = str_replace('"', '""', $result['snippet']);

                // Concatenate values with commas and add to CSV data
                $csvData .= "\"$title\",\"$link\",\"$snippet\"\n";
            }
        }

        // Set response headers for CSV download
        $headers = array(
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=search_results.csv',
        );

        // Return CSV file as a download response
        return Response::make($csvData, 200, $headers);
    }
}
