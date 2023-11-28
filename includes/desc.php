<?php
session_start(); // Inicia la sesión

if ($_SERVER["REQUEST_METHOD"] == "POST") { // Verifica si la solicitud HTTP es de tipo POST
    $newuser = $_POST['newUsername']; // Obtiene el nuevo nombre de usuario desde el formulario POST
    $newinfo = $_POST['newUserInfo']; // Obtiene la nueva información del usuario desde el formulario POST

    if (empty($newuser) || empty($newinfo)) {
        echo "Los campos nombre de usuario e información no pueden estar vacíos.";
        
    }

    require_once "../conexiones/cn.php"; // Incluye el archivo de conexión a la base de datos

    $id_user = $_SESSION['iduser']; // Obtiene el ID de usuario almacenado en la sesión

    // Realiza una consulta para obtener la información actual del usuario
    $user_query = $conn->query("SELECT * FROM t_usuarios WHERE id_usuario = $id_user");

    if ($user_query->num_rows == 1) { // Verifica si existe el usuario
        $current_user = $user_query->fetch_assoc(); // Obtiene la información actual del usuario

        // Verifica si ha habido cambios en los datos
        if ($current_user['usuario'] != $newuser || $current_user['info'] != $newinfo) {
            $sql = "UPDATE t_usuarios SET usuario = '$newuser' WHERE id_usuario = '$id_user'"; // Prepara una consulta SQL para actualizar el nombre de usuario

            if ($conn->query($sql) === TRUE) { // Ejecuta la consulta SQL y verifica si fue exitosa
                $_SESSION['user'] = $newuser; // Actualiza el nombre de usuario en la sesión
                $_SESSION["info"] = $newinfo; // Actualiza la información de usuario en la sesión
                echo "<script>alert('Se ha cambiado el nombre');</script>"; // Muestra una alerta en el navegador

                if ($_FILES["newProfileImage"]["error"] == UPLOAD_ERR_OK) { // Verifica si se ha cargado una nueva imagen de perfil correctamente
                    $nombreArchivo = "profile"; // Define el nombre del archivo
                    $tamanioArchivo = $_FILES['newProfileImage']['size']; // Obtiene el tamaño del archivo
                    $tempArchivo = $_FILES['newProfileImage']['tmp_name']; // Obtiene la ubicación temporal del archivo cargado
        
                    $newProfileImage = file_get_contents($tempArchivo); // Lee el contenido del archivo
                    $newProgileImage64 = base64_encode($newProfileImage); // Codifica la imagen en base64
                    $tipo_mime = mime_content_type($tempArchivo); // Obtiene el tipo MIME de la imagen
        
                    // Realiza una consulta para obtener la información del perfil del usuario
                    $perfil_query = $conn->query("SELECT * FROM t_perfil WHERE id_usuario = $id_user");
        
                    if ($perfil_query->num_rows == 1) { // Verifica si existe un perfil para el usuario
                        $perfil = $perfil_query->fetch_assoc(); // Obtiene la información del perfil
                        $id_foto = $perfil["id_foto"]; // Obtiene el ID de la foto del perfil
        
                        if ($id_foto == 1) { // Si la foto de perfil no existe, la inserta en la base de datos
                            if ($conn->query("INSERT INTO t_fotos (nombre, tipo_mime, imagen) VALUES ('profile', '$tipo_mime', '$newProgileImage64')")) {
        
                                $id_foto_new = $conn->insert_id; // Obtiene el nuevo ID de la foto
        
                                // Actualiza la información del perfil con el nuevo ID de la foto y la nueva información
                                if ($conn->query("UPDATE t_perfil SET id_foto = '$id_foto_new', info = '$newinfo' WHERE id_usuario = '$id_user'")) {
                                    $img_src = "data:$tipo_mime;base64,$newProgileImage64"; // Genera la fuente de la imagen
                                    $_SESSION["img"] = $img_src; // Actualiza la fuente de la imagen en la sesión
                                    header("location: ../pages/profile.php"); // Redirige a la página de perfil
                                    exit(); // Finaliza la ejecución del script
                                } else {
                                    echo "Error al actualizar la información del perfil: ";
                                }
                            } else {
                                echo "Error al insertar la nueva foto de perfil: ";
                            }
                        } else {
                            // Si la foto de perfil ya existe, actualiza la información de la foto en la base de datos
                            if ($conn->query("UPDATE t_fotos SET nombre = '$nombreArchivo', tipo_mime = '$tipo_mime', imagen = '$newProgileImage64' WHERE id_foto = '$id_foto'")) {
                                $img_src = "data:$tipo_mime;base64,$newProgileImage64"; // Genera la fuente de la imagen
                                $_SESSION["img"] = $img_src; // Actualiza la fuente de la imagen en la sesión
                                header("location: ../pages/profile.php"); // Redirige a la página de perfil
                            } else {
                                echo "Error al actualizar la imagen de perfil: ";
                            }
                        }
                    } else {
                        echo "Error: No se encontró el perfil del usuario.";
                    }
                } else {
                    echo "No se seleccionó ninguna imagen."; // Mensaje si no se seleccionó ninguna imagen
                }
            } else {
                echo "<script>alert('Error al actualizar el nombre de usuario');</script>"; // Mensaje de error si la consulta SQL no fue exitosa
            }
        } else {
            echo "<script>alert('No se realizó ningún cambio');</script>"; // Mensaje si no se realizaron cambios
        }
    } else {
        echo "<script>alert('Usuario no encontrado');</script>"; // Mensaje si el usuario no fue encontrado
    }

    $conn->close(); // Cierra la conexión a la base de datos
}
?>
