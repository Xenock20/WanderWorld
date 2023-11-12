<?php
// Conecta a la base de datos (asegúrate de tener una conexión establecida)
require_once "cn.php";

// Verifica si se ha enviado un formulario para eliminar un comentario
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["deleteComment"])) {
    // Obtén el id del comentario desde el formulario
    $id_comentario = $_POST["id_comentario"];

    // Realiza la consulta para eliminar el comentario
    $eliminar_comentario_sql = "DELETE FROM t_comentarios WHERE id_comentario = $id_comentario";

    if ($conn->query($eliminar_comentario_sql) === TRUE) {
        // Éxito al eliminar el comentario
        header("Location: ../pages/index.php"); // Redirige a la página de publicaciones

        exit();
    } else {
        // Error al eliminar el comentario
        echo "Error al eliminar el comentario: " . $conn->error;
    }
}

// Si no se envió el formulario o hubo un error, redirige a la página principal o muestra un mensaje de error.
header("Location: ../tu_pagina_de_error.php");
exit();
