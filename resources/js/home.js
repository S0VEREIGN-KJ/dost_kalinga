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
    
    const username = document.getElementById('username').value; // Fixed: removed extra space
    const password = document.getElementById('password').value;
    const errorDiv = document.getElementById('loginError');
    
    // Create FormData object
    const formData = new FormData();
    formData.append('username', username); // Fixed: removed extra space
    formData.append('password', password);
    formData.append('_token', document.querySelector('input[name="_token"]').value);
    
    // Send login request
    fetch('/admin/login', {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
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

// MAP FUNCTIONS
const overlay = document.querySelector('.proj_overlay');
const content = document.querySelector('.proj_overlay-content');

const iconMap = {
  'Food Processing': '/images/markers/food.png',
  'Furniture': '/images/markers/furniture.png',
  'Handicrafts': '/images/markers/handicrafts.png',
  'Metals and Engineering': '/images/markers/engineering.png',
  'Agriculture': '/images/markers/agriculture.png',
  'Health': '/images/markers/health.png',
  'ICT': '/images/markers/ict.png'
};


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