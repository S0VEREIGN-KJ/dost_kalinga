<!-- /**
 * Project: PSTC-Kalinga Innovation, Setup & Project Locator
 * Author: Karl Jasper G. Del Rosario
 * Date: June 2025
 * Description:  This project visualizes DOST project locations in Kalinga using a map-based interface.
 */
  -->
 

  
<!-- resources/views/welcome.blade.php -->
@include('layouts.admin-header')

<body>

<!-- Project Creation Overlay -->
<div id="proj_overlay" class="proj_overlay" style="display: none;">
  <div class="proj_overlay-content">
    <div class="proj_overlay-header">
      <h2>Add New Project</h2>
      <button class="close-x" onclick="closeOverlay()">X</button>
    </div>

    <div class="proj_input-selection">
      <label for="project_name">Project Name:</label>
      <input type="text" id="project_name" placeholder="Enter Project Name">

      <label for="organization">Organization:</label>
      <input type="text" id="organization" placeholder="Enter organization">

      <label for="type">Type:</label>
      <select id="type">
          <option value="">-- Select Type --</option>
          <option value="Setup">Setup</option>
          <option value="Community Based">Community Based</option>
          <option value="Assisted">Assisted</option>
      </select>

      <label for="description">Description:</label>
      <input type="text" id="description" placeholder="Enter Description" style="height: 80px;">

    <label for="type">Municpality:</label>
      <select id="municipality">
          <option value="">-- Select Municipality --</option>
          <option value="Balbalan">Balbalan</option>
          <option value="Lubuagan">Lubuagan</option>
          <option value="Pasil">Pasil</option>
          <option value="Pinukpuk">Pinukpuk</option>
          <option value="Rizal">Rizal</option>
          <option value="Tanudan">Tanudan</option>
          <option value="Tabuk">Tabuk</option>
          <option value="Tinglayan">Tinglayan</option>
      </select>

      <label for="address">Address:</label>
      <input type="text" id="address" placeholder="Enter Address">

      <label for="sector">Sector:</label>
      <select id="sector">
          <option value="">-- Select Sector --</option>
          <option value="Food Processing">Food Processing</option>
          <option value="Furniture">Furniture</option>
          <option value="Handicrafts">Handicrafts</option>
          <option value="Metals and Engineering">Metals & Engineering</option>
          <option value="Agriculture">Agriculture</option>
          <option value="Health">Health</option>
          <option value="ICT">ICT</option>
          <option value="Other Regional Industry">Other Regional Industry</option>
      </select>


      <label for="status">Status:</label>
      <select id="status">
          <option value="">-- Select Status --</option>
          <option value="Completed">Completed</option>
        <option value="On-going">On-going</option>
        <option value="new">New</option>
        <option value="Graduated">Graduated</option>
        <option value="Withdrawn">Withdrawn</option>
        <option value="Terminated">Terminated</option>
      </select>

      <!-- Hidden inputs for coordinates -->
      <input type="hidden" id="latitude">
      <input type="hidden" id="longitude">
    </div>

    <div class="proj_overlay-footer">
      <button class="kra_save-btn" onclick="submitProject()">Save</button>
    </div>
  </div>
</div>



