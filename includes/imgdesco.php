<?php
require_once "../conexiones/cn.php";
session_start();
$user = $_SESSION['user'];

$sql = "SELECT imagen FROM users WHERE username = '$user'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $imagenBinaria = $row["imagen"];
    $imagenBase64 = base64_encode($imagenBinaria);
    $imagenSrc = "data:image/jpeg;base64," . $imagenBase64;
} else {
    $imagenSrc = "ruta/por/defecto/imagen.jpg"; // Ruta de una imagen por defecto
}

$conn->close();
?>