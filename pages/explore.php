<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfiles</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="../assets/css/styles.css">
</head>

<body>
    <?php include './../includes/header.php'; ?>

    <div class="cont-explore">
        <h1 class="titulo-explore">Resultados de la búsqueda</h1>
        <div id="buscador">
            <!-- Campo de entrada para buscar -->
            <input type="text" id="term" placeholder="Buscar por nombre">
        </div>
        <!-- Contenedor para los resultados de la búsqueda -->
        <div id="resultados"></div>
    </div>


    <script>
        $(document).ready(function() {
            $('#term').on('input', function() {
                // Obtener el valor del campo de búsqueda
                var term = $(this).val();

                // Comprobar si el campo de búsqueda está vacío
                if (term === '') {
                    // Si está vacío, vaciar los resultados y salir de la función
                    $('#resultados').empty();
                    return;
                }

                // Si no está vacío, enviar una solicitud al servidor
                $.ajax({
                    url: 'buscador.php', // Ruta del archivo PHP que procesará la búsqueda
                    type: 'GET', // Método de la solicitud (GET en este caso)
                    data: {
                        term: term
                    }, // Datos a enviar (el término de búsqueda)
                    dataType: 'json', // Tipo de datos que se espera recibir (en este caso, JSON)
                    success: function(data) {
                        // Función a ejecutar si la solicitud es exitosa
                        $('#resultados').empty(); // Vaciar los resultados actuales

                        // Comprobar si se encontraron resultados
                        if (data.length > 0) {
                            // Si hay resultados, mostrar cada perfil encontrado
                            data.forEach(function(perfil) {
                                var perfilHTML = '<div class="profile-card">' +
                                    '<img class="profile-img" src="obtener_imagen.php?id_foto=' + perfil.id_foto + '" alt="Foto de perfil">' +
                                    '<h2 class="profile-name">' + perfil.nombre_completo + '</h2>' +
                                    '<p class="profile-followers">' + perfil.num_seguidores + ' seguidores</p>' +
                                    '<button class="follow-button" data-id="' + perfil.id_perfil + '">Seguir</button>' +
                                    '</div>';
                                $('#resultados').append(perfilHTML);
                            });
                        } else {
                            // Si no hay resultados, mostrar un mensaje indicando que no se encontraron
                            $('#resultados').html('<p>No se encontraron resultados</p>');
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>