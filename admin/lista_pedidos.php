<?php
// Verificamos la sesión
session_start();
if (!isset($_SESSION['u_id'])) {
    header('Location: ../index.php');
    exit;
}

require_once '../clases/config.php';
require_once '../clases/db.php';

// Consulta para obtener los pedidos con información del cliente
$sql = "SELECT p.p_id, p.p_rc_id, p.p_total, p.p_created_at, p.p_despachado,
               rc.rc_nombre, rc.rc_correo, rc.rc_direccion
        FROM pedidos p 
        INNER JOIN registro_clientes rc ON p.p_rc_id = rc.rc_id 
        ORDER BY p.p_created_at DESC";

// Crear instancia de la clase db con parámetros de conexión
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$result = $db->query($sql);
$pedidos = $result->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Pedidos | Family Lunch SpA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <a href="opciones.php" class="btn-back" title="Volver a opciones">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h1 class="admin-title" style="display:inline;">
            <i class="bi bi-journal-text"></i> Lista de Pedidos
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
            <h2 class="usuarios-header-title">Listado de Pedidos Realizados</h2>
            
            <?php if (isset($_GET['success']) && $_GET['success'] == 'updated'): ?>
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> 
                    Estado del pedido actualizado exitosamente.
                </div>
            <?php endif; ?>
            
            <div class="pedidos-stats">
                <span class="stats-badge">
                    <i class="bi bi-cart-check"></i> Total de pedidos: <?php echo count($pedidos); ?>
                </span>
                <span class="stats-badge stats-despachados">
                    <i class="bi bi-truck"></i> Despachados: 
                    <?php 
                    $despachados = array_filter($pedidos, function($p) { return $p['p_despachado'] == 1; });
                    echo count($despachados); 
                    ?>
                </span>
                <span class="stats-badge stats-pendientes">
                    <i class="bi bi-clock"></i> Pendientes: 
                    <?php 
                    $pendientes = array_filter($pedidos, function($p) { return $p['p_despachado'] == 0; });
                    echo count($pendientes); 
                    ?>
                </span>
            </div>
            
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th class="col-nombre">Cliente</th>
                        <th>Correo</th>
                        <th>Dirección</th>
                        <th>Total</th>
                        <th class="col-fecha">Fecha Pedido</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pedidos)): ?>
                        <?php foreach($pedidos as $row): ?>
                            <tr class="<?php echo $row['p_despachado'] ? 'pedido-despachado' : 'pedido-pendiente'; ?>">
                                <td><?php echo htmlspecialchars($row['p_id']); ?></td>
                                <td class="col-nombre"><?php echo htmlspecialchars($row['rc_nombre']); ?></td>
                                <td><?php echo htmlspecialchars($row['rc_correo']); ?></td>
                                <td><?php echo htmlspecialchars($row['rc_direccion']); ?></td>
                                <td class="precio-total">$<?php echo number_format($row['p_total'], 0, ',', '.'); ?></td>
                                <td class="col-fecha"><?php echo date('d/m/Y H:i', strtotime($row['p_created_at'])); ?></td>
                                <td>
                                    <?php if ($row['p_despachado']): ?>
                                        <span class="estado-despachado">
                                            <i class="bi bi-check-circle-fill"></i> Despachado
                                        </span>
                                    <?php else: ?>
                                        <span class="estado-pendiente">
                                            <i class="bi bi-clock-fill"></i> Pendiente
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="ver_detalle_pedido.php?id=<?php echo $row['p_id']; ?>" class="btn-ver-detalle" title="Ver detalle">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <?php if (!$row['p_despachado']): ?>
                                        <a href="cambiar_estado_pedido.php?id=<?php echo $row['p_id']; ?>&estado=1" class="btn-marcar-despachado" title="Marcar como despachado"
                                           onclick="return confirm('¿Marcar este pedido como despachado?');"> 
                                            <i class="bi bi-truck"></i>
                                        </a>
                                    <?php else: ?>
                                        <a href="cambiar_estado_pedido.php?id=<?php echo $row['p_id']; ?>&estado=0" class="btn-marcar-pendiente" title="Marcar como pendiente"
                                           onclick="return confirm('¿Marcar este pedido como pendiente?');"> 
                                            <i class="bi bi-arrow-counterclockwise"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="no-data">No hay pedidos registrados.</td></tr>
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