<!-- resources/views/layouts/header.blade.php -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DOST-Kalinga</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js',
        'resources/css/add_proj_overlay.css',
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
        
      /* //overlay */
      .proj_overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.5);
    display: none;
    transition: opacity 0.3s ease;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
 /* Zoom In Animation */
@keyframes zoomIn {
  from {
    transform: scale(0.8) translate(-50%, -50%);
    opacity: 0;
  }
  to {
    transform: scale(1) translate(-50%, -50%);
    opacity: 1;
  }
}

/* Zoom Out Animation */
@keyframes zoomOut {
  from {
    transform: scale(1) translate(-50%, -50%);
    opacity: 1;
  }
  to {
    transform: scale(0.8) translate(-50%, -50%);
    opacity: 0;
  }
}

.proj_overlay-content {
  border: 1px solid rgb(121, 121, 121);
  background-color: white;
  padding: 20px;
  border-radius: 5px;
  width: 600px;
  text-align: center;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  animation-fill-mode: forwards;
}


/* Class for showing with zoom in */
.proj_overlay-content.show {
  animation: zoomIn 0.3s ease-out forwards;
}

/* Class for hiding with zoom out */
.proj_overlay-content.hide {
  animation: zoomOut 0.3s ease-in forwards;
}

  .proj_overlay-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-bottom: 10px;
    margin-bottom: 15px;
  }
  
  .proj_overlay-header h2 {
    margin: 0;
    font-size: 20px;
  }
  
  .proj_input-selection {
    border: 1px solid #ccc;
    padding: 15px;
    border-radius: 5px;
    margin-bottom: 20px;
  }
  
  .proj_input-selection label {
    display: block;
    text-align: left;
    margin: 10px 0 5px;
    font-weight: bold;
    color: #3399ff;
  }
  
  .proj_input-selection input {
    width: 100%;
    padding: 8px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 4px;
    height: 30px;
  }
  
  .proj_input-selection select {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
  }
  
  .proj_overlay-footer {
    text-align: right;
  }
  
  .kra_save-btn, .close-btn {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    margin: 5px;
  }
  
  .kra_save-btn:hover, .close-btn:hover {
    background-color: #0056b3;
  }
  
  .close-x {
    background: none;
    border: none;
    font-size: 24px;
    cursor: pointer;
    color: #999;
  }
  
  .close-x:hover {
    color: #000;
  }

  .proj_overlay_edit {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.5);
    display: none;
    transition: opacity 0.3s ease;
    justify-content: center;
    align-items: center;
    z-index: 1000;
  }
  
  .proj_overlay_edit-content {
    border: 1px solid rgb(121, 121, 121);
  background-color: white;
  padding: 20px;
  border-radius: 5px;
  width: 600px;
  text-align: center;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  animation-fill-mode: forwards;
}
/* Class for showing with zoom in */
.proj_overlay_edit-content.show {
  animation: zoomIn 0.3s ease-out forwards;
}

/* Class for hiding with zoom out */
.proj_overlay-content_edit.hide {
  animation: zoomOut 0.3s ease-in forwards;
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
