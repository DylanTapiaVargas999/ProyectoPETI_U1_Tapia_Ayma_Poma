<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mijo Store</title>
  <!-- Bootstrap y Estilos -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?=base_url?>assets/css/style.css">
</head>
<body>
  <div class="parent">
    <?php require_once 'lateral.php'; ?>

    <!-- Contenido dinámico -->
    <div class="main-content">
      <?= isset($contenido) ? $contenido : "<h1>Bienvenido a Mijo Store</h1>" ?>
      
    </div>
  </div>

  <!-- Scripts -->
  <script>
    // Eliminamos las funciones de modal ya que no las necesitamos
    // Podemos mantener otros scripts necesarios para la aplicación
  </script>
</body>
</html>