<?php
session_start();

// Elimina todas las variables de sesión
$_SESSION = array();

// Destruye la sesión
session_destroy();

// Redirige a la página de login (o cualquier otra página)
header("location: ../login.php");
exit;
?>