<?php 
session_start();

if (isset($_POST['addPost'])) {
    // Obtén el contenido del post del formulario
    $contenido = $_POST['postContent'];

    require_once "cn.php";

    // Valida si el contenido del post no está vacío
    if (empty($contenido)) {
        echo "El contenido del post no puede estar vacío.";
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