<!-- Edit Project Overlay -->
<div id="proj_overlay_edit" class="proj_overlay" style="display: none;">
  <div class="proj_overlay_edit-content">
    <div class="proj_overlay-header">
      <h2 id="overlay-title">Edit Project</h2>
      <button class="close-x" onclick="closeEditOverlay()">X</button>
    </div>

    <div class="proj_input-selection">
      <label for="edit_project_name">Project Name:</label>
      <input type="text" id="edit_project_name" placeholder="Enter Project Name">

      <label for="edit_organization">Organization:</label>
      <input type="text" id="edit_organization" placeholder="Enter organization">

      <label for="edit_type">Type:</label>
      <select id="edit_type">
        <option value="">-- Select Type --</option>
        <option value="Setup">Setup</option>
        <option value="Community Based">Community Based</option>
        <option value="Assisted">Assisted</option>
      </select>

      
      <label for="edit_description">Description:</label>
      <input type="text" id="edit_description" placeholder="Enter Description" style="height: 80px;">

      <label for="edit_type">Municpality:</label>
      <select id="edit_municipality">
          <option value="">-- Select Municipality --</option>
          <option value="Balbalan">Balbalan</option>
          <option value="Lubuagan">Lubuagan</option>
          <option value="Pasil">Pasil</option>
          <option value="Pinukpuk">Pinukpuk</option>
          <option value="Rizal">Rizal</option>
          <option value="Tanudan">Tanudan</option>
          <option value="Tabuk">Tabuk</option>
          <option value="Tinglayan">Tinglayan</option>
      </select>

      <label for="edit_address">Address:</label>
      <input type="text" id="edit_address" placeholder="Enter Address">

      <label for="edit_sector">Sector:</label>
      <select id="edit_sector">
        <option value="">-- Select Sector --</option>
        <option value="Food Processing">Food Processing</option>
        <option value="Furniture">Furniture</option>
        <option value="Handicrafts">Handicrafts</option>
        <option value="Metals and Engineering">Metals & Engineering</option>
        <option value="Agriculture">Agriculture</option>
        <option value="Health">Health</option>
        <option value="ICT">ICT</option>
        <option value="Other Regional Industry">Other Regional Industry</option>
      </select>

      <label for="edit_status">Status:</label>
      <select id="edit_status">
        <option value="">-- Select Status --</option>
        <option value="Completed">Completed</option>
        <option value="On-going">On-going</option>
        <option value="new">New</option>
        <option value="Graduated">Graduated</option>
        <option value="Withdrawn">Withdrawn</option>
        <option value="Terminated">Terminated</option>
      </select>

      <!-- Hidden inputs for coordinates -->
      <input type="hidden" id="edit_latitude">
      <input type="hidden" id="edit_longitude">
      <input type="hidden" id="edit_project_id"> <!-- For editing -->
    </div>

    <div class="proj_overlay-footer">
      <button class="kra_save-btn" onclick="updateProject()">Update</button>
    </div>
  </div>
</div>



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
    document.addEventListener('DOMContentLoaded', function () {
        Swal.fire({
            title: 'Welcome ADMIN',
            text: 'Welcome back to the ADMIN page',
            imageUrl: '{{ asset("images/DOST_kalinga_logo.png") }}', // or use a CDN link
            imageWidth: 350,
            imageHeight: 150,
            imageAlt: 'Admin Banner',
            confirmButtonColor: '#3085d6'
        });
    });
</script>


    <script>

// Laravel API connection
const API_BASE_URL = '/'; // Laravel API base URL

// Fetch municipalities and projects from Laravel API
async function fetchMunicipalityData() {
    try {
        // ✅ Correct fetch URL
        const response = await fetch(`${API_BASE_URL}projects`);
        
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }

                const data = await response.json();
                const projects = data.data || data; // Handle Laravel API resource format
                
                // Group projects by municipality
                const municipalityData = {};
                projects.forEach(project => {
                    const municipality = project.proj_municipality;
                    if (!municipalityData[municipality]) {
                        municipalityData[municipality] = [];
                    }
                    municipalityData[municipality].push({
                        id: project.proj_id,
                        name: project.proj_name,
                        description: project.proj_desc,
                        type: project.proj_type,
                        organization: project.org_name,
                        address: project.proj_address,
                        sector: project.sector,
                        status: project.status,
                        location: project.proj_loc,
                        created: project.proj_created
                    });
                });
                
                return municipalityData;
            } catch (error) {
                console.error('Error fetching municipality data:', error);
                // Show error message to user
                Swal.fire({
                    icon: 'error',
                    title: 'Connection Error',
                    text: 'Unable to load project data. Please check your connection.',
                    confirmButtonColor: '#007bff'
                });
                // Return empty object to prevent further errors
                return {};
            }
        }
        // Populate municipality accordion with database data
