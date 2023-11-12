<?php 
session_start();

if (isset($_POST['addPost'])) {
    // Obtén el contenido del post del formulario
    $contenido = $_POST['postContent'];
    $lat = $_POST['latitud'];
    $long = $_POST['longitud'];


    require_once "cn.php";

    // Valida si el contenido del post no está vacío y si la ubicación se ha ingresado
    if (empty($contenido)) {
        echo "El contenido del post no puede estar vacío.";
    } elseif (empty($lat) || empty($long)) {
        echo '<script>alert("Por favor, ingresa una ubicación antes de subir la publicación.");</script>';
        
    } else {
        // Conecta a la base de datos (supongamos que ya tienes una conexión a la base de datos)

        // Prepara la consulta SQL para insertar un nuevo post
        $sql = "INSERT INTO t_publicaciones (id_usuario, contenido, fecha_publicacion) VALUES (?, ?, NOW())";

        // Usa una consulta preparada para evitar inyecciones SQL
        if ($stmt = $conn->prepare($sql)) {
            // Vincula los parámetros a la consulta
            $stmt->bind_param("is", $id_user, $contenido);

            // Asigna el valor del id_usuario desde la variable global $id_user
            $id_user = $_SESSION["iduser"];

            // Ejecuta la consulta
            if ($stmt->execute()) {
                $id_publicacion = $conn->insert_id;

                $conn->query("INSERT INTO t_mapas(latitud, longitud, id_publicacion) VALUES ($lat,$long, $id_publicacion)"); 
                header("location: ../pages/index.php");
            } else {
                echo "Error al agregar el post: " . $stmt->error;
            }

            // Cierra la consulta preparada
            $stmt->close();
        } else {
            echo "Error en la consulta preparada: " . $conn->error;
        }

        // Cierra la conexión a la base de datos
        $conn->close();
    }
}
?>