<?php
// Mostrar todos los mensajes de operaciones al inicio
$alertTypes = [
    'uen_guardada' => ['UEN guardada correctamente', 'Error al guardar la UEN'],
    'objetivo_general_guardado' => ['Objetivo general guardado correctamente', 'Error al guardar el objetivo general'],
    'objetivo_especifico_guardado' => ['Objetivo específico guardado correctamente', 'Error al guardar el objetivo específico'],
    'objetivo_especifico_eliminado' => ['Objetivo específico eliminado correctamente', null]
];

foreach ($alertTypes as $key => $messages) {
    if (isset($_SESSION[$key])) {
        $isSuccess = $_SESSION[$key] == 'completado';
        $message = $isSuccess ? $messages[0] : ($messages[1] ?? '');
        if (!empty($message)) {
            echo "<div class='alert " . ($isSuccess ? 'alert-success' : 'alert-danger') . "'>";
            echo $isSuccess ? '✅ ' : '❌ ';
            echo $message;
            echo "</div>";
        }
        unset($_SESSION[$key]);
    }
}
?>

<style>
    .scrum-board {
        max-width: 1200px;
        margin: 2rem auto;
        font-family: Arial, sans-serif;
    }

    .board-header {
        text-align: center;
        margin-bottom: 2rem;
    }

    .board-header h1 {
        color: #f7af51;
        font-size: 2.5rem;
    }

    .columns-container {
        display: flex;
        gap: 1.5rem;
        overflow-x: auto;
        padding-bottom: 1rem;
    }

    .column {
        flex: 1;
        min-width: 300px;
        background: #f4f4f4;
        border-radius: 10px;
        padding: 1.2rem;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }

    .column-header {
        color: white;
        padding: 0.8rem;
        border-radius: 8px;
        margin-bottom: 1.2rem;
        text-align: center;
        font-weight: bold;
    }

    .column-uen {
        background: #3faabd;
    }

    .column-general {
        background: #2ecc71;
    }

    .card {
        background: white;
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 8px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        position: relative;
    }

    .card-actions {
        position: absolute;
        top: 0.5rem;
        right: 0.5rem;
    }

    .card-actions a {
        color: #7f8c8d;
        margin-left: 0.5rem;
        font-size: 0.9rem;
    }

    .card-actions a:hover {
        color: #34495e;
    }

    .add-form {
        margin-top: 1.5rem;
    }

    .add-form textarea,
    .add-form input[type="text"] {
        width: 100%;
        padding: 0.6rem;
        margin-bottom: 0.8rem;
        border-radius: 6px;
        border: 1px solid #ddd;
    }

    .add-form textarea {
        height: 80px;
        resize: vertical;
    }

    .add-form button {
        background: #3498db;
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 6px;
        cursor: pointer;
        transition: background 0.3s;
    }

    .add-form button:hover {
        background: #2980b9;
    }

    .especifico-item {
        padding: 0.8rem;
        background: #f9f9f9;
        margin-bottom: 0.8rem;
        border-radius: 6px;
        border-left: 3px solid #e74c3c;
    }

    .alert {
        padding: 0.8rem;
        margin-bottom: 1rem;
        border-radius: 8px;
        font-weight: bold;
    }

    .alert-success {
        background-color: #d4edda;
        color: #155724;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    .empty-message {
        color: #7f8c8d;
        text-align: center;
        padding: 1rem;
    }

    @media (max-width: 768px) {
        .columns-container {
            flex-direction: column;
        }
    }
</style>

