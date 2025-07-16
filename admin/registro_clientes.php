<?php
// Verificamos la sesión
session_start();
if (!isset($_SESSION['u_id'])) {
    header('Location: ../index.php');
    exit;
}

require_once '../clases/config.php';
require_once '../clases/db.php';

// Consulta para obtener los clientes registrados
$sql = "SELECT rc_id, rc_nombre, rc_rut, rc_direccion, rc_correo, rc_created_at FROM registro_clientes ORDER BY rc_created_at DESC";
// Crear instancia de la clase db con parámetros de conexión
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$result = $db->query($sql);
$clientes = $result->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Clientes | Family Lunch SpA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <a href="opciones.php" class="btn-back" title="Volver a opciones">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h1 class="admin-title" style="display:inline;">
            <i class="bi bi-person-lines-fill"></i> Registro de Clientes
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
            <h2 class="usuarios-header-title">Listado de Clientes Registrados</h2>
            
            <?php if (isset($_GET['success']) && $_GET['success'] == 'deleted'): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> 
                    Cliente "<?php echo htmlspecialchars($_GET['nombre'] ?? 'Desconocido'); ?>" eliminado exitosamente.
                </div>
            <?php endif; ?>
            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <i class="bi bi-exclamation-triangle"></i> 
                    <?php 
                    switch($_GET['error']) {
                        case 'no-id':
                            echo 'Error: ID de cliente no especificado.';
                            break;
                        case 'not-found':
                            echo 'Error: Cliente no encontrado.';
                            break;
                        case 'delete-failed':
                            echo 'Error: No se pudo eliminar el cliente.';
                            break;
                        default:
                            echo 'Error desconocido.';
                    }
                    ?>
                </div>
            <?php endif; ?>
            
            <div class="clientes-stats">
                <span class="stats-badge">
                    <i class="bi bi-people"></i> Total de clientes: <?php echo count($clientes); ?>
                </span>
            </div>
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th class="col-nombre">Nombre</th>
                        <th>RUT</th>
                        <th>Dirección</th>
                        <th>Correo</th>
                        <th class="col-fecha">Fecha Registro</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($clientes)): ?>
                        <?php foreach($clientes as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['rc_id']); ?></td>
                                <td class="col-nombre"><?php echo htmlspecialchars($row['rc_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['rc_rut']); ?></td>
                                <td><?php echo htmlspecialchars($row['rc_direccion']); ?></td>
                                <td><?php echo htmlspecialchars($row['rc_correo']); ?></td>
                                <td class="col-fecha"><?php echo htmlspecialchars($row['rc_created_at']); ?></td>
                                <td>
                                    <a href="eliminar_cliente.php?id=<?php echo $row['rc_id']; ?>" class="btn-eliminar-usuario" title="Eliminar"
                                       onclick="return confirm('¿Estás seguro de que deseas eliminar este cliente?\n\nCliente: <?php echo htmlspecialchars($row['rc_nombre']); ?>\nCorreo: <?php echo htmlspecialchars($row['rc_correo']); ?>');"> 
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="no-data">No hay clientes registrados.</td></tr>
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