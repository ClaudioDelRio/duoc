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
                <button class="btn-orange">Reservar Mesa</button>
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