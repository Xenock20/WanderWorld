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
            <button type="submit" name="addPost">Publicar</button>
        </form>
        <button class="close-button" id="closeModalBtn">Cerrar</button>
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

<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCty89p6SNmmaLQbYCIoqNcFkXvrWxvUVQ&callback=initMap" async defer></script>
<script>
    let map;
    let marker;

    function initMap() {
        let map = new google.maps.Map(document.getElementById('map'), {
        zoom: 8,
        center: {lat: -34.397, lng: 150.644},
        streetViewControl: false, // Oculta el muñeco de Street View
        mapTypeControl: false // Oculta las opciones de cambio de tipo de mapa
    });

    map.addListener('click', function(event) {
        if (marker) {
            marker.setMap(null); // Eliminar el marcador anterior si existe
        }

        marker = new google.maps.Marker({
            position: event.latLng,
            map: map
        });

        document.getElementById('latitud').value = event.latLng.lat();
        document.getElementById('longitud').value = event.latLng.lng();
    });
}

</script>