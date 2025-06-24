<!-- resources/views/layouts/header.blade.php -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      
    <title>DOST-Kalinga</title>
    <link rel="icon" href="{{ asset('DOST.png') }}" type="image/png">
    @vite([
        'resources/css/home.css',
        'resources/js/home.js',
    ])

    <!-- Material Icons -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />
    
    <!-- MapLibre GL CSS & JS from CDN -->
    <link href="https://unpkg.com/maplibre-gl@^5.5.0/dist/maplibre-gl.css" rel="stylesheet" />
    <script src="https://unpkg.com/maplibre-gl@^5.5.0/dist/maplibre-gl.js"></script>


</head>

<header class="main-header">
    <div class="header-image">
        <div class="logo-circle">
            <img src="{{ asset('images/DOST_kalinga_logo.png') }}" alt="Logo">
        </div>
        <div class="logo-text">
            <span class="logo-title">Provincial Science and Technology Office - Kalinga</span>
        <br>
            <span style="font-size:20pt;"  class="logo-title">PSTO-Kalinga Project Locator</span>
        </div>
    </div>
        <!-- Middle Image -->
    <div class="middle-image">
        <img src="{{ asset('images/PSTC-Kalinga.jpg') }}" alt="Middle Logo">
    </div>
    <div>
        <button onclick="openAdminLogin()" class="admin-btn">Admin</button>
    </div>
</header>
   <div class="custom-shape-divider-bottom-1743647769">
                <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 120" preserveAspectRatio="none">
                    <path d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z" opacity=".25" class="shape-fill"></path>
                    <path d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z" opacity=".5" class="shape-fill"></path>
                    <path d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z" class="shape-fill"></path>
                </svg>
            </div>

<!-- Admin Login Modal -->
<div id="adminLoginOverlay" class="admin-login-overlay">
    <div class="admin-login-modal">
        <button class="close-login" onclick="closeAdminLogin()">&times;</button>
        <div class="admin-login-header">
            <h2>Admin Login</h2>
        </div>
        <form id="adminLoginForm" class="admin-login-form">
            <div class="form-group">
              <label for="username">Username:</label>
              <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="error-message" id="loginError"></div>
            <div class="login-buttons">
                <button type="button" class="login-btn secondary" onclick="closeAdminLogin()">Cancel</button>
                <button type="submit" class="login-btn primary">Login</button>
            </div>
        </form>
    </div>
</div>

<script>
  function openAdminLogin() {
        document.getElementById('adminLoginOverlay').style.display = 'flex';
        document.body.style.overflow = 'hidden'; // Prevent scrolling
    }

    function closeAdminLogin() {
        document.getElementById('adminLoginOverlay').style.display = 'none';
        document.body.style.overflow = 'auto'; // Restore scrolling
        // Clear form and error message
        document.getElementById('adminLoginForm').reset();
        document.getElementById('loginError').style.display = 'none';
    }

document.getElementById('adminLoginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const errorDiv = document.getElementById('loginError');
    
    // Create FormData object - REMOVE _token from here
    const formData = new FormData();
    formData.append('username', username);
    formData.append('password', password);
    // Send login request
    fetch('/admin/login', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Redirect to admin dashboard
            window.location.href = data.redirect;
        } else {
            // Show error message
            errorDiv.textContent = data.message || 'Invalid credentials';
            errorDiv.style.display = 'block';
        }
    })
    .catch(error => {
        console.error('Login error:', error);
        errorDiv.textContent = 'An error occurred. Please try again.';
        errorDiv.style.display = 'block';
    });
});

    // Close modal when clicking outside of it
    document.getElementById('adminLoginOverlay').addEventListener('click', function(e) {
        if (e.target === this) {
            closeAdminLogin();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && document.getElementById('adminLoginOverlay').style.display === 'flex') {
            closeAdminLogin();
        }
    });

</script>