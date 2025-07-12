<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Lunch SpA</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

</head>
<header>
  <div class="navbar">
              <div class="logo">
                  <a href="index.php" style="text-decoration:none; color:inherit; display:flex; align-items:center;">
                      <img src="assets/img/logo.png" alt="Logo Family Lunch Spa" class="logo-img">
                      <span style="margin-left:8px;">Family Lunch SpA</span>
                  </a>
              </div>
              <input type="checkbox" id="menu-toggle" class="menu-toggle-checkbox" hidden>
              <label for="menu-toggle" class="menu-toggle" aria-label="Abrir menú">
                  <i class="bi bi-list"></i>
              </label>
              <nav>
                  <a href="index.php#section-menu">Menús</a>
                  <a href="index.php#hero">Reservas</a>
                  <a href="#" id="btnPedidos">Pedidos</a>
  <script>
  // Variable global para saber si el cliente está logueado (usada por pedidos.js)
  window.pedidosClienteLogueado = <?php echo isset($_SESSION['cliente_id']) ? 'true' : 'false'; ?>;
  </script>
  <script src="assets/js/pedidos.js"></script>
                  <a href="index.php#experiencia">Experiencia</a>
                  <a href="./nosotros.php">Nosotros</a>
                  <a href="#" id="abrirModalContacto">Consultas</a>
                  <a href="index.php#contacto">Contacto</a>
              </nav>
              <div class="btns">
                  <button class="btn-orange" id="abrirModalLogin">Administración</button>
                  <a href="clientes/registro.php" class="btn-green" style="text-decoration:none; margin-right:15px;">Clientes</a>
              </div>
  </div>

  <!-- Modal de Contacto -->
  <div id="modalContacto" class="modal-contacto">
    <div class="modal-content-contacto">
      <span class="close-contacto" id="cerrarModalContacto">&times;</span>
      <?php include 'contacto-modal.php'; ?>
    </div>
  </div>

  <!-- Modal de Login de Administración -->
  <div id="modalLogin" class="modal-login" style="display:none;">
    <div class="modal-content-login">
      <span class="close-login" id="cerrarModalLogin">&times;</span>
      <h2>Iniciar Sesión</h2>
      <form method="POST" action="clases/seguridad.php">
        <input type="text" name="username" placeholder="Usuario" required>
        <input type="password" name="password" placeholder="Contraseña" required>
        <!-- CSRF Token opcional -->
        <?php if (session_status() === PHP_SESSION_NONE) session_start();
          if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
          }
        ?>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
        <?php if (isset($_GET['login_error'])): ?>
          <div style="color: red; margin-bottom: 10px;">Usuario o contraseña incorrecta</div>
        <?php endif; ?>
        <button type="submit" class="btn-orange">Ingresar</button>
      </form>
    </div>
  </div>

  <script>
  // Modal Login
  const btnAbrirLogin = document.getElementById('abrirModalLogin');
  const modalLogin = document.getElementById('modalLogin');
  const cerrarLogin = document.getElementById('cerrarModalLogin');

  btnAbrirLogin.addEventListener('click', function() {
    modalLogin.style.display = 'block';
  });
  cerrarLogin.addEventListener('click', function() {
    modalLogin.style.display = 'none';
  });
  window.addEventListener('click', function(event) {
    if (event.target === modalLogin) {
      modalLogin.style.display = 'none';
    }
  });
  // Abrir modal automáticamente si hay error de login
  if (window.location.search.includes('login_error=1')) {
    modalLogin.style.display = 'block';
  }
  </script>
</header>