async function populateMunicipalityAccordion() {
    const accordion = document.getElementById('municipalityAccordion');
    const municipalityData = await fetchMunicipalityData();
    
    // Clear existing content
    accordion.innerHTML = '';

    // Convert municipalityData into an array with count
    const sortedMunicipalities = Object.entries(municipalityData)
        .map(([municipality, projects]) => ({
            name: municipality,
            projects,
            count: projects.length
        }))
        .sort((a, b) => b.count - a.count); // Sort by project count descending

    // Loop through sorted municipalities
    sortedMunicipalities.forEach(({ name, projects, count }) => {
        // Create municipality item container
        const municipalityItem = document.createElement('div');
        municipalityItem.className = 'municipality-item';
        
        // Create municipality header (clickable)
        const header = document.createElement('button');
        header.className = 'municipality-header';
        header.innerHTML = `
            <span style="font-weight: bold; font-size: 14pt;" class="municipality-name">${name}</span>
            <span class="project-count">(${count} projects)</span>
            <span class="accordion-arrow">▼</span>
        `;
        
        // Create projects content container
        const projectsContent = document.createElement('div');
        projectsContent.className = 'projects-content';

        if (projects.length > 0) {
            projects.forEach(project => {
                const projectDiv = document.createElement('div');
                projectDiv.className = 'project-item';
                projectDiv.innerHTML = `
                    <strong>${project.name}</strong>
                    <div style="font-size: 12px; color: #666; margin-top: 2px;">
                        ${project.type} • ${project.sector} • ${project.status}
                    </div>
                `;
                projectDiv.onclick = () => handleProjectClick(project);
                projectsContent.appendChild(projectDiv);
            });
        } else {
            projectsContent.innerHTML = '<div class="no-projects">No projects available.</div>';
        }

        // Add click event to header
        header.addEventListener('click', () => toggleMunicipality(header, projectsContent));

        // Append to accordion
        municipalityItem.appendChild(header);
        municipalityItem.appendChild(projectsContent);
        accordion.appendChild(municipalityItem);
    });
}


        // Toggle municipality accordion
        function toggleMunicipality(header, content) {
            const isActive = header.classList.contains('active');
            
            // Close all other accordions
            document.querySelectorAll('.municipality-header').forEach(h => {
                h.classList.remove('active');
            });
            document.querySelectorAll('.projects-content').forEach(c => {
                c.classList.remove('expanded');
            });
            
            // Toggle current accordion
            if (!isActive) {
                header.classList.add('active');
                content.classList.add('expanded');
            }
        }

        // Handle project click with detailed information
        function handleProjectClick(project) {
            Swal.fire({
                html: `
        <div class="project-details" style="text-align: left; padding: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Project Name:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;">${project.name}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Organization:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;">${project.organization}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Type:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;">${project.type}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Description:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;">${project.description}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Address:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;">${project.address}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Sector:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;">${project.sector}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Status:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;"><span style="color: ${getStatusColor(project.status)}">${project.status}</span></div>
            </div>
        </div>
                `,
                confirmButtonText: 'Close',
                confirmButtonColor: '#007bff'
            });
        }

        // Get status color for visual feedback
        function getStatusColor(status) {
            switch(status.toLowerCase()) {
                case 'active': return '#28a745';
                case 'ongoing': return '#ffc107';
                case 'completed': return '#007bff';
                case 'pending': return '#fd7e14';
                default: return '#6c757d';
            }
        }

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            populateMunicipalityAccordion();
        });



// MAP FUNCTIONs
const editOverlay = document.querySelector('.proj_overlay_edit');
const overlay = document.querySelector('.proj_overlay');
const content = document.querySelector('.proj_overlay-content');
const editContent = document.querySelector('.proj_overlay_edit-content');

const iconMap = {
  'Food Processing': '/images/markers/food.png',
  'Furniture': '/images/markers/furniture.png',
  'Handicrafts': '/images/markers/handicrafts.png',
  'Metals and Engineering': '/images/markers/engineering.png',
  'Agriculture': '/images/markers/agriculture.png',
  'Health': '/images/markers/health.png',
  'ICT': '/images/markers/ict.png'
};


function clearNewProjectForm() {
  document.getElementById('project_name').value = '';
  document.getElementById('organization').value = '';
  document.getElementById('type').value = '';
  document.getElementById('description').value = '';
  document.getElementById('municipality').value = '';
  document.getElementById('address').value = '';
  document.getElementById('sector').value = '';
  document.getElementById('status').value = '';
  document.getElementById('latitude').value = '';
  document.getElementById('longitude').value = '';
}


function openOverlay(lat, lng) {
  clearNewProjectForm(); 

    document.getElementById('latitude').value = lat;
    document.getElementById('longitude').value = lng;
    overlay.style.display = 'flex';
  content.classList.remove('hide');
  content.classList.add('show');
}

