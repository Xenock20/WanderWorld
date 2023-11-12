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
                                if (<?php echo $id_user; ?> !== perfil.id_usuario) {
                                    var perfilHTML = '<div class="profile-card">' +
                                        '<img class="profile-img" src="' + perfil.img_src_b + '" alt="Foto de perfil">' +
                                        '<a href="profile.php?id='+ perfil.id_usuario +'" class="profile-name">' + perfil.nombre_completo + '</a>' +
                                        '<p class="profile-followers">' + perfil.num_seguidores + ' seguidores</p>' +
                                        '<form action="../conexiones/follow.php" method="post">' +
                                        '<input type="hidden" name="id_user_follow_you" value="' + perfil.id_usuario + '">' +
                                        '<input type="hidden" name="id_user_follow_my" value="' + <?php echo $id_user; ?> + '">';

                                    // Verificar si el usuario sigue al perfil
                                    if (perfil.sigue_usuario) {
                                        perfilHTML += '<button class="unfollow-button" name="unfollow" id="' + perfil.id_usuario + '">Dejar de seguir</button>';
                                    } else {
                                        perfilHTML += '<button class="follow-button" name="follow" id="' + perfil.id_usuario + '">Seguir</button>';
                                    }

                                    perfilHTML += '</form>' +
                                        '</div>';

                                    $('#resultados').append(perfilHTML);
                                }
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