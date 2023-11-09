<?php
if (!empty($_POST["register"])) {
    // Verificación de campos vacíos
    if (empty($_POST["username"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["nationality"])) {
        echo '<div class="alerta">Uno de los campos está vacío</div>';
        exit();
    }

    $user = htmlspecialchars($_POST['username']);
    $mail = htmlspecialchars($_POST['email']);
    $nation = htmlspecialchars($_POST['nationality']);

    // Verificación de formato de correo electrónico
    if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        echo '<div class="alerta">El correo electrónico no es válido</div>';
        exit();
    }

    // Verificación de longitud de contraseña
    $password = $_POST['password'];
    if (strlen($password) < 8) {
        echo '<div class="alerta">La contraseña debe tener al menos 8 caracteres</div>';
        exit();
    }

    // Verificación de espacios en blanco en todos los campos
    if (strpos($user, ' ') !== false || strpos($mail, ' ') !== false || strpos($password, ' ') !== false) {
        echo '<div class="alerta">Ninguno de los campos puede contener espacios en blanco</div>';
        exit();
    }

    // Hashear la contraseña
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Verificar si el nombre de usuario ya está en uso
    $stmt = $conn->prepare("SELECT * FROM t_usuarios WHERE usuario = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo '<div class="alerta">El nombre de usuario ya está en uso</div>';
        exit();
    }

    // Si el nombre de usuario no está en uso y no contiene espacios, proceder con la inserción
    $stmt = $conn->prepare("INSERT INTO t_usuarios (usuario, correo, password_hash, pais, fecha_registro) VALUES (?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssss", $user, $mail, $password, $nation);

    if ($stmt->execute()) {
        $id_usuario = $stmt->insert_id;

        // Insertar un perfil vinculado al usuario
        $conn->query("INSERT INTO t_perfil (id_usuario, id_foto, nombre_completo, comentario_boolean, info) VALUES ($id_usuario, 1, '$user', 0, NULL)");

        header("Location: login.php"); // Redirigir a la página de inicio de sesión
        exit();
    } else {
        echo '<div class="alerta">Error al registrar</div>';
    }
} else {
    // Manejo de errores de conexión a la base de datos
    if ($conn->connect_error) {
        die("Error de conexión a la base de datos: " . $conn->connect_error);
    }
}
?>