function closeOverlay() {
    content.classList.remove('show');
    content.classList.add('hide');
  setTimeout(() => {
    overlay.style.display = 'none';
  }, 300); // match animation duration
}
function closeEditOverlay() {
  const editOverlay = document.getElementById('proj_overlay_edit');
  const editContent = editOverlay.querySelector('.proj_overlay_edit-content');

  setTimeout(() => {
    editOverlay.style.display = 'none';
  }, 300); // match your CSS animation duration
}

    const kalingaBounds = [
        [120.70, 17.05],
        [122.00, 17.85]
    ];

    const map = new maplibregl.Map({
        container: 'map',
        style: 'https://api.maptiler.com/maps/hybrid/style.json?key=9tZsVgNprhadpHJdkGYm',
        center: [121.33, 17.45],
        zoom: 9.5,
        maxBounds: kalingaBounds
    });

    // Store markers and popups keyed by project ID for easy updates
    const markers = {};

    function createPopupHTML(project) {
          // Helper to safely escape HTML if needed (optional)
    function escapeHTML(str) {
        return String(str).replace(/[&<>"']/g, s =>
            ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[s]);
    }

     // Simple popup content for hover - no overlay structure
    return `
        <div class="popup-content" style="padding: 10px; min-width: 200px;">
            <h3 style="margin: 0 0 10px 0; font-size: 16px;">${escapeHTML(project.proj_name)}</h3>
            <p style="margin: 5px 0;"><strong>Organization:</strong> ${escapeHTML(project.org_name)}</p>
            <p style="margin: 5px 0;"><strong>Type:</strong> ${escapeHTML(project.proj_type)}</p>
            <p style="margin: 5px 0;"><strong>Sector:</strong> ${escapeHTML(project.sector)}</p>
            <p style="margin: 5px 0;"><strong>Status:</strong> ${escapeHTML(project.status)}</p>
            <p style="margin: 5px 0; font-size: 12px; color: #666;">Click for more details</p>
        </div>
    `;
}

function createDetailedHTML(project) {
    // Helper to safely escape HTML
    function escapeHTML(str) {
        return String(str).replace(/[&<>"']/g, s =>
            ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[s]);
    }

    // Detailed content for the SweetAlert modal
    return `
        <div class="project-details" style="text-align: left; padding: 20px;">
            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Project Name:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;">${escapeHTML(project.proj_name)}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Organization:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;">${escapeHTML(project.org_name)}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Type:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;">${escapeHTML(project.proj_type)}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Description:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;">${escapeHTML(project.proj_desc)}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Municipality:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;">${escapeHTML(project.proj_municipality)}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Address:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;">${escapeHTML(project.proj_address)}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Sector:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;">${escapeHTML(project.sector)}</div>
            </div>

            <div style="margin-bottom: 15px;">
                <label style="font-weight: bold; display: block; margin-bottom: 5px;">Status:</label>
                <div style="padding: 8px; background: #f5f5f5; border-radius: 4px;">${escapeHTML(project.status)}</div>
            </div>
        </div>
    `;
}


    function addMarker(project) {
    const lng = parseFloat(project.coordinate.longitude);
    const lat = parseFloat(project.coordinate.latitude);


    // Create a custom DOM element for the marker with the icon
    const el = document.createElement('div');
    el.className = 'custom-marker';


    const iconUrl = iconMap[project.sector] || '/images/markers/others.png';

   el.style.backgroundImage = `url(${iconUrl})`;
    el.style.width = '45px';
    el.style.height = '45px';
    el.style.backgroundSize = 'contain';
    el.style.backgroundRepeat = 'no-repeat';
    el.style.backgroundPosition = 'center';
    el.style.cursor = 'pointer';

    // Create the marker with this custom element
    const marker = new maplibregl.Marker(el).setLngLat([lng, lat]).addTo(map);

   // Create popup for hover
    let popupHTML = createPopupHTML(project);
    const popup = new maplibregl.Popup({ 
        offset: 25, 
        closeButton: false, 
        closeOnClick: false 
    }).setHTML(popupHTML);

  // Hover events
    el.addEventListener('mouseenter', () => {
        popup.setLngLat([lng, lat]).addTo(map);
    });
    
    el.addEventListener('mouseleave', () => {
        popup.remove();
    });

    // Click event for detailed view
    el.addEventListener('click', (e) => {
        e.stopPropagation();
        
        // Remove hover popup when clicking
        popup.remove();
        
        // Show detailed modal
        Swal.fire({
            title: project.proj_name,
            html: createDetailedHTML(project),
            width: '600px',
            showConfirmButton: false,
            showCloseButton: true,
            customClass: {
                container: 'project-modal'
            },
            didOpen: () => {
                // Add action buttons
                const actionButtons = document.createElement('div');
                actionButtons.style.cssText = 'margin-top: 20px; text-align: center; border-top: 1px solid #eee; padding-top: 20px;';
                actionButtons.innerHTML = `
                    <button id="zoomInBtn" class="swal2-styled" style="margin-right:10px; background-color: #4CAF50;">
                        Zoom In
                    </button>
                    <button id="editBtn" class="swal2-styled" style="margin-right:10px; background-color:#3085d6;">
                        Edit
                    </button>
                    <button id="deleteBtn" class="swal2-styled" style="background-color:#d33;">
                        Delete
                    </button>
                `;
                
                // Append buttons to the modal content
                const modalContent = Swal.getHtmlContainer();
                modalContent.appendChild(actionButtons);
                
                // Add event listeners
                document.getElementById('zoomInBtn').addEventListener('click', () => {
                    map.flyTo({
                        center: [lng, lat],
                        zoom: 15,
                        essential: true
                    });
                    Swal.close();
                });

                document.getElementById('editBtn').addEventListener('click', () => {
                    Swal.close();
                    openEditOverlay({
                        id: project.proj_id,
                        name: project.proj_name,
                        organization: project.org_name,
                        type: project.proj_type,
                        description: project.proj_desc,
                        municipality: project.proj_municipality,
                        address: project.proj_address,
                        sector: project.sector,
                        status: project.status,
                        latitude: project.coordinate.latitude,
                        longitude: project.coordinate.longitude
                    });
                });

                document.getElementById('deleteBtn').addEventListener('click', () => {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'This will delete the project permanently.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'Cancel'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            fetch(`/projects/${project.proj_id}`, {
                                method: 'DELETE',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => {
                                if (!response.ok) throw new Error('Failed to delete project');
                                return response.json();
                            })
                            .then(() => {
                                Swal.fire('Deleted!', 'Project has been deleted.', 'success');
                                marker.remove();
                                delete markers[project.proj_id];
                                    // Refresh accordion
                                    populateMunicipalityAccordion();
                            })
                            .catch(() => {
                                Swal.fire('Error!', 'Failed to delete project.', 'error');
                            });
                        }
                    });
                });
            }
        });
    });

    markers[project.proj_id] = { marker, popup, project };
}

    // Load existing projects
