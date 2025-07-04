<?php
// Verificamos la sesión
session_start();
if (!isset($_SESSION['u_id'])) {
    header('Location: ../index.php');
    exit;
}

require_once '../clases/config.php';
require_once '../clases/db.php';

// Consulta para obtener los menús
$sql = "SELECT me_id, me_menu, me_mas_vendido, me_infantil, me_especialidad, me_resena, me_valor, me_imagen FROM menus";
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$result = $db->query($sql);
$menus = $result->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Menús | Family Lunch SpA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <h1 class="admin-title">
            <i class="bi bi-list-ul"></i> Gestión de Menús
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
    <main class="main_usuarios">
        <section class="usuarios-header-section">
            <h2 class="usuarios-header-title">Listado de Menús</h2>
            <a href="insertar_menu.php" class="btn-orange btn-insertar-usuario">Insertar Menú</a>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Nombre Menú</th>
                        <th>Más Vendido</th>
                        <th>Infantil</th>
                        <th>Especialidad</th>
                        <th>Reseña</th>
                        <th>Valor</th>
                        <th>Imagen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($menus)): ?>
                        <?php foreach($menus as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['me_menu']); ?></td>
                                <td><?php echo $row['me_mas_vendido'] ? 'Sí' : 'No'; ?></td>
                                <td><?php echo $row['me_infantil'] ? 'Sí' : 'No'; ?></td>
                                <td><?php echo $row['me_especialidad'] ? 'Sí' : 'No'; ?></td>
                                <td><?php echo htmlspecialchars($row['me_resena']); ?></td>
                                <td>$<?php echo number_format($row['me_valor'], 0, ',', '.'); ?></td>
                                <td>
                                    <?php if ($row['me_imagen']): ?>
                                        <img src="../<?php echo htmlspecialchars($row['me_imagen']); ?>" alt="Imagen menú" style="height:40px; border-radius:4px;">
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="editar_menu.php?id=<?php echo $row['me_id']; ?>" class="btn-editar-usuario" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="eliminar_menu.php?id=<?php echo $row['me_id']; ?>" class="btn-eliminar-usuario" title="Eliminar"
                                       onclick="return confirm('¿Estás seguro de que deseas eliminar este menú?');">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8">No hay menús registrados.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </section>
    </main>
    <footer class="admin-footer">
        &copy; <?php echo date('Y'); ?> Family Lunch SpA | Panel de Administración
    </footer>
</body>
</html>