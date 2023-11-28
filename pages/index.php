<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../assets/css/styles.css">
    <title>Document</title>
</head>

<body>
    <?php
    require_once "../conexiones/cn.php";
    include './../includes/header.php';
    ?>

    <div class="content-wrapper">
        <div class="cont-feed">
            <?php include './../includes/addPost.php'; ?>
            <?php include './../includes/map.php'; ?>
            <?php include './../includes/post.php'; ?>
            <?php obtenerPublicaciones($id_user, $conn, $id_user); ?>
        </div>
        <?php
        // Conexión a la base de datos (asegúrate de tener una conexión establecida)

        // Realiza una consulta SQL para obtener usuarios sugeridos
        $resultFollow = $conn->query("SELECT * FROM t_usuarios WHERE id_usuario != $id_user AND id_usuario NOT IN (SELECT id_usuario_seguido FROM t_followings WHERE id_usuario_seguidor = $id_user) LIMIT 8");

        echo '<div class="suggested-container">';
        echo '<h2>Sugerencias</h2>';
        if ($resultFollow->num_rows > 0) {
            while ($rowFollow = $resultFollow->fetch_assoc()) {

                $usuario_id_follow = $rowFollow["id_usuario"];
                $nombre_follow = $rowFollow["usuario"];

                $perfil_query_follow = $conn->query("SELECT * FROM t_perfil WHERE id_usuario = $usuario_id_follow");

                $perfil_follow = $perfil_query_follow->fetch_assoc();

                $id_foto_follow = $perfil_follow["id_foto"];

                $imagen_query_follow = $conn->query("SELECT imagen, tipo_mime FROM t_fotos WHERE id_foto = $id_foto_follow");
                $imagen_follow = $imagen_query_follow->fetch_assoc();
                $imagenBase64_follow = $imagen_follow["imagen"];
                $tipo_mime_follow = $imagen_follow["tipo_mime"];

                // Construye la URL de la imagen y asigna a $_SESSION["img"]
                $img_src_follow = "data:$tipo_mime_follow;base64,$imagenBase64_follow";


                echo '<form class="suggested-person" action="../conexiones/follow.php" method="post">';
                echo '<img src="' . $img_src_follow . '" alt="' . $nombre_follow . '">';
                echo '<div class="suggested-info">';
                echo '<a href="profile.php?id=' . $usuario_id_follow . '">' . $nombre_follow . '</a>';
                echo '</div>';
                echo '<input type="hidden" name="id_user_follow_you" value="' . $usuario_id_follow . '">';
                echo '<input type="hidden" name="id_user_follow_my" value="' . $id_user . '">';
                echo '<button class="follow-button" data-usuario-id="' . $usuario_id_follow . '">Seguir</button>';
                echo '</form>';
            }
        } else {
            echo '<div class="suggested-person">';
            echo "No se encontraron usuarios sugeridos.";
            echo '</div>';
        }
        echo '</div>';


        // Cierra la conexión a la base de datos
        $conn->close();
        ?>

    </div>
</body>

</html>