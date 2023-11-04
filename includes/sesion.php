<?php
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: ../login.php");
    exit;
}

require_once "../conexiones/cn.php";

$user = $_SESSION["user"];
$info = $_SESSION['info'];
$img = $_SESSION['img'];
//$email = $_SESSION["email"]; depende xd

// Puedes obtener más información del perfil desde la base de datos si es necesario
// por ejemplo, utilizando la variable $nombre para hacer una consulta adicional.

$conn->close();
?>