fetch('/projects')
  .then(response => response.json())
  .then(response => {
      const projects = response.data; // ✅ extract .data
      projects.forEach(project => {
          if (project.coordinate && project.coordinate.latitude && project.coordinate.longitude) {
              addMarker(project);
          }
      });

        })
        .catch(err => console.error('Error loading projects:', err));

        map.on('click', (e) => {
    const lat = e.lngLat.lat.toFixed(8);
    const lng = e.lngLat.lng.toFixed(8);

    openOverlay(lat, lng);
});


function submitProject() {
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const project = {
        proj_name: document.getElementById('project_name').value,
        org_name: document.getElementById('organization').value,
        proj_type: document.getElementById('type').value,
        proj_desc: document.getElementById('description').value,
        proj_municipality: document.getElementById('municipality').value,
        proj_address: document.getElementById('address').value,
        sector: document.getElementById('sector').value,
        status: document.getElementById('status').value,
        latitude: document.getElementById('latitude').value,
        longitude: document.getElementById('longitude').value,
    };

    fetch('/projects', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify(project)
    })
    .then(response => response.json())
    .then(data => {
      closeOverlay();
        Swal.fire('Success!', 'Project created successfully.', 'success');

        // ✅ Add new marker to map
        if (data.coordinate && data.coordinate.latitude && data.coordinate.longitude) {
            addMarker(data);
        }

        // ✅ Refresh the accordion list
        populateMunicipalityAccordion();
    })
