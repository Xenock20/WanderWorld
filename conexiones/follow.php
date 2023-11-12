<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtén los valores enviados por el formulario
    $id_user_follow_you = $_POST['id_user_follow_you'];
    $id_user_follow_my = $_POST['id_user_follow_my'];

    // Realiza la conexión a la base de datos (asegúrate de tener una conexión establecida)
    require_once "cn.php";

    // Verifica si ya se sigue a ese usuario
    $verificar_sql = "SELECT * FROM t_followings WHERE id_usuario_seguidor = '$id_user_follow_my' AND id_usuario_seguido = '$id_user_follow_you'";

    $resultado = $conn->query($verificar_sql);

    if ($resultado->num_rows == 0) {
        // Si no se sigue a ese usuario y el botón es 'follow', agrega la relación de seguimiento a la tabla t_followings
        if (isset($_POST['follow'])) {
            $sql = "INSERT INTO t_followings (id_usuario_seguidor, id_usuario_seguido, fecha_seguimiento) VALUES ('$id_user_follow_my', '$id_user_follow_you', NOW())";

            if ($conn->query($sql) === TRUE) {
                // Redirige a alguna página o muestra un mensaje de éxito
                header("Location: ../pages/index.php"); // Redirige a la página de publicaciones
            } else {
                // Muestra un mensaje de error en caso de que no se haya podido seguir al usuario
                echo "Error al seguir al usuario: " . $conn->error;
            }
        }
    } else {
        // Si el botón es 'unfollow', elimina la relación de seguimiento de la tabla t_followings
        if (isset($_POST['unfollow'])) {
            $sql = "DELETE FROM t_followings WHERE id_usuario_seguidor = '$id_user_follow_my' AND id_usuario_seguido = '$id_user_follow_you'";

            if ($conn->query($sql) === TRUE) {
                // Redirige a alguna página o muestra un mensaje de éxito
                header("Location: ../pages/index.php"); // Redirige a la página de publicaciones
            } else {
                // Muestra un mensaje de error en caso de que no se haya podido dejar de seguir al usuario
                echo "Error al dejar de seguir al usuario: " . $conn->error;
            }
        }
    }

    // Cierra la conexión a la base de datos
    $conn->close();
}
