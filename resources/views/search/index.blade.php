<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>ValueSERP Search</h1>
        <form action="{{ route('search') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="searchQueries">Enter search queries (comma-separated):</label>
                <input type="text" class="form-control" id="searchQueries" name="queries" required>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>
    </div>
</body>
</html>
