<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newuser = $_POST['newUsername'];
    $newinfo = $_POST['newUserInfo'];

    require_once "../conexiones/cn.php";
    $id_user = $_SESSION['iduser'];
    $sql = "UPDATE t_usuarios SET usuario = '$newuser' WHERE id_usuario = '$id_user'";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['user'] = $newuser;
        $_SESSION["info"] = $newinfo;
        echo "<script>alert('se ha cambiado el nombre');</script>";

        if ($_FILES["newProfileImage"]["error"] == UPLOAD_ERR_OK) {
            $nombreArchivo = "profile";
            $tamanioArchivo = $_FILES['newProfileImage']['size'];
            $tempArchivo = $_FILES['newProfileImage']['tmp_name'];

            $newProfileImage = file_get_contents($tempArchivo);
            $newProgileImage64 = base64_encode($newProfileImage);
            $tipo_mime = mime_content_type($tempArchivo); // Obtiene el tipo MIME de la imagen

            $perfil_query = $conn->query("SELECT * FROM t_perfil WHERE id_usuario = $id_user");

            if ($perfil_query->num_rows == 1) {
                $perfil = $perfil_query->fetch_assoc();
                $id_foto = $perfil["id_foto"];

                if ($id_foto == 1) {
                    if ($conn->query("INSERT INTO t_fotos (nombre, tipo_mime, imagen) VALUES ('profile', '$tipo_mime', '$newProgileImage64')")) {

                        $id_foto_new = $conn->insert_id;

                        if ($conn->query("UPDATE t_perfil SET id_foto = '$id_foto_new', info = '$newinfo' WHERE id_usuario = '$id_user'")) {
                            $img_src = "data:$tipo_mime;base64,$newProgileImage64";
                            $_SESSION["img"] = $img_src;
                            header("location: ../pages/profile.php");
                        }
                    }
                }

                if ($conn->query("UPDATE t_fotos SET nombre = '$nombreArchivo', tipo_mime = '$tipo_mime', imagen = '$newProgileImage64' WHERE id_foto = '$id_foto'")) {
                    $img_src = "data:$tipo_mime;base64,$newProgileImage64";
                    $_SESSION["img"] = $img_src;
                    header("location: ../pages/profile.php");
                } else {
                    echo "Error al actualizar la imagen de perfil: ";
                }
            }
        } else {
            echo "No se seleccionó ninguna imagen.";
        }
    } else {
        echo "<script>alert('error');</script>";
    }

    $conn->close();
}
