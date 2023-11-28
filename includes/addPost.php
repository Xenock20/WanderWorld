<button class="open-modal" id="openModalBtn">Agregar Post</button>

<div class="modal" id="postModal">
    <div class="modal-content">
        <h2>Agregar un nuevo post</h2>
        <form action="../conexiones/addPost.php" method="post">
            <label for="postContent">Contenido del post:</label>
            <textarea id="postContent" name="postContent" rows="4" cols="50"></textarea>
            <div id="map" style="height: 300px;"></div>

            <input type="hidden" name="latitud" id="latitud">
            <input type="hidden" name="longitud" id="longitud">
<div class="box-publicar">
            <button type="submit" name="addPost">Publicar</button>
        </form>
        <button class="close-button" id="closeModalBtn">Cerrar</button>
</div>

    </div>

</div>



<script>
    // JavaScript para abrir y cerrar el modal
    const openModalBtn = document.getElementById("openModalBtn");
    const postModal = document.getElementById("postModal");
    const closeModalBtn = document.getElementById("closeModalBtn");

    openModalBtn.addEventListener("click", () => {
        postModal.style.display = "flex";
    });

    closeModalBtn.addEventListener("click", () => {
        postModal.style.display = "none";
    });

    // Cierra el modal si se hace clic fuera de él
    window.addEventListener("click", (event) => {
        if (event.target === postModal) {
            postModal.style.display = "none";
        }
    });
</script>

<script async src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCty89p6SNmmaLQbYCIoqNcFkXvrWxvUVQ&callback=initMaps" defer></script>
<script>
    const mapConfigs = [];
    let markerPost;

    function addMap(id, lat, log) {
        mapConfigs.push({
            id,
            lat,
            log
        })
    }

    // Función que se llama después de cargar la API de Google Maps
    function initMaps() {

        let map = new google.maps.Map(document.getElementById('map'), {
            zoom: 8,
            center: {
                lat: -34.397,
                lng: 150.644
            },
            streetViewControl: false, // Oculta el muñeco de Street View
            mapTypeControl: false // Oculta las opciones de cambio de tipo de mapa
        });

        map.addListener('click', function(event) {
            if (markerPost) {
                markerPost.setMap(null); // Eliminar el marcador anterior si existe
            }

            markerPost = new google.maps.Marker({
                position: event.latLng,
                map: map
            });

            document.getElementById('latitud').value = event.latLng.lat();
            document.getElementById('longitud').value = event.latLng.lng();
        });

        // Inicializa cada mapa en el array
        for (var i = 0; i < mapConfigs.length; i++) {
            var config = mapConfigs[i];
            initMap(config.id, config.lat, config.log);
        }
    }

    // Función para inicializar un mapa
    function initMap(mapId, latitud, longitud) {
        console.log(mapId);
        var map = new google.maps.Map(document.getElementById(mapId), {
            center: {
                lat: latitud,
                lng: longitud,
                streetViewControl: false, // Oculta el muñeco de Street View
                mapTypeControl: false // Oculta las opciones de cambio de tipo de mapa
            },
            zoom: 10
        });

        // Añade un marcador en la ubicación proporcionada
        var marker = new google.maps.Marker({
            position: {
                lat: latitud,
                lng: longitud
            },
            map: map
        });
    }

    /*
    function initMap() {
        
    }

    initMap();
    */
</script>