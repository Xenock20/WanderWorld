<?php
if (!empty($_POST["register"])) {
    if (empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["nationality"])) {
        echo '<div class="alerta">Uno de los campos está vacío</div>';
    } else {
        $user = $_POST['username'];
        $mail = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $nation = $_POST['nationality'];

        // Inserta el nuevo usuario en la tabla t_usuarios
        $sql = $conn->query("INSERT INTO t_usuarios (usuario, correo, password_hash, pais, fecha_registro) VALUES ('$user', '$mail', '$password', '$nation', NOW())");

        if ($sql) {
            // Obtiene el ID del usuario recién registrado
            $id_usuario = $conn->insert_id;

            // Inserta un perfil vinculado al usuario
            $conn->query("INSERT INTO t_perfil (id_usuario, id_foto, nombre_completo, comentario_boolean, info) VALUES ($id_usuario, 1, '$user', 0, NULL)");
            header("Location: login.php"); // Redirige a la página de inicio de sesión
            exit();
        } else {
            echo '<div class="alerta">Error al registrar</div>';
        }
    }
}
