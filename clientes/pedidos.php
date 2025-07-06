<?php
// pedidos.php - Formulario para que el cliente realice un pedido
session_start();
if (!isset($_SESSION['cliente_id'])) {
    header('Location: registro.php');
    exit;
}
require_once '../clases/config.php';
require_once '../clases/db.php';

// Conexión igual que en otros archivos de clientes
$db = new db($dbhost, $dbuser, $dbpass, $dbname, 'utf8');

// Obtener menús disponibles (usando los nombres de columna correctos)
$menus = [];
try {
    $menus = $db->query('SELECT me_id, me_menu, me_valor FROM menus')->fetchAll();
} catch (Exception $e) {
    $menus = [];
}
// Obtener mesas disponibles
$mesas = [];
try {
    $mesas = $db->query('SELECT m_id, m_numero_mesa, m_numero_comenzales FROM mesas')->fetchAll();
} catch (Exception $e) {
    $mesas = [];
}


$mensaje = '';
if (isset($_SESSION['pedido_mensaje'])) {
    $mensaje = $_SESSION['pedido_mensaje'];
    unset($_SESSION['pedido_mensaje']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Pedido | Family Lunch SpA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="registro-container">
        <div class="registro-titulo">Pedidos de <?php echo htmlspecialchars($_SESSION['cliente_nombre']); ?></div>
        <?php if ($mensaje): ?>
            <div class="registro-mensaje"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <form class="registro-form" method="POST" action="procesar_pedido.php" autocomplete="off" style="margin-bottom:30px;">
            <table class="admin-table">
                <thead>
                    <tr>
                        <th>Menú</th>
                        <th>Cantidad</th>
                        <th>Agregar</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="menu" id="menu" required>
                                <option value="">-- Selecciona --</option>
                                <?php foreach ($menus as $menu): ?>
                                    <option value="<?php echo $menu['me_id']; ?>">
                                        <?php echo htmlspecialchars($menu['me_menu']) . ' ($' . number_format($menu['me_valor'], 0, ',', '.') . ')'; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </td>
                        <td>
                            <input type="number" name="cantidad" id="cantidad" min="1" value="1" required style="width:70px;">
                        </td>
                        <td>
                            <button type="submit" class="btn-orange">Agregar Pedido</button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>

        <!-- Aquí se mostrarán los pedidos realizados por el cliente -->
        <h3 style="margin-top:30px;">Historial de Pedidos</h3>
        <table class="admin-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Menú</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar historial de pedidos del cliente
                $pedidos = [];
                try {
                    $sql = "SELECT p.p_id, m.me_menu, p.p_cantidad, p.p_total, p.p_created_at FROM pedidos p JOIN menus m ON p.p_me_id = m.me_id WHERE p.p_rc_id = ? ORDER BY p.p_created_at DESC";
                    $pedidos = $db->query($sql, [$_SESSION['cliente_id']])->fetchAll();
                } catch (Exception $e) {
                    $pedidos = [];
                }
                if (!empty($pedidos)):
                    foreach ($pedidos as $i => $row): ?>
                        <tr>
                            <td><?php echo $i+1; ?></td>
                            <td><?php echo htmlspecialchars($row['me_menu']); ?></td>
                            <td><?php echo htmlspecialchars($row['p_cantidad']); ?></td>
                            <td>$<?php echo number_format($row['p_total'], 0, ',', '.'); ?></td>
                            <td><?php echo htmlspecialchars($row['p_created_at']); ?></td>
                        </tr>
                    <?php endforeach;
                else: ?>
                    <tr><td colspan="5">No hay pedidos registrados.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="registro-switch">
            <a href="../index.php" class="switch-link">Volver al inicio</a>
        </div>
    </div>
</body>
</html>
