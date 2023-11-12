<?php
// Conecta a la base de datos (asegúrate de tener una conexión establecida)

function obtenerPublicaciones($id_user_perfil, $conn, $id_user_session)
{
    // Conecta a la base de datos (asegúrate de tener una conexión establecida

    $sql = "SELECT p.*
    FROM t_publicaciones p
    LEFT JOIN t_followings f ON p.id_usuario = f.id_usuario_seguido AND f.id_usuario_seguidor = $id_user_perfil
    WHERE p.id_usuario = $id_user_perfil OR f.id_usuario_seguidor = $id_user_perfil
    ORDER BY p.fecha_publicacion DESC";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $usuario_id = $row["id_usuario"];
            $user_query = $conn->query("SELECT * FROM t_usuarios WHERE id_usuario = $usuario_id");
            $perfil_query = $conn->query("SELECT * FROM t_perfil WHERE id_usuario = $usuario_id");

            $perfil = $perfil_query->fetch_assoc();
            $usuario = $user_query->fetch_assoc();

            $id_foto = $perfil["id_foto"];
            $imagen_query = $conn->query("SELECT imagen, tipo_mime FROM t_fotos WHERE id_foto = $id_foto");
            $imagen = $imagen_query->fetch_assoc();
            $imagenBase64 = $imagen["imagen"];
            $tipo_mime = $imagen["tipo_mime"];

            // Construye la URL de la imagen y asigna a $_SESSION["img"]
            $img_src = "data:$tipo_mime;base64,$imagenBase64";
            $usuario_name = $usuario["usuario"];
            $contenido = $row["contenido"];
            $id_post = $row['id_publicacion'];

            $sql = "SELECT * FROM t_comentarios WHERE id_publicacion = $id_post ORDER BY fecha_comentario ASC";

            $resultComent = $conn->query($sql);

            $sql = "SELECT COUNT(id_comentario) AS total_comentarios FROM t_comentarios WHERE id_publicacion = $id_post";

            $resultComentCount = $conn->query($sql);

            $rowComentCount = $resultComentCount->fetch_assoc();
            $total_comentarios = $rowComentCount["total_comentarios"];

            $sql = "SELECT COUNT(*) AS like_count FROM t_likes WHERE id_publicacion = $id_post";
            $resultLikes = $conn->query($sql);

            $rowLikes = $resultLikes->fetch_assoc();
            $like_count = $rowLikes["like_count"];

            // Verificar si la publicación tiene una ubicación asociada
            $tiene_mapa = false;  // Asume que la publicación no tiene un mapa por defecto

            // Realizar una consulta para verificar si hay una ubicación asociada
            $mapa_query = $conn->query("SELECT latitud, longitud FROM t_mapas WHERE id_publicacion = $id_post");

            if ($mapa_query->num_rows > 0) {
                $tiene_mapa = true;
                $mapa_datos = $mapa_query->fetch_assoc();
                $latitud = $mapa_datos["latitud"];
                $longitud = $mapa_datos["longitud"];
            }

            // Ahora puedes generar los contenedores de publicaciones con los datos
            echo '<div class="post">';
            echo '<div class="user-info">';
            echo '<div class="user-info-primary">';
            echo '<img src="' . $img_src . '" alt="' . $usuario_name . '">';
            echo '<a href="profile.php?id=' . $usuario_id . '">' . $usuario_name . '</a>';
            echo '</div>';
            if ($id_user_session == $usuario_id) {
                echo '<form action="../conexiones/eliminarPublicacion.php" method="POST" class="delete-section">';
                echo '<input type="hidden" name="id_publicacion" value="' . $id_post . '">';
                echo '<button type="submit" name="deletePost">Eliminar Publicación</button>';
                echo '</form>';
            }
            echo '</div>';
            echo '<p class="post-content">' . $contenido . '</p>';
            if ($tiene_mapa) {
                echo '<div class="map-container">';
                echo '<div id="map-' . $id_post . '" class="post-map" style="height: 300px; z-index: 1;"></div>';
                echo '</div>';
                echo '<script>';
                echo 'addMap("map-' . $id_post . '", ' . $latitud . ', ' . $longitud . ');';
                echo '</script>';
            }
            echo '<div class="actions">';
            echo '<form class="like" id="likeForm" action="../conexiones/addLike.php" method="POST">';
            echo '<input type="hidden" name="id_publicacion" value="' . $id_post . '">';
            echo '<button type="submit" id="likeButton" style="background: none; border: none; cursor: pointer;">';
            echo '<i class="fas fa-heart"></i>';
            echo '</button>';
            echo '<span id="likeCount">' . $like_count . ' Likes</span>';
            echo '</form>';
            echo '<div class="comments">';
            echo '<i class="fas fa-comment"></i> <span>' . $total_comentarios . ' Comentarios</span>';
            echo '</div>';
            echo '</div>';
            echo '<form action="../conexiones/addComent.php" method="post" class="comment-section">';
            echo '<input type="hidden" name="id_publicacion" value="' . $id_post . '">';
            echo '<input type="text" name="contenido" placeholder="Añadir un comentario...">';
            echo '<button type="submit" name="addComent">Publicar</button>';
            echo '</form>';
            echo '<div class="comments">';
            if ($resultComent->num_rows > 0) {
                while ($rowComent = $resultComent->fetch_assoc()) {
                    // Recoge datos de cada comentario
                    $id_perfil_coment = $rowComent["id_perfil"]; // Puedes obtener el nombre del comentarista desde tu base de datos
                    $contenido = $rowComent["contenido"];

                    $perfil_coment_query = $conn->query("SELECT * FROM t_perfil WHERE id_perfil = $id_perfil_coment");

                    $perfil_coment = $perfil_coment_query->fetch_assoc();

                    $id_foto_coment = $perfil_coment["id_foto"];
                    $id_usuario_coment = $perfil_coment["id_usuario"];

                    $user_coment_query = $conn->query("SELECT * FROM t_usuarios WHERE id_usuario = $id_usuario_coment");
                    $user_coment = $user_coment_query->fetch_assoc();
                    $user_coment_name = $user_coment["usuario"];

                    $imagen_coment_query = $conn->query("SELECT imagen, tipo_mime FROM t_fotos WHERE id_foto = $id_foto_coment");

                    $imagen_coment = $imagen_coment_query->fetch_assoc();
                    $imagenBase64_coment = $imagen_coment["imagen"];
                    $tipo_mime_coment = $imagen_coment["tipo_mime"];

                    $img_src_coment = "data:$tipo_mime_coment;base64,$imagenBase64_coment";


                    // Muestra los comentarios en el formato HTML deseado
                    echo '<div class="comment">';
                    echo '<div class="coment-cont">';
                    echo '<div class="coment-cont-info">';
                    echo '<img src="' . $img_src_coment . '" alt="' . $user_coment_name . '">';
                    echo '<a href="profile.php?id=' . $id_usuario_coment . '">' . $user_coment_name . ':  </a>';
                    echo '</div>';
                    echo '<div class="post-content-container">';
                    echo '<p class="post-content">' . $contenido . '</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '<div class="coment-opt">';
                    if ($id_usuario_coment == $id_user_session) {
                        echo '<form action="../conexiones/eliminarComentario.php" method="POST" class="delete-section">';
                        echo '<input type="hidden" name="id_comentario" value="' . $rowComent["id_comentario"] . '">';
                        echo '<button type="submit" class="btn-del-com" name="deleteComment">Eliminar Comentario</button>';
                        echo '</form>';
                    }
                    echo '</div>';
                    echo '</div>';
                }
            } else {
                echo "No se encontraron comentarios para esta publicación.";
            }
            echo '</div>';
            echo '</div>';
            //echo '<script> let map; function initMap(id, lt, lg) {let map = new google.maps.Map(document.getElementById("map"), {zoom: 8,center: {lat: ' . $latitud . ', lng: ' . $longitud . '}, streetViewControl: false, mapTypeControl: false}); </script>';
        }
    } else {
    }
}
