<div class="navbar">
            <div class="logo">
                <img src="assets/img/logo.png" alt="Logo Family Lunch Spa" class="logo-img">
                Family Lunch SpA</span>
            </div>
            <input type="checkbox" id="menu-toggle" class="menu-toggle-checkbox" hidden>
            <label for="menu-toggle" class="menu-toggle" aria-label="Abrir menú">
                <i class="bi bi-list"></i>
            </label>
            <nav>
                <a href="index.php#section-menu">Menús</a>
                <a href="index.php#hero">Reservas</a>
                <a href="#">Pedidos</a>
                <a href="index.php#experiencia">Experiencia</a>
                <a href="./nosotros.php">Nosotros</a>
                <a href="#" id="abrirModalContacto">Consultas</a>
                <a href="index.php#contacto">Contacto</a>
            </nav>
            <div class="btns">
                <button class="btn-orange" id="abrirModalLogin">Administración</button>
                <button class="btn-green">Pedir Online</button>
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

<style>
/* Estilos básicos para el modal de login */
.modal-login {
  display: none;
  position: fixed;
  z-index: 1001;
  left: 0;
  top: 0;
  width: 100vw;
  height: 100vh;
  overflow: auto;
  background-color: rgba(0,0,0,0.4);
}
.modal-content-login {
  background: #fff;
  margin: 8% auto;
  padding: 30px 20px 20px 20px;
  border-radius: 8px;
  width: 90%;
  max-width: 350px;
  position: relative;
  box-shadow: 0 2px 10px rgba(0,0,0,0.2);
  text-align: center;
}
.close-login {
  position: absolute;
  right: 15px;
  top: 10px;
  font-size: 28px;
  font-weight: bold;
  color: #333;
  cursor: pointer;
}
.modal-content-login input[type="text"],
.modal-content-login input[type="password"] {
  width: 90%;
  padding: 10px;
  margin: 10px 0;
  border-radius: 5px;
  border: 1px solid #ccc;
}
.modal-content-login button {
  width: 100%;
  padding: 10px;
  border: none;
  border-radius: 5px;
  background: #ff6600;
  color: #fff;
  font-size: 16px;
  cursor: pointer;
  margin-top: 10px;
}
</style>