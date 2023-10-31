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
    <div class="cont-login">
        <form action="" method="post" class="box-login">
            <h1>Iniciar Sesión</h1>

            <div class="form-control">
                <input type="email" class="input-login" name="email" id="email_login" placeholder="Correo">
                <input type="password" class="input-login" name="password" id="password_login" placeholder="Contraseña">
            </div>
            <div class="form-control">
                <input type="submit" class="btn-login" value="Ingresar" id="btn_login">
            </div>

            <div class="form-control">
                <a href="olvido_contrasena.html" class="forgot-password">¿Olvidaste tu contraseña?</a>
                <span>o</span>
                <a href="signup.php" class="register">Registrarse</a>
            </div>
        </form>
    </div>
</body>

</html>