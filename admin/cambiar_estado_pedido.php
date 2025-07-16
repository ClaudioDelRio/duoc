<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

// Verificamos la sesión de administrador
if (!isset($_SESSION['u_id'])) {
    header('Location: ../index.php');
    exit;
}

require_once('../clases/config.php');
require_once('../clases/db.php');

if (!isset($_GET['id']) || !isset($_GET['estado'])) {
    header('Location: lista_pedidos.php?error=no-params');
    exit;
}

$pedido_id = intval($_GET['id']);
$nuevo_estado = intval($_GET['estado']);

// Validar que el estado sea 0 o 1
if ($nuevo_estado !== 0 && $nuevo_estado !== 1) {
    header('Location: lista_pedidos.php?error=invalid-estado');
    exit;
}

$db = new db($dbhost, $dbuser, $dbpass, $dbname);

try {
    // Verificar que el pedido existe
    $pedido_query = "SELECT p_id FROM pedidos WHERE p_id = ?";
    $pedido_result = $db->query($pedido_query, [$pedido_id]);
    $pedidos = $pedido_result->fetchAll();
    
    if (empty($pedidos)) {
        header('Location: lista_pedidos.php?error=not-found');
        exit;
    }
    
    // Actualizar el estado del pedido
    $update_query = "UPDATE pedidos SET p_despachado = ? WHERE p_id = ?";
    $db->query($update_query, [$nuevo_estado, $pedido_id]);
    
    // Redirigir con mensaje de éxito
    header('Location: lista_pedidos.php?success=updated');
    exit;
    
} catch (Exception $e) {
    // Redirigir con mensaje de error
    header('Location: lista_pedidos.php?error=update-failed');
    exit;
}
?>