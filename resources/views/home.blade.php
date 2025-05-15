<!-- resources/views/welcome.blade.php -->
@include('layouts.header')

<body>
    <div id="map"></div>
    <script src="https://cdn.jsdelivr.net/npm/maplibre-gl@2.4.0/dist/maplibre-gl.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
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

        const marker = new maplibregl.Marker().setLngLat([lng, lat]).addTo(map);

        let popupHTML = createPopupHTML(project);

        const popup = new maplibregl.Popup({ offset: 25, closeButton: false, closeOnClick: false }).setHTML(popupHTML);
        const markerEl = marker.getElement();

        markerEl.addEventListener('mouseenter', () => popup.setLngLat([lng, lat]).addTo(map));
        markerEl.addEventListener('mouseleave', () => popup.remove());

        markerEl.addEventListener('click', (e) => {
            e.stopPropagation();  // Prevent map click
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
                   // Zoom In button click event
        document.getElementById('zoomInBtn').addEventListener('click', () => {
            map.flyTo({
                center: [parseFloat(project.coordinate.longitude), parseFloat(project.coordinate.latitude)],
                zoom: 15,  // adjust the zoom level as needed
                essential: true
            });
        });

        
                document.getElementById('editBtn').addEventListener('click', () => {
                    Swal.fire({
                        title: 'Edit Project',
                        html: `
                            <input id="proj_name" class="swal2-input" placeholder="Project Name" value="${project.proj_name}">
                            <textarea id="proj_desc" class="swal2-textarea" placeholder="Project Description">${project.proj_desc}</textarea>
                            <input id="org_name" class="swal2-input" placeholder="Organization Name" value="${project.org_name}">
                            <input id="proj_type" class="swal2-input" placeholder="Project Type" value="${project.proj_type}">
                            <input id="proj_address" class="swal2-input" placeholder="Project Address" value="${project.proj_address}">
                            <input id="sector" class="swal2-input" placeholder="Sector" value="${project.sector}">
                            <input id="status" class="swal2-input" placeholder="Status" value="${project.status}">
                        `,
                        confirmButtonText: 'Update',
                        showCancelButton: true,
                        preConfirm: () => {
                            return {
                                proj_name: document.getElementById('proj_name').value,
                                proj_desc: document.getElementById('proj_desc').value,
                                org_name: document.getElementById('org_name').value,
                                proj_type: document.getElementById('proj_type').value,
                                proj_address: document.getElementById('proj_address').value,
                                sector: document.getElementById('sector').value,
                                status: document.getElementById('status').value,
                                latitude: project.coordinate.latitude,
                                longitude: project.coordinate.longitude
                            };
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const updatedData = result.value;

                            fetch(`/projects/${project.proj_id}`, {
                                method: 'PUT',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body: JSON.stringify(updatedData)
                            })
                            .then(response => {
                                if (!response.ok) {
                                    throw new Error('Failed to update');
                                }
                                return response.json();
                            })
                            .then(data => {
                                Swal.fire('Updated!', 'Project updated successfully.', 'success');

                                // Update the local project object with new data
                                project.proj_name = data.proj_name;
                                project.proj_desc = data.proj_desc;
                                project.org_name = data.org_name;
                                project.proj_type = data.proj_type;
                                project.proj_address = data.proj_address;
                                project.sector = data.sector;
                                project.status = data.status;

                                // Update popup HTML
                                const updatedPopupHTML = createPopupHTML(project);

                                // Update popup content for the marker stored in markers dictionary
                                if (markers[project.proj_id]) {
                                    markers[project.proj_id].popup.setHTML(updatedPopupHTML);
                                }

                                // Optional: also update Swal content if still open
                                if (Swal.isVisible()) {
                                    Swal.update({
                                        html: `
                                            ${updatedPopupHTML}
                                            <br>
                                            <button id="editBtn" class="swal2-confirm swal2-styled" style="margin-right:10px;background-color:#3085d6;">
                                                Edit
                                            </button>
                                            <button id="deleteBtn" class="swal2-cancel swal2-styled" style="background-color:#d33;">
                                                Delete
                                            </button>
                                        `
                                    });

                                    // Reattach edit button listener inside updated Swal content
                                    setTimeout(() => {
                                        document.getElementById('editBtn').addEventListener('click', () => {
                                            // You can optionally re-open the edit modal here or close it
                                        });
                                    }, 100);
                                }
                            })
                            
                            .catch(error => {
                                console.error(error);
                                Swal.fire('Error!', 'Failed to update project.', 'error');
                            });
                        }
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
                if (!response.ok) {
                    throw new Error('Failed to delete project');
                }
                return response.json();
            })
            .then(data => {
                Swal.fire('Deleted!', 'Project has been deleted.', 'success');
                // Optionally remove the marker from the map here
                // For example: marker.remove();

                marker.remove(); // removes marker from map
                delete markers[project.proj_id]; // clean up markers object
            })
            .catch(error => {
                console.error(error);
                Swal.fire('Error!', 'Failed to delete project.', 'error');
            });
                    }
                });
            });
        }, 100); // end setTimeout
    });

        // Save references for future updates
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

    // Allow admin to add pins on click
    map.on('click', (e) => {
        const lat = e.lngLat.lat.toFixed(8);
        const lng = e.lngLat.lng.toFixed(8);

        Swal.fire({
            title: 'Add New Project',
            html: `
                    <div id="proj_overlay" class="proj_overlay">
            <div class="proj_overlay-content">

                <div class="proj_overlay-header">
                    <h2>Add New Project</h2>
                    <button class="close-x" onclick="Swal.close()">X</button>
                </div>

                <div class="proj_input-selection">

                    <label for="project_name">Project Name:</label>
                    <input type="text" id="project_name" class="swal2-input" placeholder="Enter Project Name">

                    <label for="organization">Organization:</label>
                    <input type="text" id="organization" class="swal2-input" placeholder="Enter Organization">

                    <label for="type">Type:</label>
                    <select id="type" class="swal2-select">
                        <option value="">-- Select Type --</option>
                        <option value="setup">Setup</option>
                        <option value="community_based">Community Based</option>
                        <option value="assisted">Assisted</option>
                    </select>

                    <label for="description">Description:</label>
                    <input type="text" id="description" class="swal2-input" placeholder="Enter Description" style="height: 80px;">

                    <label for="address">Address:</label>
                    <input type="text" id="address" class="swal2-input" placeholder="Enter Address">

                    <label for="sector">Sector:</label>
                    <select id="sector" class="swal2-select">
                        <option value="">-- Select Sector --</option>
                        <option value="food_processing">Food Processing</option>
                        <option value="furniture">Furniture</option>
                        <option value="handicrafts">Handicrafts</option>
                        <option value="metals_engineering">Metals & Engineering</option>
                        <option value="agriculture">Agriculture</option>
                        <option value="health">Health</option>
                        <option value="ict">ICT</option>
                        <option value="other_industry">Other Regional Industry</option>
                    </select>

                    <label for="status">Status:</label>
                    <select id="status" class="swal2-select">
                        <option value="">-- Select Status --</option>
                        <option value="completed">Completed</option>
                        <option value="on_going">On-going</option>
                        <option value="new">New</option>
                        <option value="graduated">Graduated</option>
                        <option value="withdrawn">Withdrawn</option>
                        <option value="terminated">Terminated</option>
                    </select>

                </div>

                <div class="proj_overlay-footer">
                    <button class="kra_save-btn" onclick="document.querySelector('.swal2-confirm').click()">Save</button>
                </div>
            </div>
        </div>
            `,
            confirmButtonText: 'Save',
            showCancelButton: true,
            preConfirm: () => {
                return {
                    proj_name: document.getElementById('proj_name').value,
                    proj_desc: document.getElementById('proj_desc').value,
                    org_name: document.getElementById('org_name').value,
                    proj_type: document.getElementById('proj_type').value,
                    proj_address: document.getElementById('proj_address').value,
                    sector: document.getElementById('sector').value,
                    status: document.getElementById('status').value,
                    latitude: lat,
                    longitude: lng
                };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                const data = result.value;

                fetch('/projects', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(data)
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(newProject => {
                    Swal.fire('Added!', 'Project has been added.', 'success');
                    addMarker({ 
                        coordinate: { latitude: newProject.coordinate.latitude, longitude: newProject.coordinate.longitude }, 
                        ...newProject 
                    });
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire('Error!', 'Failed to save project.', 'error');
                });
            }
        });
    });
</script>

</body>
