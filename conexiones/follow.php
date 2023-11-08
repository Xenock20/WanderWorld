<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén los valores enviados por el formulario
    $id_user_follow_you = $_POST['id_user_follow_you'];
    $id_user_follow_my = $_POST['id_user_follow_my'];

    // Realiza la conexión a la base de datos (asegúrate de tener una conexión establecida)
    require_once "cn.php";

    // Verifica si ya se sigue a ese usuario (puedes hacer una consulta SQL para comprobarlo)

    // Si no se sigue a ese usuario, agrega la relación de seguimiento a la tabla t_followings
    $sql = "INSERT INTO t_followings (id_usuario_seguidor, id_usuario_seguido, fecha_seguimiento) VALUES ('$id_user_follow_my', '$id_user_follow_you', NOW())";

    if ($conn->query($sql) === TRUE) {
        // Redirige a alguna página o muestra un mensaje de éxito
        header("Location: ../pages/index.php"); // Redirige a la página de publicaciones
    } else {
        // Muestra un mensaje de error en caso de que no se haya podido seguir al usuario
        echo "Error al seguir al usuario: " . $conn->error;
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
?>
