<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 — Wubba Lubba Dub Dub!</title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/error.css') }}">
</head>
<body>

    <div class="container">
        <img src="https://upload.wikimedia.org/wikipedia/en/c/c3/Morty_Smith.png" 
         alt="Morty Smith" class="error-img portal">
    <h1 class="display-4">503 — Service Unavailable!</h1>
    <p class="lead">“Server’s taking a portal break, Morty. It’ll be back soon!”</p>
        <a href="{{ route('tickets.index') }}" class="btn btn-home">
            Take Me Back to the Dashboard
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
