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
    include './../includes/header.php';
    //include './../includes/sesion.php';
    //include './../includes/imgdesco.php';
    ?>

    <div class="profile">
        <div class="profile-principal">
            <div class="profile-info">
                <img src="<?php echo $img ?>" alt="Nombre de Usuario">
                <h1><?php echo $user ?></h1>
                <p><?php echo $info ?></p>
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
            </div>

            <script>
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
            </script>

            <div class="profile-followers">
                <div class="followers">
                    <h2>Seguidores</h2>
                    <ul>
                        <?php
                        require_once "./../conexiones/cn.php";


                        // Consulta SQL para obtener los seguidores
                        $followersQuery = $conn->query("SELECT u.usuario, p.id_foto FROM t_followings f
                JOIN t_usuarios u ON f.id_usuario_seguidor = u.id_usuario
                LEFT JOIN t_perfil p ON u.id_usuario = p.id_usuario
                WHERE f.id_usuario_seguido = $id_user");

                        while ($follower = $followersQuery->fetch_assoc()) {
                            $followerName = $follower['usuario'];
                            $followerAvatar = $follower['id_foto'];

                            $imagen_av_query = $conn->query("SELECT imagen, tipo_mime FROM t_fotos WHERE id_foto = $followerAvatar");

                            $imagen_av = $imagen_av_query->fetch_assoc();
                            $imagenBase64_av = $imagen_av["imagen"];
                            $tipo_mime_av = $imagen_av["tipo_mime"];

                            $img_src_av = "data:$tipo_mime_av;base64,$imagenBase64_av";

                            echo "<li><img src=\"$img_src_av\" alt=\"$followerAvatar\"> $followerName</li>";
                        }
                        ?>
                    </ul>
                </div>

                <div class="following">
                    <h2>Siguiendo</h2>
                    <ul>
                        <?php
                        // Consulta SQL para obtener a quiénes sigues
                        $followingQuery = $conn->query("SELECT u.usuario, p.id_foto FROM t_followings f
                JOIN t_usuarios u ON f.id_usuario_seguido = u.id_usuario
                LEFT JOIN t_perfil p ON u.id_usuario = p.id_usuario
                WHERE f.id_usuario_seguidor = $id_user");

                        while ($following = $followingQuery->fetch_assoc()) {
                            $followingName = $following['usuario'];
                            $followingAvatar = $following['id_foto'];

                            $imagen_av_query = $conn->query("SELECT imagen, tipo_mime FROM t_fotos WHERE id_foto = $followingAvatar");

                            $imagen_av = $imagen_av_query->fetch_assoc();
                            $imagenBase64_av = $imagen_av["imagen"];
                            $tipo_mime_av = $imagen_av["tipo_mime"];

                            $img_src_av = "data:$tipo_mime_av;base64,$imagenBase64_av";

                            echo "<li><img src=\"$img_src_av\" alt=\"$followingAvatar\"> $followingName</li>";
                        }
                        ?>
                    </ul>
                </div>
            </div>

        </div>


        <div class="profile-posts">
            <?php include './../includes/addPost.php'; ?>
            <?php include './../includes/post.php'; ?>
        </div>
    </div>

</body>

</html>