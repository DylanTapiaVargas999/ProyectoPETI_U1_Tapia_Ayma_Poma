<style>
    .editar-vision-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
        color: #333;
    }

    .editar-vision-container h2 {
        color: #f7af51;
        font-size: 2rem;
        margin-bottom: 1rem;
        text-align: center;
    }

    .editar-vision-container textarea {
        width: 100%;
        height: 120px;
        padding: 0.8rem;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 10px;
        resize: vertical;
        margin-bottom: 1rem;
    }

    .editar-vision-container button {
        background-color: #3faabd;
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .editar-vision-container button:hover {
        background-color: #49c4da;
    }
</style>

<div class="editar-vision-container">
    <h2>Editar Visión</h2>

    <form action="<?= base_url ?>vision/actualizar" method="POST">
        <input type="hidden" name="id_vision" value="<?= $visionActual->id_vision ?>">
        <textarea name="vision" required><?= htmlspecialchars($visionActual->vision) ?></textarea>
        <button type="submit">Guardar cambios</button>
    </form>
</div>
