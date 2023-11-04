<?php
    include("cn.php");

    $user = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $nation = $_POST['nationality'];
    $sql = "INSERT INTO users (username, email, password_hash, nationality,date_joined) VALUES ('$user', '$email', '$password','$nation', NOW())";

    if ($conn->query($sql) === TRUE) {
        header("Location: login.php"); // Redirige login.php
        exit(); // Asegura que el script se detenga después de la redirección
    }

    $conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <title>Registro</title>
</head>

<body>
    <div class="overlay"></div>
    <div class="container">
        <div class="cont-login">
            <form action="signup.php" method="post" class="box-login">
                <h1>Registrarse</h1>

                <div class="form-control">
                    <input type="text" class="input-login" name="username" id="username" placeholder="Nombre de Usuario" required>
                    <input type="email" class="input-login" name="email" id="email" placeholder="Correo Electrónico" required>
                    <input type="password" class="input-login" name="password" id="password" placeholder="Contraseña" required>
                    <select class="input-login" name="nationality" id="nationality">
                        <option value="">Seleccionar Nacionalidad</option>
                        <option value="pais1">País 1</option>
                        <option value="pais2">País 2</option>
                        <!-- Agrega más opciones de países según sea necesario -->
                    </select>
                </div>
                <div class="form-control">
                    <input type="submit" class="btn-login" value="Registrarse" id="btn_register">
                </div>

                <div class="form-control">
                    <a href="login.php" class="register">Yá tengo cuenta</a>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
