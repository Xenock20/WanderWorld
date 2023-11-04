<?php
    $username = $_POST['user'];
    $password = $_POST['password'];

    $queryusuario = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    $nr = mysqli_num_rows($queryusuario);
    $buscarpass = mysqli_fetch_array($queryusuario);

    if(($nr == 1) && (password_verify($password, $buscarpass['password_hash']))){
        header("Location: pages/index.php");
        exit();
    }
?>