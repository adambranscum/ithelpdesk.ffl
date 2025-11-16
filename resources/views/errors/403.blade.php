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
             alt="Rick Sanchez"
             class="rick-img portal">

        <h1 class="display-4 mb-3">403 — Access Denied!</h1>
        <p class="lead mb-2">
            “Morty... looks like you don’t have the proper clearance to mess with this dimension’s information.”
        </p>

        <p class="mb-4">
            Either you’re not authorized, or someone needs to turn your permissions portal gun back on.
        </p>

        <a href="{{ route('tickets.index') }}" class="btn btn-home">
            Take Me Back to the Dashboard
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
