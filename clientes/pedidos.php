<?php
// pedidos.php - Formulario para que el cliente realice un pedido
session_start();
if (!isset($_SESSION['cliente_id'])) {
    header('Location: registro.php');
    exit;
}
require_once '../clases/config.php';
require_once '../clases/db.php';

// Conexión clientes
$db = new db($dbhost, $dbuser, $dbpass, $dbname, 'utf8');

// Obtener menús disponibles 
$menus = [];
try {
    $menus = $db->query('SELECT me_id, me_menu, me_valor FROM menus')->fetchAll();
} catch (Exception $e) {
    $menus = [];
}

// (Pedidos a domicilio:


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
    <div class="pedido-container">
        <div class="pedido-titulo">Nuevo Pedido - Cliente: <?php echo htmlspecialchars($_SESSION['cliente_nombre']); ?></div>
        <?php if ($mensaje): ?>
            <div class="registro-mensaje"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <form class="pedido-form" method="POST" action="pedidos.php" autocomplete="off">
            <h3 class="pedido-form-title">Agregar Detalle al Pedido</h3>
            <div class="pedido-form-row">
                <div class="pedido-form-menu">
                    <label for="menu">Menú</label><br>
                    <select name="menu" id="menu" class="pedido-select-menu" required>
                        <option value="">-- Selecciona --</option>
                        <?php foreach ($menus as $menu): ?>
                            <option value="<?php echo $menu['me_id']; ?>">
                                <?php echo htmlspecialchars($menu['me_menu']) . ' ($' . number_format($menu['me_valor'], 0, ',', '.') . ')'; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="pedido-form-cantidad">
                    <label for="cantidad">Cantidad</label><br>
                    <input type="number" name="cantidad" id="cantidad" min="1" value="1" required class="pedido-input-cantidad">
                </div>
                <div class="pedido-form-btn">
                    <button type="submit" class="btn-orange pedido-btn-agregar">Agregar al Pedido</button>
                </div>
            </div>
        </form>

        <!-- Detalle del pedido actual (en sesión, antes de guardar en la base de datos) -->
        <h3 class="pedido-detalle-title">Detalle del Pedido en Curso</h3>
        <table class="admin-table pedido-detalle-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Menú</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Mostrar detalle del pedido en curso (guardado en $_SESSION['pedido_detalle'])
                if (!isset($_SESSION['pedido_detalle'])) $_SESSION['pedido_detalle'] = [];
                // Procesar el POST para agregar detalle
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['menu'], $_POST['cantidad'])) {
                    $menu_id = intval($_POST['menu']);
                    $cantidad = intval($_POST['cantidad']);
                    if ($menu_id > 0 && $cantidad > 0) {
                        // Buscar nombre y precio del menú
                        $menu_nombre = '';
                        $menu_valor = 0;
                        foreach ($menus as $m) {
                            if ($m['me_id'] == $menu_id) {
                                $menu_nombre = $m['me_menu'];
                                $menu_valor = $m['me_valor'];
                                break;
                            }
                        }
                        $_SESSION['pedido_detalle'][] = [
                            'me_id' => $menu_id,
                            'me_menu' => $menu_nombre,
                            'cantidad' => $cantidad,
                            'me_valor' => $menu_valor
                        ];
                    }
                }

                $detalle = $_SESSION['pedido_detalle'];
                $total_pedido = 0;
                if (!empty($detalle)):
                    foreach ($detalle as $i => $row):
                        $subtotal = $row['me_valor'] * $row['cantidad'];
                        $total_pedido += $subtotal;
                ?>
                        <tr>
                            <td><?php echo $i+1; ?></td>
                            <td><?php echo htmlspecialchars($row['me_menu']); ?></td>
                            <td><?php echo htmlspecialchars($row['cantidad']); ?></td>
                            <td>$<?php echo number_format($row['me_valor'], 0, ',', '.'); ?></td>
                            <td>$<?php echo number_format($subtotal, 0, ',', '.'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr style="font-weight:bold; background:#f7f7f7;">
                        <td colspan="4" style="text-align:right;">Total del Pedido:</td>
                        <td>$<?php echo number_format($total_pedido, 0, ',', '.'); ?></td>
                    </tr>
                <?php else: ?>
                    <tr><td colspan="5">No hay detalles de pedido en curso.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Botón para finalizar y guardar el pedido -->
        <form method="POST" action="procesar_pedido.php" style="text-align:center; margin-top:18px;">
            <button type="submit" class="btn-orange pedido-btn-agregar" style="font-size:1.1em; padding:12px 36px;">Finalizar y Guardar Pedido</button>
        </form>



        <div class="registro-switch">
            <a href="../index.php" class="switch-link">Volver al inicio</a>
        </div>
    </div>
</body>
</html>
