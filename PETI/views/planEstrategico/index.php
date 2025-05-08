<h2>Planes Estratégicos</h2>
<a href="<?= base_url ?>planEstrategico/crear" class="btn btn-primary mb-3">Nuevo Plan</a>

<table class="table table-striped">
  <thead>
    <tr>
      <th>ID</th>
      <th>Código</th>
      <th>Título</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php while ($row = $planes->fetch_object()): ?>
    <tr>
      <td><?= $row->id ?></td>
      <td><?= $row->codigo ?></td>
      <td><?= $row->titulo ?></td>
      <td>
        <a href="<?= base_url ?>planEstrategico/editar&id=<?= $row->id ?>" class="btn btn-sm btn-warning">Editar</a>
        <a href="<?= base_url ?>planEstrategico/eliminar&id=<?= $row->id ?>" class="btn btn-sm btn-danger">Eliminar</a>
      </td>
    </tr>
    <?php endwhile; ?>
  </tbody>
</table>
