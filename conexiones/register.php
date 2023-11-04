<?php
if(!empty($_POST["register"])){
    if(empty($_POST["username"]) or empty($_POST["email"]) or empty($_POST["password"]) or empty($_POST["nationality"])){
        echo '<div class="alerta">uno de los campos está vacio</div>';
    }else{
        $user = $_POST['username'];
        $mail = $_POST['email'];
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $nation = $_POST['nationality'];

        $sql = $conn->query("INSERT INTO Users (username, email, password_hash, nationality, date_joined) VALUES ('$user', '$mail', '$password', '$nation',NOW())");
        if($sql==1){
            header("Location: login.php"); // Redirige a bienvenido.php
            exit();
        }else{
            echo '<div class="alerta">Error al registrar</div>';
        }
    }
}
?>