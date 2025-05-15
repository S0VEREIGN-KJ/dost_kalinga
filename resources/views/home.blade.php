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

        function addMarker(project) {
    const lng = parseFloat(project.coordinate.longitude);
    const lat = parseFloat(project.coordinate.latitude);

    const marker = new maplibregl.Marker().setLngLat([lng, lat]).addTo(map);

    const popupHTML = `
        <h3>${project.proj_name}</h3>
        <p>${project.proj_desc}</p>
        <p><strong>Organization:</strong> ${project.org_name}</p>
        <p><strong>Type:</strong> ${project.proj_type}</p>
        <p><strong>Address:</strong> ${project.proj_address}</p>
        <p><strong>Sector:</strong> ${project.sector}</p>
        <p><strong>Status:</strong> ${project.status}</p>
    `;

    const popup = new maplibregl.Popup({ offset: 25, closeButton: false, closeOnClick: false }).setHTML(popupHTML);
    const markerEl = marker.getElement();

    markerEl.addEventListener('mouseenter', () => popup.setLngLat([lng, lat]).addTo(map));
    markerEl.addEventListener('mouseleave', () => popup.remove());

    markerEl.addEventListener('click', (e) => {
        e.stopPropagation();  // <-- Prevent map click
        Swal.fire({
            title: project.proj_name,
            html: popupHTML,
            icon: 'info',
            confirmButtonText: 'Close'
        });
    });
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
        <input id="proj_name" class="swal2-input" placeholder="Project Name">
        <textarea id="proj_desc" class="swal2-textarea" placeholder="Project Description"></textarea>
        <input id="org_name" class="swal2-input" placeholder="Organization Name">
        <input id="proj_type" class="swal2-input" placeholder="Project Type">
        <input id="proj_address" class="swal2-input" placeholder="Project Address">
        <input id="sector" class="swal2-input" placeholder="Sector">
        <input id="status" class="swal2-input" placeholder="Status">
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
        const data = result.value; // ✅ Ensure this is inside this block

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
    console.log('New project:', newProject); // <-- Add this to inspect the data
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
