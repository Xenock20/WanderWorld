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
    $id_user_perfil = isset($_GET['id']) ? $_GET['id'] : null;
    include './../includes/header.php';
    require_once "../conexiones/cn.php";
    //include './../includes/sesion.php';
    //include './../includes/imgdesco.php';

    if ($id_user == $id_user_perfil) {
        echo '<div class="profile">
        <div class="profile-principal">
            <div class="profile-info">
                <img src="' . $img . '" alt="Nombre de Usuario">
                <h1>' . $user_profile . '</h1>
                <p>' . $info . '</p>
                <button id="editProfileBtn">Editar perfil</button>
            </div>
    
            <div id="editProfileModal" class="modal">
                <div class="modal-content">
                    <h2>Editar perfil</h2>
                    <form action="../includes/desc.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="newUsername">Nuevo nombre de usuario:</label>
                            <input type="text" name="newUsername" id="newUsername" placeholder="Nuevo nombre de usuario">
                        </div>
    
                        <div class="form-group">
                            <label for="newUserInfo">Nueva información adicional:</label>
                            <textarea name="newUserInfo" id="newUserInfo" placeholder="Nueva información adicional"></textarea>
                        </div>
    
                        <div class="form-group">
                            <label for="newProfileImage">Subir nueva foto de perfil:</label>
                            <input type="file" name="newProfileImage" id="newProfileImage">
                        </div>
    
                        <button type="submit" id="saveChangesBtn">Guardar cambios</button>
                    </form>
    
                    <button class="close-button" id="closeEditProfileModalBtn">Cerrar</button>
                </div>
            </div>';

        require_once "./../conexiones/cn.php";

        echo '<div class="profile-followers">
        <div class="followers">
            <h2>Seguidores</h2>
            <ul>';

        // Consulta SQL para obtener los seguidores
        $followersQuery = $conn->query("SELECT u.usuario, p.id_foto, u.id_usuario FROM t_followings f
        JOIN t_usuarios u ON f.id_usuario_seguidor = u.id_usuario
        LEFT JOIN t_perfil p ON u.id_usuario = p.id_usuario
        WHERE f.id_usuario_seguido = $id_user");

        while ($follower = $followersQuery->fetch_assoc()) {
            $followerName = $follower['usuario'];
            $followerName_id = $follower['id_usuario'];
            $followerAvatar = $follower['id_foto'];

            $imagen_av_query = $conn->query("SELECT imagen, tipo_mime FROM t_fotos WHERE id_foto = $followerAvatar");

            $imagen_av = $imagen_av_query->fetch_assoc();
            $imagenBase64_av = $imagen_av["imagen"];
            $tipo_mime_av = $imagen_av["tipo_mime"];

            $img_src_av = "data:$tipo_mime_av;base64,$imagenBase64_av";

            echo '<li><img src="' . $img_src_av . '" alt="' . $followerAvatar . '"><a href="profile.php?id=' . $followerName_id . '">' . $followerName . '</a></li>';
        }

        echo '</ul>
        </div>
    
        <div class="following">
            <h2>Siguiendo</h2>
            <ul>';

        // Consulta SQL para obtener a quiénes sigues
        $followingQuery = $conn->query("SELECT u.usuario, p.id_foto, u.id_usuario FROM t_followings f
        JOIN t_usuarios u ON f.id_usuario_seguido = u.id_usuario
        LEFT JOIN t_perfil p ON u.id_usuario = p.id_usuario
        WHERE f.id_usuario_seguidor = $id_user");

        while ($following = $followingQuery->fetch_assoc()) {
            $followingName = $following['usuario'];
            $followingName_id = $following['id_usuario'];
            $followingAvatar = $following['id_foto'];

            $imagen_av_query = $conn->query("SELECT imagen, tipo_mime FROM t_fotos WHERE id_foto = $followingAvatar");

            $imagen_av = $imagen_av_query->fetch_assoc();
            $imagenBase64_av = $imagen_av["imagen"];
            $tipo_mime_av = $imagen_av["tipo_mime"];

            $img_src_av = "data:$tipo_mime_av;base64,$imagenBase64_av";

            echo '<li><img src="' . $img_src_av . '" alt="' . $followingAvatar . '"><a href="profile.php?id=' . $followingName_id . '">' . $followingName . '</a></li>';
        }

        echo '</ul>
        </div>
    </div>
    </div>
    
    <div class="profile-posts">';
        include './../includes/addPost.php';
        include './../includes/post.php';
        obtenerPublicaciones($id_user_perfil, $conn, $id_user);
        echo '</div>
    </div>';
        echo '<script>
    // Obtener elementos del DOM
    const editProfileBtn = document.getElementById("editProfileBtn");
    const editProfileModal = document.getElementById("editProfileModal");
    const closeEditProfileModalBtn = document.getElementById("closeEditProfileModalBtn");

    // Mostrar el modal al hacer clic en "Editar perfil"
    editProfileBtn.addEventListener("click", function() {
        editProfileModal.style.display = "block";
    });

    // Cerrar el modal al hacer clic en el botón de cerrar
    closeEditProfileModalBtn.addEventListener("click", function() {
        editProfileModal.style.display = "none";
    });
</script>';
    } else {
        // Código para el perfil de otro usuario

        $perfil_query_p = $conn->query("SELECT * FROM t_perfil WHERE id_usuario = $id_user_perfil");
        if ($perfil_query_p->num_rows == 1) {
            $perfil = $perfil_query_p->fetch_assoc();
            $name_profile_secun = $perfil["nombre_completo"];
            $info_profile_secun = $perfil["info"];
            $id_profile_secun = $perfil["id_perfil"];

            // Obtiene la imagen de la base de datos
            $id_foto_secun = $perfil["id_foto"];
            $imagen_query_secun = $conn->query("SELECT imagen, tipo_mime FROM t_fotos WHERE id_foto = $id_foto_secun");
            if ($imagen_query_secun->num_rows == 1) {
                $imagen_secun = $imagen_query_secun->fetch_assoc();
                $imagenBase64_secun = $imagen_secun["imagen"];
                $tipo_mime_secun = $imagen_secun["tipo_mime"];

                // Construye la URL de la imagen y asigna a $_SESSION["img"]
                $img_src_secun = "data:$tipo_mime_secun;base64,$imagenBase64_secun";
            }
        }

        $query_verificar_seguimiento = "SELECT COUNT(*) as sigue_usuario FROM t_followings WHERE id_usuario_seguidor = '$id_user' AND id_usuario_seguido = '$id_user_perfil'";
        $result_verificar_seguimiento = $conn->query($query_verificar_seguimiento);
        $sigue_usuario = ($result_verificar_seguimiento->fetch_assoc()["sigue_usuario"] == 1);

        echo '<div class="profile">
    <div class="profile-principal">
        <div class="profile-info">
            <img src="' . $img_src_secun . '" alt="Nombre de Usuario">
            <h1>' . $name_profile_secun . '</h1>
            <p>' . $info_profile_secun . '</p>
            <form action="../conexiones/follow.php" method="post">
                <input type="hidden" name="id_user_follow_you" value="' . $id_user_perfil . '">
                <input type="hidden" name="id_user_follow_my" value="' . $id_user . '">';
        if ($sigue_usuario) {
            echo '<button class="unfollow-button unfollow" style="background-color:red;" name="unfollow" id="' . $id_user_perfil . '">Dejar de seguir</button>';
        } else {
            echo '<button class="follow-button" name="follow" id="' . $id_user_perfil . '">Seguir</button>';
        }
        echo '
            </form>
        </div>';

        require_once "./../conexiones/cn.php";

        echo '<div class="profile-followers">
    <div class="followers">
        <h2>Seguidores</h2>
        <ul>';

        // Consulta SQL para obtener los seguidores
        $followersQuery = $conn->query("SELECT u.usuario, p.id_foto, u.id_usuario FROM t_followings f
    JOIN t_usuarios u ON f.id_usuario_seguidor = u.id_usuario
    LEFT JOIN t_perfil p ON u.id_usuario = p.id_usuario
    WHERE f.id_usuario_seguido = $id_user_perfil");

        while ($follower = $followersQuery->fetch_assoc()) {
            $followerName = $follower['usuario'];
            $followerName_id = $follower['id_usuario'];
            $followerAvatar = $follower['id_foto'];

            $imagen_av_query = $conn->query("SELECT imagen, tipo_mime FROM t_fotos WHERE id_foto = $followerAvatar");

            $imagen_av = $imagen_av_query->fetch_assoc();
            $imagenBase64_av = $imagen_av["imagen"];
            $tipo_mime_av = $imagen_av["tipo_mime"];

            $img_src_av = "data:$tipo_mime_av;base64,$imagenBase64_av";

            echo '<li><img src="' . $img_src_av . '" alt="' . $followerAvatar . '"><a href="profile.php?id=' . $followerName_id .'">' . $followerName . '</a></li>';
        }

        echo '</ul>
    </div>

    <div class="following">
        <h2>Siguiendo</h2>
        <ul>';

        // Consulta SQL para obtener a quiénes sigues
        $followingQuery = $conn->query("SELECT u.usuario, p.id_foto, u.id_usuario FROM t_followings f
    JOIN t_usuarios u ON f.id_usuario_seguido = u.id_usuario
    LEFT JOIN t_perfil p ON u.id_usuario = p.id_usuario
    WHERE f.id_usuario_seguidor = $id_user_perfil");

        while ($following = $followingQuery->fetch_assoc()) {
            $followingName = $following['usuario'];
            $followingName_id = $following['id_usuario'];
            $followingAvatar = $following['id_foto'];

            $imagen_av_query = $conn->query("SELECT imagen, tipo_mime FROM t_fotos WHERE id_foto = $followingAvatar");

            $imagen_av = $imagen_av_query->fetch_assoc();
            $imagenBase64_av = $imagen_av["imagen"];
            $tipo_mime_av = $imagen_av["tipo_mime"];

            $img_src_av = "data:$tipo_mime_av;base64,$imagenBase64_av";

            echo '<li><img src="' . $img_src_av . '" alt="' . $followingAvatar . '"><a href="profile.php?id=' . $followingName_id . '">' . $followingName . '</a></li>';
        }

        echo '</ul>
        </div>
    </div>
    </div>
    
    <div class="profile-posts">';
        include './../includes/map.php';
        include './../includes/post.php';
        obtenerPublicaciones($id_user_perfil, $conn, $id_user);
        echo '</div>
    </div>';
    }
    ?>
</body>

</html>