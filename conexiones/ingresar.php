<?php
session_start();

if (empty($_POST['user']) || empty($_POST['password'])) {
    echo '<div class="alert">completa los campos</div>';
}else{

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    require_once "cn.php";

    $user = $_POST["user"];
    $password = $_POST["password"];

    $sql = "SELECT * FROM users WHERE username = '$user'";
    $resultado = $conn->query($sql);

    if ($resultado->num_rows == 1) {
        $fila = $resultado->fetch_assoc();
        if (password_verify($password, $fila["password_hash"])) {
            $_SESSION["loggedin"] = true;
            $_SESSION["user"] = $fila["username"];
            $_SESSION["info"] = $fila["descripcion"];
            $_SESSION["img"] = $fila['img'];
            header("location: pages/index.php");
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Usuario no encontrado.";
    }

    $conn->close();
}}
?>

