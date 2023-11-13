<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/styles.css">
    <title>Login</title>
</head>

<body>
    <div class="overlay"></div>
    <div class="container">
        <div class="cont-login">
            <form action="" method="post" class="box-login">
                <h1>Iniciar Sesión</h1>
                <?php
                include("conexiones/cn.php");
                include("conexiones/ingresar.php");
                ?>
                <div class="form-control">
                    <input type="text" class="input-login" name="user" id="user_login" placeholder="Username">
                    <input type="password" class="input-login" name="password" id="password_login" placeholder="Contraseña">
                </div>
                <div class="form-control">
                    <input type="submit" class="btn-login" value="Ingresar" id="btn_login">
                </div>

                <div class="form-control">
                    <a href="signup.php" class="register">Registrarse</a>
                </div>
            </form>
        </div>
    </div>

</body>

</html>