.catch(async error => {
    let errorMsg = 'Failed to create project.';

    if (error.response && error.response.json) {
        const errData = await error.response.json();
        errorMsg = errData.message || errorMsg;
    }

    console.error(error);
    Swal.fire('Error!', errorMsg, 'error');
});
}



    function openEditOverlay(project) {

  document.getElementById('proj_overlay_edit').style.display = 'flex';
  document.getElementById('overlay-title').innerText = 'Edit Project';

  document.getElementById('edit_project_id').value = project.id;
  document.getElementById('edit_project_name').value = project.name;
  document.getElementById('edit_organization').value = project.organization;
  document.getElementById('edit_type').value = project.type;
  document.getElementById('edit_description').value = project.description;
  document.getElementById('edit_municipality').value = project.municipality;
  document.getElementById('edit_address').value = project.address;
  document.getElementById('edit_sector').value = project.sector;
  document.getElementById('edit_status').value = project.status;
  document.getElementById('edit_latitude').value = project.latitude;
  document.getElementById('edit_longitude').value = project.longitude;
}


function updateProject() {
  const projId = document.getElementById('edit_project_id').value;

  const updatedProject = {
    proj_name: document.getElementById('edit_project_name').value,
    org_name: document.getElementById('edit_organization').value,
    proj_type: document.getElementById('edit_type').value,
    proj_desc: document.getElementById('edit_description').value,
    proj_municipality: document.getElementById('edit_municipality').value,
    proj_address: document.getElementById('edit_address').value,
    sector: document.getElementById('edit_sector').value,
    status: document.getElementById('edit_status').value,
  };

    fetch(`/projects/${projId}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(updatedProject)
    })
    .then(response => {
        if (!response.ok) throw new Error('Network response was not ok');
        return response.json();
    })
    .then(data => {
        Swal.fire('Updated!', 'Project updated successfully.', 'success');
        document.getElementById('proj_overlay_edit').style.display = 'none';

        if (markers[projId]) {
            // Get old coordinates from existing marker
            const oldLng = markers[projId].marker.getLngLat().lng;
            const oldLat = markers[projId].marker.getLngLat().lat;

            markers[projId].marker.remove();
            delete markers[projId];

            // Pass updated project data along with coordinate object
            addMarker({
                ...data,
                coordinate: {
                    longitude: oldLng,
                    latitude: oldLat
                }
            });
        } else {
            // No old marker? Just add marker, but ensure coordinates exist
            if (!data.coordinate) {
                console.error('No coordinates in project data!');
                return;
            }
            addMarker(data);
        }
            // Refresh accordion
            populateMunicipalityAccordion();
    })
    .catch(error => {
        console.error(error);
        Swal.fire('Error!', 'Failed to update project.', 'error');
    });
}

fetch('/static-points')
  .then(res => res.json())
  .then(points => {
      points.forEach(p => {
          addStaticMarker(p.latitude, p.longitude, p.name);
      });
  })
  .catch(err => {
      console.error('Error loading static markers:', err);
  });


function addStaticMarker(lat, lng, name = 'PSTO-Kalinga', description = 'Provincial Science and Technology Office - Kalinga') {
    const el = document.createElement('div');
    el.className = 'custom-static-marker';

    // Marker styling
    el.style.backgroundImage = 'url(/images/DOST_kalinga_logo.png)';
    el.style.width = '50px';
    el.style.height = '50px';
    el.style.backgroundSize = 'contain';
    el.style.backgroundRepeat = 'no-repeat';
    el.style.backgroundPosition = 'center';
    el.style.cursor = 'pointer';

    // Create maplibre marker
    const marker = new maplibregl.Marker(el)
        .setLngLat([lng, lat])
        .addTo(map);

    // Optional popup on hover or click
    const popup = new maplibregl.Popup({
        offset: 25,
        closeButton: false,
        closeOnClick: false
}).setHTML(`
    <div style="padding: 10px; min-width: 200px;">
        <h3 style="margin: 0 0 5px 0; font-size: 16px;"><strong>${name}</strong></h3>
        <p style="margin: 5px 0;"> ${description}</p>
    </div>
`);
    el.addEventListener('mouseenter', () => popup.setLngLat([lng, lat]).addTo(map));
    el.addEventListener('mouseleave', () => popup.remove());
}

function createStaticPopupHTML(staticPoint) {
    function escapeHTML(str) {
        return String(str).replace(/[&<>"']/g, s =>
            ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[s]);
    }

    return `
        <div class="popup-content" style="padding: 10px; min-width: 200px;">
            <h3 style="margin: 0 0 10px 0; font-size: 16px;">${escapeHTML(staticPoint.name)}</h3>
            <p style="margin: 5px 0;"><strong>Description:</strong> ${escapeHTML(staticPoint.description)}</p>
        </div>
    `;
}

</script>

@include('layouts.footer')

</body>
@include('components.chatbot') 