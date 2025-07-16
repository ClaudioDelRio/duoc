<?php
// Verificamos la sesión
session_start();
if (!isset($_SESSION['u_id'])) {
    header('Location: ../index.php');
    exit;
}

require_once '../clases/config.php';
require_once '../clases/db.php';

if (!isset($_GET['id'])) {
    header('Location: lista_pedidos.php');
    exit;
}

$pedido_id = intval($_GET['id']);
$db = new db($dbhost, $dbuser, $dbpass, $dbname);

// Obtener información del pedido
$pedido_query = "SELECT p.*, rc.rc_nombre, rc.rc_correo, rc.rc_direccion, rc.rc_rut
                 FROM pedidos p 
                 INNER JOIN registro_clientes rc ON p.p_rc_id = rc.rc_id 
                 WHERE p.p_id = ?";
$pedido_result = $db->query($pedido_query, [$pedido_id]);
$pedidos = $pedido_result->fetchAll();

if (empty($pedidos)) {
    header('Location: lista_pedidos.php?error=not-found');
    exit;
}

$pedido = $pedidos[0];

// Obtener detalles del pedido
$detalle_query = "SELECT pd.*, m.me_menu, m.me_valor
                  FROM pedidos_detalle pd
                  INNER JOIN menus m ON pd.pd_me_id = m.me_id
                  WHERE pd.pd_p_id = ?";
$detalle_result = $db->query($detalle_query, [$pedido_id]);
$detalles = $detalle_result->fetchAll();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Pedido #<?php echo $pedido['p_id']; ?> | Family Lunch SpA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body class="admin-body">
    <header class="admin-header">
        <a href="lista_pedidos.php" class="btn-back" title="Volver a lista de pedidos">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h1 class="admin-title" style="display:inline;">
            <i class="bi bi-receipt"></i> Detalle del Pedido #<?php echo $pedido['p_id']; ?>
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
            <div class="pedido-info-card">
                <h2>Información del Cliente</h2>
                <div class="info-grid">
                    <div class="info-item">
                        <strong>Nombre:</strong> <?php echo htmlspecialchars($pedido['rc_nombre']); ?>
                    </div>
                    <div class="info-item">
                        <strong>RUT:</strong> <?php echo htmlspecialchars($pedido['rc_rut']); ?>
                    </div>
                    <div class="info-item">
                        <strong>Correo:</strong> <?php echo htmlspecialchars($pedido['rc_correo']); ?>
                    </div>
                    <div class="info-item">
                        <strong>Dirección:</strong> <?php echo htmlspecialchars($pedido['rc_direccion']); ?>
                    </div>
                    <div class="info-item">
                        <strong>Fecha del Pedido:</strong> <?php echo date('d/m/Y H:i:s', strtotime($pedido['p_created_at'])); ?>
                    </div>
                    <div class="info-item">
                        <strong>Estado:</strong> 
                        <?php if ($pedido['p_despachado']): ?>
                            <span class="estado-despachado">
                                <i class="bi bi-check-circle-fill"></i> Despachado
                            </span>
                        <?php else: ?>
                            <span class="estado-pendiente">
                                <i class="bi bi-clock-fill"></i> Pendiente
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <div class="pedido-detalle-card">
                <h2>Detalle del Pedido</h2>
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Menú</th>
                            <th>Cantidad</th>
                            <th>Precio Unitario</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                        $total_calculado = 0;
                        foreach($detalles as $detalle): 
                            $subtotal = $detalle['me_valor'] * $detalle['pd_cantidad'];
                            $total_calculado += $subtotal;
                        ?>
                            <tr>
                                <td><?php echo htmlspecialchars($detalle['me_menu']); ?></td>
                                <td><?php echo htmlspecialchars($detalle['pd_cantidad']); ?></td>
                                <td>$<?php echo number_format($detalle['me_valor'], 0, ',', '.'); ?></td>
                                <td>$<?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="total-row">
                            <td colspan="3" style="text-align: right; font-weight: bold;">Total del Pedido:</td>
                            <td style="font-weight: bold; color: #ff6600;">$<?php echo number_format($pedido['p_total'], 0, ',', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <div class="acciones-pedido">
                <?php if (!$pedido['p_despachado']): ?>
                    <a href="cambiar_estado_pedido.php?id=<?php echo $pedido['p_id']; ?>&estado=1" class="btn-orange"
                       onclick="return confirm('¿Marcar este pedido como despachado?');">
                        <i class="bi bi-truck"></i> Marcar como Despachado
                    </a>
                <?php else: ?>
                    <a href="cambiar_estado_pedido.php?id=<?php echo $pedido['p_id']; ?>&estado=0" class="btn-orange"
                       onclick="return confirm('¿Marcar este pedido como pendiente?');">
                        <i class="bi bi-arrow-counterclockwise"></i> Marcar como Pendiente
                    </a>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <footer class="admin-footer">
        &copy; <?php echo date('Y'); ?> Family Lunch SpA | Panel de Administración
    </footer>
    
    <style>
    .pedido-info-card, .pedido-detalle-card {
        background: white;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 20px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    
    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }
    
    .info-item {
        padding: 10px;
        background: #f8f9fa;
        border-radius: 5px;
    }
    
    .estado-despachado {
        color: #28a745;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .estado-pendiente {
        color: #ffc107;
        font-weight: bold;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    
    .total-row {
        background: #f8f9fa;
        font-size: 1.1em;
    }
    
    .acciones-pedido {
        text-align: center;
        margin-top: 20px;
    }
    
    @media (max-width: 768px) {
        .info-grid {
            grid-template-columns: 1fr;
        }
    }
    </style>
</body>
</html>