
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
            <form action="" method="post" class="box-login">
                <h1>Registrarse</h1>
                <?php
                    include("conexiones/cn.php");
                    include("conexiones/register.php");
                ?>
                <div class="form-control">
                    <input type="text" class="input-login" name="username" id="username" placeholder="Nombre de Usuario" >
                    <input type="email" class="input-login" name="email" id="email" placeholder="Correo Electrónico">
                    <input type="password" class="input-login" name="password" id="password" placeholder="Contraseña">
                    <select class="input-login" name="nationality" id="nationality" for="nationality">
                        <option value="">Seleccionar Nacionalidad</option>
                        
                        <!-- Agrega más opciones de países según sea necesario -->
                    </select>
                </div>
                <div class="form-control">
                    <input type="submit" class="btn-login" value="Registrarse" id="btn_register" name="register">
                </div>

                <div class="form-control">
                    <a href="login.php" class="register">Yá tengo cuenta</a>
                </div>
            </form>
        </div>
    </div>

    <script>
    // URL de la API Restcountries
    const apiUrl = "https://restcountries.com/v3.1/all";

    // Obtener el elemento select
    const selectPaises = document.getElementById("nationality");

    // Hacer una solicitud a la API para obtener la lista de países
    fetch(apiUrl)
      .then(response => response.json())
      .then(data => {
        // Iterar sobre la lista de países y agregar opciones al select
        data.forEach(pais => {
          const option = document.createElement("option");
          option.value = pais.name.common;
          option.text = pais.name.common;
          selectPaises.add(option);
        });
      })
      .catch(error => console.error("Error al obtener la lista de países", error));
  </script>
</body>

</html>