<div class="scrum-board">
    <div class="board-header">
        <h1>Tablero de Objetivos</h1>
        <p>Visualiza y gestiona todos tus objetivos en un solo lugar</p>
    </div>

    <div class="columns-container">
        <!-- Columna UEN -->
        <div class="column">
            <div class="column-header column-uen">
                Unidades Estratégicas (UEN)
            </div>

            <?php if ($uens && $uens->num_rows > 0): ?>
                <?php while($u = $uens->fetch_object()): ?>
                    <div class="card">
                        <div class="card-actions">
                            <a href="<?= base_url ?>uen/editar&id=<?= $u->id_uen ?>" title="Editar">✏️</a>
                            <a href="<?= base_url ?>uen/eliminar&id=<?= $u->id_uen ?>" onclick="return confirm('¿Eliminar esta UEN?')" title="Eliminar">🗑️</a>
                        </div>
                        <h3><?= htmlspecialchars($u->uen) ?></h3>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-message">No hay UENs registradas</div>
            <?php endif; ?>

            <div class="add-form">
                <form action="<?= base_url ?>uen/guardar" method="POST">
                    <input type="text" name="uen" placeholder="Nueva UEN" required>
                    <button type="submit">+ Agregar UEN</button>
                </form>
            </div>
        </div>

        <!-- Columna Objetivos Generales -->
        <div class="column">
            <div class="column-header column-general">
                Objetivos Generales
            </div>

            <?php if ($objetivosGenerales && $objetivosGenerales->num_rows > 0): ?>
                <?php while($og = $objetivosGenerales->fetch_object()): ?>
                    <div class="card">
                        <div class="card-actions">
                            <a href="<?= base_url ?>objetivoGeneral/editar&id=<?= $og->id_general ?>" title="Editar">✏️</a>
                            <a href="<?= base_url ?>objetivoGeneral/eliminar&id=<?= $og->id_general ?>" onclick="return confirm('¿Eliminar este objetivo y sus específicos?')" title="Eliminar">🗑️</a>
                        </div>
                        <h3><?= htmlspecialchars($og->objetivo) ?></h3>
                        
                        <!-- Mostrar objetivos específicos relacionados -->
                        <?php 
                        $objetivoEspecifico = new ObjetivoEspecifico();
                        $especificos = $objetivoEspecifico->obtenerPorGeneral($og->id_general);
                        ?>
                        
                        <?php if ($especificos && $especificos->num_rows > 0): ?>
                            <div style="margin-top: 1rem;">
                                <h4>Objetivos Específicos:</h4>
                                <?php while($oe = $especificos->fetch_object()): ?>
                                    <div class="especifico-item">
                                        <div><?= htmlspecialchars($oe->objetivo) ?></div>
                                        <div style="text-align: right; margin-top: 0.5rem;">
                                            <a href="<?= base_url ?>objetivoEspecifico/editar&id=<?= $oe->id_especifico ?>&id_general=<?= $og->id_general ?>" title="Editar">✏️</a>
                                            <a href="<?= base_url ?>objetivoEspecifico/eliminar&id=<?= $oe->id_especifico ?>&id_general=<?= $og->id_general ?>" onclick="return confirm('¿Eliminar este objetivo específico?')" title="Eliminar">🗑️</a>
                                        </div>
                                    </div>
                                <?php endwhile; ?>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Formulario para agregar objetivo específico -->
                        <div class="add-form" style="margin-top: 1rem;">
                            <form action="<?= base_url ?>objetivoEspecifico/guardar" method="POST">
                                <input type="hidden" name="id_general" value="<?= $og->id_general ?>">
                                <textarea name="objetivo" placeholder="Nuevo objetivo específico para este objetivo general" required></textarea>
                                <button type="submit">+ Agregar Específico</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="empty-message">No hay objetivos generales</div>
            <?php endif; ?>

            <div class="add-form">
                <form action="<?= base_url ?>objetivoGeneral/guardar" method="POST">
                    <textarea name="objetivo" placeholder="Nuevo objetivo general" required></textarea>
                    <button type="submit">+ Agregar Objetivo General</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    // Función para hacer las tarjetas arrastrables (opcional)
    document.addEventListener('DOMContentLoaded', function() {
        const cards = document.querySelectorAll('.card');
        
        cards.forEach(card => {
            card.draggable = true;
            
            card.addEventListener('dragstart', () => {
                card.classList.add('dragging');
            });
            
            card.addEventListener('dragend', () => {
                card.classList.remove('dragging');
            });
        });
    });
</script>