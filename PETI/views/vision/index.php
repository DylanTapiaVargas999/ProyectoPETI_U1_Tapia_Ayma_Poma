<style>
    .vision-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background: #f4f4f4;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
        color: #333;
    }

    .vision-container h1 {
        color: #f7af51;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .vision-container h2 {
        margin-top: 2rem;
        color: #3faabd;
    }

    .vision-container textarea {
        width: 100%;
        height: 100px;
        padding: 0.5rem;
        font-size: 1rem;
        margin-top: 1rem;
        border-radius: 10px;
        border: 1px solid #ccc;
        resize: vertical;
    }

    .vision-container button {
        margin-top: 1rem;
        background: #2ecc71;
        color: white;
        padding: 0.6rem 1.5rem;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .vision-container button:hover {
        background: #27ae60;
    }

    .vision-list ul {
        margin-top: 1rem;
        padding-left: 1.5rem;
    }

    .vision-list li {
        margin-bottom: 0.8rem;
    }

    .vision-list a {
        margin-left: 10px;
        color: #3faabd;
        text-decoration: none;
    }

    .vision-list a:hover {
        text-decoration: underline;
    }

    .alert {
        margin-bottom: 1rem;
        font-weight: bold;
        color: #27ae60;
    }
</style>

<div class="vision-container">
    <h1>VISIÓN</h1>

    <?php if (isset($_SESSION['vision_guardada'])): ?>
        <div class="alert">
            <?= $_SESSION['vision_guardada'] == 'completado' ? '✅ Visión guardada correctamente.' : '❌ Hubo un error al guardar la visión.' ?>
        </div>
        <?php unset($_SESSION['vision_guardada']); ?>
    <?php endif; ?>

    <p><strong>La VISIÓN</strong> de una empresa define lo que la organización quiere lograr en el futuro. Representa aquello que aspira llegar a ser en un periodo de 2 a 3 años.</p>
    <ul>
        <li>Debe ser retadora, positiva, compartida y coherente con la misión.</li>
        <li>Marca el fin último que la estrategia debe seguir.</li>
        <li>Proyecta la imagen de destino que se pretende alcanzar.</li>
    </ul>

    <h2>Ejemplos de Visión</h2>
    <ul>
        <li><strong>Empresa de servicios:</strong> Ser el grupo empresarial de referencia en nuestras áreas de actividad.</li>
        <li><strong>Empresa productora de café:</strong> Queremos ser en el mundo el punto de referencia de la cultura y de la excelencia del café. Una empresa innovadora que propone los mejores productos y lugares de consumo y que, gracias a ello, crece y se convierte en líder de la alta gama.</li>
        <li><strong>Agencia de certificación:</strong> Ser líderes en nuestro sector y un actor principal en todos los segmentos de mercado en los que estamos presentes, en los mercados clave.</li>
    </ul>

    <form action="<?= base_url ?>vision/guardar" method="POST">
        <label for="vision"><strong>Describe la visión de tu empresa:</strong></label>
        <textarea name="vision" placeholder="Escribe aquí la visión de tu empresa..." required></textarea>
        <button type="submit">Agregar Visión</button>
    </form>

    <div class="vision-list">
        <h2>Mis Visiones Registradas</h2>
        <ul>
        <?php while($v = $visiones->fetch_object()): ?>
            <li>
                <?= htmlspecialchars($v->vision) ?>
                <a href="<?= base_url ?>vision/editar&id=<?= $v->id_vision ?>">Editar</a>
                <a href="<?= base_url ?>vision/eliminar&id=<?= $v->id_vision ?>" onclick="return confirm('¿Eliminar visión?')">Eliminar</a>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>
</div>
