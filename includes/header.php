<?php
    include 'sesion.php';
?>

<div class="overlay"></div>
<header>
    <div class="header-content">
        <div class="logo">
            <div class="logo-icon">
                <i class="fas fa-globe"></i> <!-- Icono de Font Awesome -->
            </div>
            <div class="logo-text">
                <span>WanderWorld</span>
            </div>
        </div>
        <div class="navigation">
            <ul>
                <li><a href="index.php"><i class="fas fa-home"></i> Inicio</a></li>
                <li><?php echo '<a href="profile.php?id=' . $id_user . '"><i class="fas fa-user"></i> Perfil</a>';?></li>
                <li><a href="explore.php"><i class="fas fa-compass"></i> Explorar</a></li>
                <li><a href="settings.php"><i class="fas fa-cog"></i> Configuración</a></li>
            </ul>
        </div>
        <div class="user-profile">
            <i class="fas fa-user"></i> <!-- Icono de usuario de Font Awesome -->
            <span><?php echo $user_profile?></span>
            <a href="../includes/logout.php" title="Salir">
                <i class="fas fa-sign-out-alt"></i> <!-- Icono de cerrar sesión de Font Awesome -->
            </a>
        </div>
    </div>
</header>
<script src="https://kit.fontawesome.com/5ebed57939.js" crossorigin="anonymous"></script>