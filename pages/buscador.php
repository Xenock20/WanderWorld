<?php
    include '../conexiones/cn.php';

    $term = $_GET['term'];

    $sql = "SELECT t_perfil.*, COUNT(t_followings.id_following) as num_seguidores 
            FROM t_perfil 
            LEFT JOIN t_followings ON t_perfil.id_perfil = t_followings.id_usuario_seguido 
            WHERE t_perfil.nombre_completo LIKE '$term%'
            GROUP BY t_perfil.id_perfil";

    $result = $conn->query($sql);

    $data = array();

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    echo json_encode($data);

    $conn->close();
?>