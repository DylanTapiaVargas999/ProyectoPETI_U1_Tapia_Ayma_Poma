<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PETI - Estrategia Corporativa</title>
  
  <!-- Bootstrap PRIMERO -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
  
  <!-- TU CSS DEL SIDEBAR DESPUÉS -->
  <link rel="stylesheet" href="<?=base_url?>assets/css/layout/lateral.css">
  <link rel="stylesheet" href="<?=base_url?>assets/css/style.css">
  
  <!-- Chart.js para BCG -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>
</head>
<body>
  <div class="parent">
    <?php require_once 'lateral.php'; ?>

    <!-- Contenido dinámico CON MARGEN PARA EL SIDEBAR -->
    <div class="main-content" style="margin-left: 280px; padding: 20px;">
      <?= isset($contenido) ? $contenido : "<h1>Bienvenido a PETI</h1>" ?>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
  
  <!-- Tu JS del sidebar -->
  <script src="<?=base_url?>assets/css/layout/lateral.js"></script>
</body>
</html>