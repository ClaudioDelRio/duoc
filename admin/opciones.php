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
        <h1><i class="bi bi-gear-fill"></i> Administración Family Lunch SpA</h1>
    </header>
    <div class="admin-user-info">
        Bienvenido, <?php echo isset($_SESSION['u_nombre']) ? htmlspecialchars($_SESSION['u_nombre']) : 'Usuario'; ?> |
        <a href="../clases/logout.php" style="color:#ee6926;text-decoration:none;font-weight:bold;">Cerrar Sesión <i class="bi bi-box-arrow-right"></i></a>
    </div>
    <main>
        <section>
            <div class="admin-cards">
                <div class="admin-card">
                    <i class="bi bi-people-fill"></i>
                    <h3>Gestión de Usuarios</h3>
                    <div class="proximamente">Próximamente</div>
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
                    <i class="bi bi-bar-chart-line"></i>
                    <h3>Reportes y Estadísticas</h3>
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