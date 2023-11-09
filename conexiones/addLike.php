<?php
session_start();

if (isset($_POST['id_publicacion'])) {
    // Verifica si el usuario ha iniciado sesión
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
        echo "Debes iniciar sesión para dar 'Me gusta'.";
        exit;
    }

    $id_publicacion = $_POST['id_publicacion'];
    $id_usuario = $_SESSION['iduser']; // Asegúrate de obtener el ID del usuario de la sesión

    // Realiza la inserción o eliminación del "Me gusta" en la tabla t_likes
    require_once "cn.php"; // Asegúrate de que la conexión a la base de datos esté incluida

    // Verifica si el usuario ya ha dado "Me gusta" a esta publicación
    $check_query = $conn->prepare("SELECT COUNT(*) as count FROM t_likes WHERE id_usuario = ? AND id_publicacion = ?");
    $check_query->bind_param('ii', $id_usuario, $id_publicacion);
    $check_query->execute();
    $check_result = $check_query->get_result();
    $check_data = $check_result->fetch_assoc();

    if ($check_data['count'] == 0) {
        // El usuario no ha dado "Me gusta" previamente, así que agrega el "Me gusta" a la tabla t_likes
        $insert_query = $conn->prepare("INSERT INTO t_likes (id_usuario, id_publicacion) VALUES (?, ?)");
        $insert_query->bind_param('ii', $id_usuario, $id_publicacion);

        if ($insert_query->execute()) {
            header("Location: ../pages/index.php"); // Redirige a la página de publicaciones
        } else {
            echo "Error al agregar 'Me gusta'.";
        }
    } else {
        // El usuario ya ha dado "Me gusta", así que elimina el "Me gusta" de la tabla t_likes
        $delete_query = $conn->prepare("DELETE FROM t_likes WHERE id_usuario = ? AND id_publicacion = ?");
        $delete_query->bind_param('ii', $id_usuario, $id_publicacion);

        if ($delete_query->execute()) {
            header("Location: ../pages/index.php"); // Redirige a la página de publicaciones
        } else {
            echo "Error al eliminar 'Me gusta'.";
        }
    }
//asdjasjd
    $conn->close();
} else {
    echo "No se proporcionó una ID de publicación válida.";
}
?>