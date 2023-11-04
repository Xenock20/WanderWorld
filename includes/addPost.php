<button class="open-modal" id="openModalBtn">Agregar Post</button>

<div class="modal" id="postModal">
    <div class="modal-content">
        <h2>Agregar un nuevo post</h2>
        <form>
            <label for="postContent">Contenido del post:</label>
            <textarea id="postContent" rows="4" cols="50"></textarea>
            <button type="submit">Publicar</button>
        </form>
        <button class="close-button" id="closeModalBtn">Cerrar</button>
    </div>

</div>

<script>
    // JavaScript para abrir y cerrar el modal
    const openModalBtn = document.getElementById("openModalBtn");
    const postModal = document.getElementById("postModal");
    const closeModalBtn = document.getElementById("closeModalBtn");

    openModalBtn.addEventListener("click", () => {
        postModal.style.display = "flex";
    });

    closeModalBtn.addEventListener("click", () => {
        postModal.style.display = "none";
    });

    // Cierra el modal si se hace clic fuera de él
    window.addEventListener("click", (event) => {
        if (event.target === postModal) {
            postModal.style.display = "none";
        }
    });
</script>