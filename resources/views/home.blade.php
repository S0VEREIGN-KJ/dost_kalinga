<!-- /**
 * Project: PSTO-Kalinga Innovation, Setup & Project Locator
 * Author: Karl Jasper G. Del Rosario
* Email: karljasper1231@gmail.com
 * Date: June 2025
 * Description:  This project visualizes DOST project locations in Kalinga using a map-based interface.
 */
  -->
 
<!-- resources/views/welcome.blade.php -->
@include('layouts.header')


<body>


    <div id="map"></div>

    <div class="legend-container">
        <!-- Legends Column -->
        <div class="legends-column">
            <div class="column-title">Map Legends</div>
            
            <div class="legend-item">
                <div class="legend-icon" style="background-color: #28a745;">
                    <img src="{{ asset('images/markers/agriculture.png') }}" alt="Agriculture" style="width: 40px; height: 40px;">
                </div>
                <div class="legend-description">Agriculture Sector</div>
            </div>
            
            <div class="legend-item">
                <div class="legend-icon" style="background-color: #007bff;">
                    <img src="{{ asset('images/markers/engineering.png') }}" alt="Engineering" style="width: 40px; height: 40px;">
                </div>
                <div class="legend-description">Engineering Sector</div>
            </div>
            
            <div class="legend-item">
                <div class="legend-icon" style="background-color:rgb(54, 41, 0);">
                    <img src="{{ asset('images/markers/food.png') }}" alt="Food" style="width: 40px; height: 40px;">
                </div>
                <div class="legend-description">Food Processing Sector</div>
            </div>
            
            <div class="legend-item">
                <div class="legend-icon" style="background-color:rgb(0, 0, 0);">
                    <img src="{{ asset('images/markers/furniture.png') }}" alt="Furniture" style="width: 40px; height: 40px;">
                </div>
                <div class="legend-description">Furniture Sector</div>
            </div>
            
            <div class="legend-item">
                <div class="legend-icon" style="background-color: #6f42c1;">
                    <img src="{{ asset('images/markers/handicrafts.png') }}" alt="Handicrafts" style="width: 40px; height: 40px;">
                </div>
                <div class="legend-description">Handicrafts Sector</div>
            </div>
            
            <div class="legend-item">
                <div class="legend-icon" style="background-color: #20c997;">
                    <img src="{{ asset('images/markers/health.png') }}" alt="Healthcare" style="width: 40px; height: 40px;">
                </div>
                <div class="legend-description">Healthcare Sector</div>
            </div>

             <div class="legend-item">
                <div class="legend-icon" style="background-color: #20c997;">
                    <img src="{{ asset('images/markers/ict.png') }}" alt="ICT" style="width: 40px; height: 40px;">
                </div>
                <div class="legend-description">ICT Sector</div>
            </div>

             <div class="legend-item">
                <div class="legend-icon" style="background-color: #20c997;">
                    <img src="{{ asset('images/markers/others.png') }}" alt="Others" style="width: 40px; height: 40px;">
                </div>
                <div class="legend-description">Others</div>
            </div>
        </div>
        
        <!-- Municipality Lists Column -->
        <div class="dropdown-column">
            <div class="column-title">Municipality Lists</div>
            
            <div id="municipalityAccordion" class="municipality-accordion">
                <!-- Municipality items will be populated here -->
            </div>
        </div>
    </div>


<script src="https://cdn.jsdelivr.net/npm/maplibre-gl@2.4.0/dist/maplibre-gl.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>


</script>
@if(session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session('success') }}',
            confirmButtonColor: '#3085d6'
        });
    </script>
@endif

@include('layouts.footer')
</body>


@include('components.chatbot') 


