<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./../assets/css/styles.css">
    <title>Document</title>
</head>

<body>
    <?php include './../includes/header.php'; ?>

    <div class="profile">
        <div class="profile-principal">
            <div class="profile-info">
                <img src="../assets/images/profile.png" alt="Nombre de Usuario">
                <h1>Nombre de Usuario</h1>
                <p>Información adicional del usuario, como ubicación, edad, etc.</p>
                <button id="editProfileBtn">Editar perfil</button>
            </div>

            <div id="editProfileModal" class="modal">
                <div class="modal-content">
                    <h2>Editar perfil</h2>
                    <form action="tu_script_php.php" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="newUsername">Nuevo nombre de usuario:</label>
                            <input type="text" name="newUsername" id="newUsername" placeholder="Nuevo nombre de usuario">
                        </div>

                        <div class="form-group">
                            <label for="newUserInfo">Nueva información adicional:</label>
                            <textarea name="newUserInfo" id="newUserInfo" placeholder="Nueva información adicional"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="newProfileImage">Subir nueva foto de perfil:</label>
                            <input type="file" name="newProfileImage" id="newProfileImage">
                        </div>

                        <button type="submit" id="saveChangesBtn">Guardar cambios</button>
                    </form>

                    <button class="close-button" id="closeEditProfileModalBtn">Cerrar</button>
                </div>
            </div>

            <script>
                // Obtener elementos del DOM
                const editProfileBtn = document.getElementById("editProfileBtn");
                const editProfileModal = document.getElementById("editProfileModal");
                const closeEditProfileModalBtn = document.getElementById("closeEditProfileModalBtn");

                // Mostrar el modal al hacer clic en "Editar perfil"
                editProfileBtn.addEventListener("click", function() {
                    editProfileModal.style.display = "block";
                });

                // Cerrar el modal al hacer clic en el botón de cerrar
                closeEditProfileModalBtn.addEventListener("click", function() {
                    editProfileModal.style.display = "none";
                });
            </script>

            <div class="profile-followers">
                <div class="followers">
                    <h2>Seguidores</h2>
                    <ul>
                        <li><img src="../assets/images/profile.png" alt="Seguidor 1"> Seguidor 1</li>
                        <li><img src="../assets/images/profile.png" alt="Seguidor 2"> Seguidor 2</li>
                        <!-- Agrega más seguidores según sea necesario -->
                    </ul>
                </div>

                <div class="following">
                    <h2>Siguiendo</h2>
                    <ul>
                        <li><img src="../assets/images/profile.png" alt="Usuario Seguido 1"> Usuario Seguido 1</li>
                        <li><img src="../assets/images/profile.png" alt="Usuario Seguido 2"> Usuario Seguido 2</li>
                        <!-- Agrega más usuarios seguidos según sea necesario -->
                    </ul>
                </div>
            </div>
        </div>


        <div class="profile-posts">
            <?php include './../includes/addPost.php'; ?>

            <div class="post">
                <div class="user-info">
                    <img src="../assets/images/profile.png" alt="Nombre de Usuario">
                    <span>Nombre de Usuario</span>
                </div>
                <p class="post-content">
                    Esto es el contenido de la publicación. Puede incluir texto, imágenes y más.
                </p>
                <div class="actions">
                    <div class="like">
                        <i class="fas fa-heart"></i> <span>25 Likes</span>
                    </div>
                    <div class="comments">
                        <i class="fas fa-comment"></i> <span>10 Comentarios</span>
                    </div>
                </div>
                <div class="comment-section">
                    <input type="text" placeholder="Añadir un comentario...">
                    <button>Publicar</button>
                </div>
                <div class="comments">
                    <div class="comment">
                        <img src="../assets/images/profile.png" alt="Nombre del Comentarista">
                        <span>Nombre del Comentarista:</span>
                        <p>Este es un comentario en la publicación. Puede incluir texto y más.</p>
                    </div>
                    <!-- Puedes agregar más comentarios aquí -->
                </div>
            </div>
            <div class="post">
                <div class="user-info">
                    <img src="../assets/images/profile.png" alt="Nombre de Usuario">
                    <span>Nombre de Usuario</span>
                </div>
                <p class="post-content">
                    Esto es el contenido de la publicación. Puede incluir texto, imágenes y más.
                </p>
                <div class="actions">
                    <div class="like">
                        <i class="fas fa-heart"></i> <span>25 Likes</span>
                    </div>
                    <div class="comments">
                        <i class="fas fa-comment"></i> <span>10 Comentarios</span>
                    </div>
                </div>
                <div class="comment-section">
                    <input type="text" placeholder="Añadir un comentario...">
                    <button>Publicar</button>
                </div>
                <div class="comments">
                    <div class="comment">
                        <img src="../assets/images/profile.png" alt="Nombre del Comentarista">
                        <span>Nombre del Comentarista:</span>
                        <p>Este es un comentario en la publicación. Puede incluir texto y más.</p>
                    </div>
                    <!-- Puedes agregar más comentarios aquí -->
                </div>
            </div>
            <div class="post">
                <div class="user-info">
                    <img src="../assets/images/profile.png" alt="Nombre de Usuario">
                    <span>Nombre de Usuario</span>
                </div>
                <p class="post-content">
                    Esto es el contenido de la publicación. Puede incluir texto, imágenes y más.
                </p>
                <div class="actions">
                    <div class="like">
                        <i class="fas fa-heart"></i> <span>25 Likes</span>
                    </div>
                    <div class="comments">
                        <i class="fas fa-comment"></i> <span>10 Comentarios</span>
                    </div>
                </div>
                <div class="comment-section">
                    <input type="text" placeholder="Añadir un comentario...">
                    <button>Publicar</button>
                </div>
                <div class="comments">
                    <div class="comment">
                        <img src="../assets/images/profile.png" alt="Nombre del Comentarista">
                        <span>Nombre del Comentarista:</span>
                        <p>Este es un comentario en la publicación. Puede incluir texto y más.</p>
                    </div>
                    <!-- Puedes agregar más comentarios aquí -->
                </div>
            </div>
            <div class="post">
                <div class="user-info">
                    <img src="../assets/images/profile.png" alt="Nombre de Usuario">
                    <span>Nombre de Usuario</span>
                </div>
                <p class="post-content">
                    Esto es el contenido de la publicación. Puede incluir texto, imágenes y más.
                </p>
                <div class="actions">
                    <div class="like">
                        <i class="fas fa-heart"></i> <span>25 Likes</span>
                    </div>
                    <div class="comments">
                        <i class="fas fa-comment"></i> <span>10 Comentarios</span>
                    </div>
                </div>
                <div class="comment-section">
                    <input type="text" placeholder="Añadir un comentario...">
                    <button>Publicar</button>
                </div>
                <div class="comments">
                    <div class="comment">
                        <img src="../assets/images/profile.png" alt="Nombre del Comentarista">
                        <span>Nombre del Comentarista:</span>
                        <p>Este es un comentario en la publicación. Puede incluir texto y más.</p>
                    </div>
                    <!-- Puedes agregar más comentarios aquí -->
                </div>
            </div>
            <div class="post">
                <div class="user-info">
                    <img src="../assets/images/profile.png" alt="Nombre de Usuario">
                    <span>Nombre de Usuario</span>
                </div>
                <p class="post-content">
                    Esto es el contenido de la publicación. Puede incluir texto, imágenes y más.
                </p>
                <div class="actions">
                    <div class="like">
                        <i class="fas fa-heart"></i> <span>25 Likes</span>
                    </div>
                    <div class="comments">
                        <i class="fas fa-comment"></i> <span>10 Comentarios</span>
                    </div>
                </div>
                <div class="comment-section">
                    <input type="text" placeholder="Añadir un comentario...">
                    <button>Publicar</button>
                </div>
                <div class="comments">
                    <div class="comment">
                        <img src="../assets/images/profile.png" alt="Nombre del Comentarista">
                        <span>Nombre del Comentarista:</span>
                        <p>Este es un comentario en la publicación. Puede incluir texto y más.</p>
                    </div>
                    <!-- Puedes agregar más comentarios aquí -->
                </div>
            </div>
        </div>
    </div>

</body>

</html>