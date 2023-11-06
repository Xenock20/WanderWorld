<?php
session_start();

if (empty($_POST['user']) || empty($_POST['password'])) {
    echo '<div class="alert">completa los campos</div>';
}else{

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "cn.php";

    $user = $_POST["user"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM t_usuarios WHERE usuario = '$user'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();
        if (password_verify($password, $fila["password_hash"])) {
            $_SESSION["loggedin"] = true;
            $_SESSION["user"] = $fila["usuario"];
        
            // Agrega el código para obtener el nombre_completo y la imagen del perfil aquí
            $id_usuario = $fila["id_usuario"];
            $_SESSION["iduser"] = $id_usuario;
            $perfil_query = $conn->query("SELECT * FROM t_perfil WHERE id_usuario = $id_usuario");
            if ($perfil_query->num_rows == 1) {
                $perfil = $perfil_query->fetch_assoc();
                $_SESSION["nombre_completo"] = $perfil["nombre_completo"];
                $_SESSION["info"] = $perfil["info"];
                $_SESSION["idperfil"] = $perfil["id_perfil"];
        
                // Obtiene la imagen de la base de datos
                $id_foto = $perfil["id_foto"];
                $imagen_query = $conn->query("SELECT imagen, tipo_mime FROM t_fotos WHERE id_foto = $id_foto");
                if ($imagen_query->num_rows == 1) {
                    $imagen = $imagen_query->fetch_assoc();
                    $imagenBase64 = $imagen["imagen"];
                    $tipo_mime = $imagen["tipo_mime"];
        
                    // Construye la URL de la imagen y asigna a $_SESSION["img"]
                    $img_src = "data:$tipo_mime;base64,$imagenBase64";
                    $_SESSION["img"] = $img_src;
                }
            }
        
            header("location: pages/index.php");
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $conn->close();
}}
