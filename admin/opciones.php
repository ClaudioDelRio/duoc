<?php
// Verificamos la sesión
session_start();
if (!isset($_SESSION['u_id'])) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración | Family Lunch SpA</title>
    <!-- Estilos personalizados -->
    <link rel="stylesheet" href="../assets/css/style.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <header class="admin-header">
        <h1 class="admin-title">
            <i class="bi bi-gear-fill"></i> Administración Family Lunch SpA
        </h1>
        <div class="admin-user-bar">
            <span class="admin-user-welcome">
                <i class="bi bi-person-circle"></i> Bienvenido,
            </span>
            <span class="admin-user-name">
                <?php echo isset($_SESSION['u_nombre']) ? htmlspecialchars($_SESSION['u_nombre']) : 'Usuario'; ?>
            </span>
            <button onclick="window.location.href='../clases/cerrar_sesion.php'" class="btn-orange admin-logout-btn">
                <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
            </button>
        </div>
    </header>
   
    <main>
        <section>
            <div class="admin-cards">
                <div class="admin-card" onclick="window.location.href='usuarios.php'" style="cursor:pointer;">
                    <i class="bi bi-people-fill"></i>
                    <h3>Gestión de Usuarios</h3>
                    <div class="proximamente" style="color: #ff6600; font-weight: bold;">Ir a gestión</div>
                </div>
                <div class="admin-card">
                    <i class="bi bi-journal-text"></i>
                    <h3>Gestión de Pedidos</h3>
                    <div class="proximamente">Próximamente</div>
                </div>
                <div class="admin-card">
                    <i class="bi bi-cash-coin"></i>
                    <h3>Gestión de Pagos</h3>
                    <div class="proximamente">Próximamente</div>
                </div>
                
                <div class="admin-card">
                    <i class="bi bi-person-lines-fill"></i>
                    <h3>Registro de Clientes</h3>
                    <div class="proximamente">Próximamente</div>
                </div>
            </div>
        </section>
    </main>
    <footer class="admin-footer">
        &copy; <?php echo date('Y'); ?> Family Lunch SpA | Panel de Administración
    </footer>
</body>
</html>