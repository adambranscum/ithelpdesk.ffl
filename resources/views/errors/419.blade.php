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
       <img src="https://upload.wikimedia.org/wikipedia/en/a/a6/Rick_Sanchez.png" 
         alt="Rick Sanchez" class="error-img portal">
    <h1 class="display-4">419 — Session Expired!</h1>
    <p class="lead">“Morty... your CSRF token evaporated in the time vortex!”</p>
        <a href="{{ route('login') }}" class="btn btn-home">
            Take Me Back to login
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
