<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <!-- Display search results -->
        @foreach ($searchResults as $query => $results)
            <h3>Results for "{{ $query }}"</h3>
            <button id="exportBtn" class="btn btn-primary" onclick="exportToCSV()">Export to CSV</button>
            @if (empty($results))
                <p>No results found</p>
            @else
                @foreach ($results as $result)

                    <div>
                        <strong>Title:</strong> {{ $result['title'] }}<br>
                        <strong>Link:</strong> <a href="{{ $result['link'] }}">{{ $result['link'] }}</a><br>
                        <strong>Snippet:</strong> {{ $result['snippet'] }}
                    </div>
                    <br> <!-- Add line break between each result -->
                @endforeach
            @endif
        @endforeach

        <!-- Button to export results to CSV -->


    </div>

    <!-- Include jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script>
        function exportToCSV() {
            // Send a POST request to the export route
            fetch('/export-results', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ searchResults: {!! json_encode($searchResults) !!} }) // Pass searchResults data to the backend
            })
            .then(response => {
                // Handle the response
                if (response.ok) {
                    // Response is OK (status code 200)
                    console.log('CSV exported successfully');
                    // Trigger a download of the response data
                    response.blob().then(blob => {
                        const url = window.URL.createObjectURL(blob);
                        const a = document.createElement('a');
                        a.href = url;
                        a.download = 'search_results.csv';
                        document.body.appendChild(a);
                        a.click();
                        window.URL.revokeObjectURL(url);
                        document.body.removeChild(a);
                    });
                } else {
                    // Response is not OK
                    console.error('Error exporting CSV:', response.statusText);
                }
            })
            .catch(error => {
                // Handle any errors that occur during the fetch operation
                console.error('Error exporting CSV:', error);
            });
        }
    </script>

</body>
</html>
