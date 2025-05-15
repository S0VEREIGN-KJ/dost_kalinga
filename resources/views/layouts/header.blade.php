<!-- resources/views/layouts/header.blade.php -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOST-Kalinga</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
    ])
    
    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    
    <!-- MapLibre GL CSS & JS from CDN -->
    <link href="https://unpkg.com/maplibre-gl@^5.5.0/dist/maplibre-gl.css" rel="stylesheet" />
    <script src="https://unpkg.com/maplibre-gl@^5.5.0/dist/maplibre-gl.js"></script>

    <style>
        * {
            box-sizing: border-box;
        }

        header {
            height: 75px;
            margin-bottom: 10px;
        }

        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
        }

        #map {
            border: 2px solid #000;
            width: 100%;
            height: 600px;
        }

        .admin-btn {
            float: right;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin: 10px;
            border-radius: 25px;
        }

        .admin-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>

<header>
    <div>
    <div>
        <a href="{{ url('/admin') }}" class="admin-btn">Admin</a>
    </div>
    </div>
</header>
