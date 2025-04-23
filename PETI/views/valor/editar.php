<style>
    .editar-valores-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background: #ffffff;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        font-family: Arial, sans-serif;
        color: #333;
    }

    .editar-valores-container h2 {
        color: #f7af51;
        font-size: 2rem;
        margin-bottom: 1rem;
        text-align: center;
    }

    .editar-valores-container textarea {
        width: 100%;
        height: 120px;
        padding: 0.8rem;
        font-size: 1rem;
        border: 1px solid #ccc;
        border-radius: 10px;
        resize: vertical;
        margin-bottom: 1rem;
    }

    .editar-valores-container button {
        background-color: #3faabd;
        color: white;
        border: none;
        padding: 0.6rem 1.5rem;
        border-radius: 10px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .editar-valores-container button:hover {
        background-color: #49c4da;
    }
</style>

<div class="editar-valores-container">
    <h2>Editar Valores</h2>

    <form action="<?= base_url ?>valor/actualizar" method="POST">
        <input type="hidden" name="id_valor" value="<?= $valorActual->id_valor ?>">
        <textarea name="valor" required><?= htmlspecialchars($valorActual->valor) ?></textarea>
        <button type="submit">Guardar cambios</button>
    </form>
</div>
