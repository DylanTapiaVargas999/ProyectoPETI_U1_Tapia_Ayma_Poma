<h2>Nuevo Plan Estratégico</h2>
<form action="<?= base_url ?>planEstrategico/guardar" method="POST">
  <div class="mb-3">
    <label for="titulo" class="form-label">Título</label>
    <input type="text" name="titulo" class="form-control" required>
  </div>
  <button type="submit" class="btn btn-success">Guardar</button>
</form>
