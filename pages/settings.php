<?php

session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

// Conexión a la base de datos (asegúrate de que tu conexión está configurada correctamente)
include "../conexiones/cn.php";

// Obtén el ID de usuario de la sesión
$id_usuario = $_SESSION["iduser"];

// Realiza la consulta para obtener datos del perfil del usuario
$query = "SELECT * FROM t_usuarios WHERE id_usuario = $id_usuario";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $perfil = $result->fetch_assoc();
} else {
    echo "No se encontraron datos para el usuario con ID $id_usuario";
}

// Cierra la conexión
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../assets/css/styles.css">
    <title>Document</title>
</head>

<body>
    <?php include './../includes/header.php'; ?>

    <div class="settings-container">
        <h1>Configuración Avanzada</h1>
        <form action="update_settings.php" method="POST">
            <div class="form-group">
                <label for="email">Correo Electrónico:</label>
                <input type="email" name="email" id="email" value="<?php echo $perfil['correo']?>" required>
            </div>

            <div class="form-group">
                <label for="currentPassword">Contraseña Actual:</label>
                <input type="password" name="currentPassword" id="currentPassword" required>
            </div>

            <div class="form-group">
                <label for="newPassword">Nueva Contraseña:</label>
                <input type="password" name="newPassword" id="newPassword">
            </div>

            <div class="form-group">
                <label for="confirmNewPassword">Confirmar Nueva Contraseña:</label>
                <input type="password" name="confirmNewPassword" id="confirmNewPassword">
            </div>

            <div class="form-group">
                <label for="commentPrivacy">Configuración de Privacidad de Comentarios:</label>
                <select name="commentPrivacy" id="commentPrivacy">
                    <option value="public">Cualquiera puede comentar</option>
                    <option value="private">Nadie puede comentar</option>
                </select>
            </div>

            <div class="form-group">
                <label for="country">País:</label>
                <select name="country" id="country">
                    <option value="usa">Estados Unidos</option>
                    <option value="canada">Canadá</option>
                    <option value="mexico">México</option>
                    <!-- Agrega más opciones según los países que desees permitir -->
                </select>
            </div>

            <div class="form-group">
                <button type="submit" class="btn-submit-setting">Guardar Cambios</button>
            </div>
        </form>
    </div>

</body>

</html>