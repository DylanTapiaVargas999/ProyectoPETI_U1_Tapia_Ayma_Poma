<style>
    .valor-container {
        max-width: 800px;
        margin: 2rem auto;
        padding: 2rem;
        background: #f4f4f4;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        font-family: Arial, sans-serif;
        color: #333;
    }

    .valor-container h1 {
        color: #f7af51;
        font-size: 2.5rem;
        margin-bottom: 0.5rem;
        text-align: center;
    }

    .valor-container textarea {
        width: 100%;
        height: 80px;
        padding: 0.5rem;
        font-size: 1rem;
        margin-top: 1rem;
        border-radius: 10px;
        border: 1px solid #ccc;
        resize: vertical;
    }

    .valor-container button {
        margin-top: 1rem;
        background: #2ecc71;
        color: white;
        padding: 0.6rem 1.5rem;
        border: none;
        border-radius: 10px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .valor-container button:hover {
        background: #27ae60;
    }

    .valor-list ul {
        margin-top: 1rem;
        padding-left: 1.5rem;
    }

    .valor-list li {
        margin-bottom: 0.8rem;
    }

    .valor-list a {
        margin-left: 10px;
        color: #3faabd;
        text-decoration: none;
    }

    .valor-list a:hover {
        text-decoration: underline;
    }

    .alert {
        margin-bottom: 1rem;
        font-weight: bold;
        color: #27ae60;
    }

    .valor-description {
        margin-top: 1.5rem;
    }

    .valor-examples {
        margin-top: 1rem;
        padding-left: 1.5rem;
    }
</style>

<div class="valor-container">
    <h1>VALORES</h1>

    <?php if (isset($_SESSION['valor_guardado'])): ?>
        <div class="alert">
            <?= $_SESSION['valor_guardado'] == 'completado' ? '✅ Valor guardado correctamente.' : '❌ Hubo un error al guardar el valor.' ?>
        </div>
        <?php unset($_SESSION['valor_guardado']); ?>
    <?php endif; ?>

    <p><strong>Los VALORES</strong> de una empresa son el conjunto de principios, reglas y aspectos culturales con los que se rige la organización. Son las pautas de comportamiento de la empresa y generalmente son pocos, entre 3 y 6. Son tan fundamentales y tan arraigados que casi nunca cambian.</p>

    <div class="valor-description">
        <h3>Ejemplos de Valores</h3>
        <ul class="valor-examples">
            <li>Integridad</li>
            <li>Compromiso con el desarrollo humano</li>
            <li>Ética profesional</li>
            <li>Responsabilidad social</li>
            <li>Innovación</li>
            <li>Etc.</li>
        </ul>
    </div>

    <div class="valor-description">
        <h3>EJEMPLOS DE VALORES SEGÚN TIPO DE EMPRESA</h3>
        <ul class="valor-examples">
            <li><strong>Empresa de servicios</strong></li>
            <ul>
                <li>La excelencia en la prestación de servicios</li>
                <li>La innovación orientada a la mejora continua de procesos, productos y servicios.</li>
                <li>La promoción del diálogo y compromiso con los grupos de interés.</li>
            </ul>
            <li><strong>Empresa productora de café</strong></li>
            <ul>
                <li>Nuestro valor es la búsqueda de la perfección, entendida como amor por lo bello y bien hecho, y la ética, entendida como construcción de valor en el tiempo a través de la sostenibilidad, la transparencia, y la valorización de las personas.</li>
            </ul>
            <li><strong>Agencia de certificación</strong></li>
            <ul>
                <li>Integridad y ética</li>
                <li>Consejo y validación imparciales</li>
                <li>Respeto por todas las personas</li>
                <li>Responsabilidad social y medioambiental</li>
            </ul>
        </ul>
    </div>

    <form action="<?= base_url ?>valor/guardar" method="POST">
        <label for="valor"><strong>Describe un valor de tu empresa:</strong></label>
        <textarea name="valor" placeholder="Escribe aquí un valor representativo..." required></textarea>
        <button type="submit">Agregar Valor</button>
    </form>

    <div class="valor-list">
        <h2>Mis Valores Registrados</h2>
        <ul>
        <?php while($v = $valores->fetch_object()): ?>
            <li>
                <?= htmlspecialchars($v->valor) ?>
                <a href="<?= base_url ?>valor/editar&id=<?= $v->id_valor ?>">Editar</a>
                <a href="<?= base_url ?>valor/eliminar&id=<?= $v->id_valor ?>" onclick="return confirm('¿Eliminar valor?')">Eliminar</a>
            </li>
        <?php endwhile; ?>
        </ul>
    </div>
</div>
