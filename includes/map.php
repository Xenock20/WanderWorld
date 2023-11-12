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
/*
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
        });*/

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