<?php
session_start();

if (isset($_POST['addComent'])) {
    // Conecta a la base de datos (asegúrate de tener una conexión establecida)
    require_once "cn.php";

    $id_publicacion = $_POST["id_publicacion"];
    $id_perfil = $_SESSION["idperfil"];
    $contenido = $_POST["contenido"];

    // Inserta el comentario en la base de datos
    $sql = "INSERT INTO t_comentarios (id_publicacion, id_perfil, contenido, fecha_comentario) VALUES ('$id_publicacion', '$id_perfil', '$contenido', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../pages/index.php"); // Redirige a la página de publicaciones
    } else {
        echo "Error al publicar el comentario.";
    }

    $conn->close();
}
?>
