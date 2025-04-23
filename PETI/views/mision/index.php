<style>
    .mision-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background: #f4f4f4;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
        color: #333;
    }

    .mision-container h1 {
        color: #f7af51;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .mision-container h2 {
        margin-top: 2rem;
        color: #3faabd;
    }

    .mision-container p, .mision-container li {
        line-height: 1.6;
    }

    .mision-container ul {
        padding-left: 1.5rem;
    }

    .mision-container textarea {
        width: 100%;
        height: 100px;
        padding: 0.5rem;
        font-size: 1rem;
        margin-top: 1rem;
        border-radius: 10px;
        border: 1px solid #ccc;
        resize: vertical;
    }

    .mision-container button {
        margin-top: 1rem;
        background: #2ecc71;
        color: white;
        padding: 0.6rem 1.5rem;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .mision-container button:hover {
        background: #27ae60;
    }

    .mision-list {
        margin-top: 2rem;
    }

    .mision-list li {
        margin-bottom: 0.8rem;
    }

    .mision-list a {
        margin-left: 10px;
        color: #3faabd;
        text-decoration: none;
    }

    .mision-list a:hover {
        text-decoration: underline;
    }

    .alert {
        margin-bottom: 1rem;
        font-weight: bold;
        color: #27ae60;
    }
</style>

<div class="mision-container">
    <h1>MISIÓN</h1>

    <?php if (isset($_SESSION['mision_guardada'])): ?>
        <div class="alert">
            <?= $_SESSION['mision_guardada'] == 'completado' ? '✅ Misión guardada correctamente.' : '❌ Hubo un error al guardar la misión.' ?>
        </div>
        <?php unset($_SESSION['mision_guardada']); ?>
    <?php endif; ?>

    <p><strong>La MISIÓN</strong> es la razón de ser de la empresa u organización. Describe la actividad y propósito fundamental en el mercado.</p>
    <ul>
        <li>Debe ser clara, concisa y compartida.</li>
        <li>Siempre orientada hacia el cliente, no solo al producto o servicio.</li>
        <li>Refleja el propósito fundamental de la empresa en el mercado.</li>
    </ul>
    <p>En términos generales, describe la actividad y razón de ser de la organización y contribuye como una referencia permanente en el proceso de planificación estratégica.</p>
    <p>Se expresa en una oración que define qué hace la empresa, por qué y para quién lo hace.</p>

    <h2>Ejemplos de misión</h2>
    <ul>
        <li><strong>Empresa de servicios:</strong> La gestión de servicios que contribuyen a la calidad de vida de las personas y generan valor para los grupos de interés.</li>
        <li><strong>Productora de café:</strong> Gracias a nuestro entusiamo, trabajo en equipo y valores, queremos deleitar a todos aquellos que, en el mundo aman la calidad de vida, a través del mejor café que la naturaleza pueda ofrecer, ensalzado por las mejores tecnologías, por la emoción y la imlicación intelectual que nacen de la búsqueda de lo bello en todo lo que hacemos.</li>
        <li><strong>Agencia de certificación:</strong> Dar a nuestros clientes avlro económico a través de la gestión de la Calidad, la Salud y la Seguridad, el Medio Ambiente y la Responsabildad Social de sus activos, proyectos, productos y sistemas, obteniendo como resultado la capacidad para lograr la reducción de riesgos y la mejora de los resultados.</li>
    </ul>

    <form action="<?= base_url ?>mision/guardar" method="POST">
        <label for="mision"><strong>Describe la misión de tu empresa:</strong></label>
        <textarea name="mision" placeholder="Escribe aquí la misión de tu empresa..." required></textarea>
        <button type="submit">Agregar Misión</button>
    </form>

    <div class="mision-list">
        <h2>Mis Misiones Registradas</h2>
        <ul>
        <?php while($m = $misiones->fetch_object()): ?>
            <li>
                <?= htmlspecialchars($m->mision) ?>
                <a href="<?= base_url ?>mision/editar&id=<?= $m->id_mision ?>">Editar</a>
                <a href="<?= base_url ?>mision/eliminar&id=<?= $m->id_mision ?>" onclick="return confirm('¿Eliminar misión?')">Eliminar</a>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>
</div>
