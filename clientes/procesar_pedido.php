<?php
// procesar_pedido.php - Procesa el pedido del cliente
session_start();
if (!isset($_SESSION['cliente_id'])) {
    header('Location: registro.php');
    exit;
}
require_once '../clases/config.php';
require_once '../clases/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cliente_id = $_SESSION['cliente_id'];
    if (!isset($_SESSION['pedido_detalle']) || !is_array($_SESSION['pedido_detalle']) || count($_SESSION['pedido_detalle']) === 0) {
        $_SESSION['pedido_mensaje'] = 'No hay detalles de pedido para procesar.';
        header('Location: pedidos.php');
        exit;
    }

    $detalle = $_SESSION['pedido_detalle'];
    $db = new db($dbhost, $dbuser, $dbpass, $dbname, 'utf8');

    // Calcular total del pedido
    $total_pedido = 0;
    foreach ($detalle as $row) {
        $subtotal = intval($row['me_valor']) * intval($row['cantidad']);
        $total_pedido += $subtotal;
    }

    try {
        // Insertar pedido principal
        $db->query('INSERT INTO pedidos (p_rc_id, p_total) VALUES (?, ?)', [$cliente_id, $total_pedido]);
        $pedido_id = $db->getInsertId();

        if (!$pedido_id || $pedido_id <= 0) {
            throw new Exception('No se pudo obtener el ID del pedido insertado.');
        }

        // Insertar detalles
        foreach ($detalle as $row) {
            $db->query('INSERT INTO pedidos_detalle (pd_p_id, pd_me_id, pd_cantidad) VALUES (?, ?, ?)', [
                $pedido_id,
                $row['me_id'],
                $row['cantidad']
            ]);
        }

        // Limpiar detalles de la sesión
        unset($_SESSION['pedido_detalle']);
        $_SESSION['pedido_mensaje'] = '¡Pedido realizado con éxito!';
    } catch (Exception $e) {
        // Mostrar error en pantalla para depuración
        echo '<pre style="color:red;">Error al guardar el pedido: ' . htmlspecialchars($e->getMessage()) . '</pre>';
        exit;
    }
    header('Location: pedidos.php');
    exit;
} else {
    header('Location: pedidos.php');
    exit;
}
