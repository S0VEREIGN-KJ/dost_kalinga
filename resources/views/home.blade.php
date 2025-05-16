<!-- resources/views/welcome.blade.php -->
@include('layouts.header')

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
    <script src="https://cdn.jsdelivr.net/npm/maplibre-gl@2.4.0/dist/maplibre-gl.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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
        style: 'https://api.maptiler.com/maps/streets-v2/style.json?key=9tZsVgNprhadpHJdkGYm',
        center: [121.33, 17.45],
        zoom: 9.5,
        maxBounds: kalingaBounds
    });

    // Store markers and popups keyed by project ID for easy updates
    const markers = {};

    function createPopupHTML(project) {
        return `
            <h3>${project.proj_name}</h3>
            <p>${project.proj_desc}</p>
            <p><strong>Organization:</strong> ${project.org_name}</p>
            <p><strong>Type:</strong> ${project.proj_type}</p>
            <p><strong>Address:</strong> ${project.proj_address}</p>
            <p><strong>Sector:</strong> ${project.sector}</p>
            <p><strong>Status:</strong> ${project.status}</p>
        `;
    }

    function addMarker(project) {
    const lng = parseFloat(project.coordinate.longitude);
    const lat = parseFloat(project.coordinate.latitude);


    // Create a custom DOM element for the marker with the icon
    const el = document.createElement('div');
    el.className = 'custom-marker';


    const iconUrl = iconMap[project.sector] || '/images/markers/default.png';

    el.style.backgroundImage = `url(${iconUrl})`;
el.style.width = '45px';
el.style.height = '45px';
el.style.backgroundSize = 'contain';
el.style.backgroundRepeat = 'no-repeat';
el.style.backgroundPosition = 'center';

    // Create the marker with this custom element
    const marker = new maplibregl.Marker(el).setLngLat([lng, lat]).addTo(map);

    let popupHTML = createPopupHTML(project);
    const popup = new maplibregl.Popup({ offset: 25, closeButton: false, closeOnClick: false }).setHTML(popupHTML);

    el.addEventListener('mouseenter', () => popup.setLngLat([lng, lat]).addTo(map));
    el.addEventListener('mouseleave', () => popup.remove());

    el.addEventListener('click', (e) => {
        e.stopPropagation();
        Swal.fire({
            title: project.proj_name,
            html: `
                ${popupHTML}
                <br>
                <button id="zoomInBtn" class="swal2-styled" style="margin-right:10px; background-color: #4CAF50; float: left;">
                    Zoom In
                </button>
                <button id="editBtn" class="swal2-confirm swal2-styled" style="margin-right:10px;background-color:#3085d6;">
                    Edit
                </button>
                <button id="deleteBtn" class="swal2-cancel swal2-styled" style="background-color:#d33;">
                    Delete
                </button>
            `,
            showConfirmButton: false,
            showCloseButton: true
        });

        setTimeout(() => {
            document.getElementById('zoomInBtn').addEventListener('click', () => {
                map.flyTo({
                    center: [lng, lat],
                    zoom: 15,
                    essential: true
                });
            });

            document.getElementById('editBtn').addEventListener('click', () => {
                Swal.close();
                openEditOverlay({
                    id: project.proj_id,
                    name: project.proj_name,
                    organization: project.org_name,
                    type: project.proj_type,
                    description: project.proj_desc,
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
                        })
                        .catch(() => {
                            Swal.fire('Error!', 'Failed to delete project.', 'error');
                        });
                    }
                });
            });
        }, 100);
    });

    markers[project.proj_id] = { marker, popup, project };
}

    // Load existing projects
    fetch('/projects')
        .then(response => response.json())
        .then(projects => {
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
    const project = {
        proj_name: document.getElementById('project_name').value,
        org_name: document.getElementById('organization').value,
        proj_type: document.getElementById('type').value,
        proj_desc: document.getElementById('description').value,
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
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify(project)
    })
    .then(response => response.json())
    .then(data => {
        closeOverlay();
        Swal.fire('Success!', 'Project created successfully.', 'success');
        addMarker(data); // Add to map
    })
    .catch(error => {
        console.error(error);
        Swal.fire('Error!', 'Failed to create project.', 'error');
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
    // get old coordinates from existing marker (or project object)
    const oldLng = markers[projId].marker.getLngLat().lng;
    const oldLat = markers[projId].marker.getLngLat().lat;

    markers[projId].marker.remove();
    delete markers[projId];

    // Pass updated project data along with coordinate object:
    addMarker({
      ...data,
      coordinate: {
        longitude: oldLng,
        latitude: oldLat
      }
    });
  } else {
    // No old marker? Just add marker, but ensure coordinates exist:
    if (!data.coordinate) {
      console.error('No coordinates in project data!');
      return;
    }
    addMarker(data);
  }
})


.catch(error => {
  console.error(error);
  Swal.fire('Error!', 'Failed to update project.', 'error');
});


}


</script>

</body>
