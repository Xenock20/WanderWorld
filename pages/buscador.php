<?php
session_start();
include '../conexiones/cn.php';

$term = $_GET['term'];
$id_user = $_SESSION["iduser"];

$sql = "SELECT t_perfil.*, COUNT(t_followings.id_following) as num_seguidores 
        FROM t_perfil 
        LEFT JOIN t_followings ON t_perfil.id_perfil = t_followings.id_usuario_seguido 
        WHERE t_perfil.nombre_completo LIKE '$term%'
          AND t_perfil.id_usuario != '$id_user'
        GROUP BY t_perfil.id_perfil";

$result = $conn->query($sql);

$data = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $id_foto = $row["id_foto"];
        $nombre_completo = $row["nombre_completo"];
        $id_usuario = $row["id_usuario"];

        $imagen_b_query = $conn->query("SELECT imagen, tipo_mime FROM t_fotos WHERE id_foto = $id_foto");

        $imagen_b = $imagen_b_query->fetch_assoc();
        $imagenBase64_b = $imagen_b["imagen"];
        $tipo_mime_b = $imagen_b["tipo_mime"];

        $img_src_b = "data:$tipo_mime_b;base64,$imagenBase64_b";

        // Verificar si el usuario actual sigue a $id_usuario
        $query_verificar_seguimiento = "SELECT COUNT(*) as sigue_usuario FROM t_followings WHERE id_usuario_seguidor = '$id_user' AND id_usuario_seguido = '$id_usuario'";
        $result_verificar_seguimiento = $conn->query($query_verificar_seguimiento);
        $sigue_usuario = ($result_verificar_seguimiento->fetch_assoc()["sigue_usuario"] == 1);


        // Obtener el número de seguidores
        $query_num_seguidores = "SELECT COUNT(*) as cantidad_seguidores FROM t_followings WHERE id_usuario_seguido = '$id_usuario'";
        $result_num_seguidores = $conn->query($query_num_seguidores);
        $fila_num_seguidores = $result_num_seguidores->fetch_assoc();
        $num_seguidores = $fila_num_seguidores["cantidad_seguidores"];

        $usuario = (object) array(
            'nombre_completo' => $nombre_completo,
            'id_usuario' => $id_usuario,
            'img_src_b' => $img_src_b,
            'sigue_usuario' => $sigue_usuario,
            'num_seguidores' => $num_seguidores
        );

        $data[] = $usuario;
    }
}


echo json_encode($data);

$conn->close();
