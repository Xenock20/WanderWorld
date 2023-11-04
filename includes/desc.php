<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $newuser = $_POST['newUsername'];
        $newinfo = $_POST['newUserInfo'];
    
        require_once "../conexiones/cn.php";
        $user = $_SESSION['user'];
        $sql = "UPDATE users SET username = '$newuser', descripcion = '$newinfo' WHERE username = '$user'";
    
        if($conn->query($sql) === TRUE){
            $_SESSION['user'] = $newuser;
            $_SESSION["info"] = $newinfo;
            echo "<script>alert('se ha cambiado el nombre');</script>";
    
            if ($_FILES["newProfileImage"]["error"] == UPLOAD_ERR_OK) {
                $nombreArchivo = $_FILES['newProfileImage']['name'];
                $tipoArchivo = $_FILES['newProfileImage']['type'];
                $tamanioArchivo = $_FILES['newProfileImage']['size'];
                $tempArchivo = $_FILES['newProfileImage']['tmp_name'];
    
                $newProfileImage = file_get_contents($tempArchivo);
    
                $stmt = $conn->prepare("UPDATE users SET img = ? WHERE username = ?");
                $stmt->bind_param("ss", $newProfileImage, $newuser);
    
                if ($stmt->execute()) {
                    echo "La imagen de perfil se actualizó correctamente.";
                } else {
                    echo "Error al actualizar la imagen de perfil: " . $stmt->error;
                }
    
                $stmt->close();
            } else {
                echo "No se seleccionó ninguna imagen.";
            }
    
        } else {
            echo "<script>alert('error');</script>";
        }
    
        $conn->close();
    } 
?>
