<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

include "../conexiones/cn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica si los campos de contraseña están completos
    if (empty($_POST["currentPassword"]) || empty($_POST["newPassword"]) || empty($_POST["confirmPassword"])) {
        echo "Por favor, completa todos los campos de contraseña.";
    } else {
        // Verifica la contraseña actual
        $id_usuario = $_SESSION["iduser"];
        $currentPassword = $_POST["currentPassword"];
        $query = "SELECT password_hash FROM t_usuarios WHERE id_usuario = $id_usuario";
        $result = $conn->query($query);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashedPassword = $row["password_hash"];

            if (password_verify($currentPassword, $hashedPassword)) {
                // Contraseña actual es correcta, verifica la nueva contraseña y la confirmación

                $newPassword = $_POST["newPassword"];
                $confirmPassword = $_POST["confirmPassword"];

                if ($newPassword === $confirmPassword) {
                    // Nueva contraseña y confirmación coinciden, procede con las actualizaciones

                    // Actualiza el correo electrónico
                    $email = $_POST["email"];
                    $updateEmailQuery = "UPDATE t_usuarios SET correo = '$email' WHERE id_usuario = $id_usuario";
                    $conn->query($updateEmailQuery);

                    // Actualiza la contraseña si se proporciona una nueva
                    if (!empty($_POST["newPassword"])) {
                        $newPassword = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
                        $updatePasswordQuery = "UPDATE t_usuarios SET password_hash = '$newPassword' WHERE id_usuario = $id_usuario";
                        $conn->query($updatePasswordQuery);
                    }

                    // Actualiza la configuración de privacidad de comentarios en la tabla t_perfil
                    $commentPrivacy = $_POST["commentPrivacy"];
                    if ($commentPrivacy === 'private') {
                        $updatePrivacyQuery = "UPDATE t_perfil SET comentario_boolean = 1 WHERE id_usuario = $id_usuario";
                        $conn->query($updatePrivacyQuery);
                    } else {
                        $updatePrivacyQuery = "UPDATE t_perfil SET comentario_boolean = 0 WHERE id_usuario = $id_usuario";
                        $conn->query($updatePrivacyQuery);
                    }

                    // Actualiza el país
                    $country = $_POST["country"];
                    $updateCountryQuery = "UPDATE t_usuarios SET pais = '$country' WHERE id_usuario = $id_usuario";
                    $conn->query($updateCountryQuery);

                    // Puedes agregar más campos y actualizaciones según sea necesario

                    echo "Cambios guardados exitosamente.";
                } else {
                    echo "La nueva contraseña y la confirmación no coinciden.";
                }
            } else {
                echo "Contraseña actual incorrecta.";
            }
        } else {
            echo "Error al obtener la información del usuario.";
        }
    }
}

$conn->close();
?>
