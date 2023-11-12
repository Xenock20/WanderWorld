<?php
require_once "cn.php";

// Obtener el id de la publicación a eliminar
$id_publicacion_a_eliminar = $_POST['id_publicacion'];

try {
    // Iniciar una transacción
    $conn->begin_transaction();

    // 1. Eliminar registros en t_likes relacionados con la publicación
    $conn->query("DELETE FROM t_likes WHERE id_publicacion = $id_publicacion_a_eliminar");

    // 2. Eliminar registros en t_comentarios relacionados con la publicación
    $conn->query("DELETE FROM t_comentarios WHERE id_publicacion = $id_publicacion_a_eliminar");

    // 3. Eliminar el registro en t_mapas relacionado con la publicación
    $conn->query("DELETE FROM t_mapas WHERE id_publicacion = $id_publicacion_a_eliminar");

    // 4. Eliminar la publicación de la tabla t_publicaciones
    $conn->query("DELETE FROM t_publicaciones WHERE id_publicacion = $id_publicacion_a_eliminar");

    // Confirmar la transacción
    $conn->commit();

    header("Location: ../pages/index.php"); // Redirige a la página de publicaciones

} catch (Exception $e) {
    // Revertir la transacción en caso de error
    $conn->rollback();
    echo "Error al eliminar la publicación: " . $e->getMessage();
}

// Cerrar la conexión
$conn->close();
