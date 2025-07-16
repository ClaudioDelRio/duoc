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

if (!isset($_GET['id'])) {
    header('Location: registro_clientes.php?error=no-id');
    exit;
}

$id = intval($_GET['id']);
$db = new db($dbhost, $dbuser, $dbpass, $dbname);

try {
    // Obtener información del cliente antes de eliminarlo para el mensaje
    $cliente_query = "SELECT rc_nombre, rc_correo FROM registro_clientes WHERE rc_id = ?";
    $cliente_result = $db->query($cliente_query, [$id]);
    $clientes = $cliente_result->fetchAll();
    
    if (empty($clientes)) {
        header('Location: registro_clientes.php?error=not-found');
        exit;
    }
    
    $cliente = $clientes[0]; // Obtener el primer (y único) resultado
    
    // Eliminar el cliente
    $delete_query = "DELETE FROM registro_clientes WHERE rc_id = ?";
    $db->query($delete_query, [$id]);
    
    // Redirigir con mensaje de éxito
    header('Location: registro_clientes.php?success=deleted&nombre=' . urlencode($cliente['rc_nombre']));
    exit;
    
} catch (Exception $e) {
    // Redirigir con mensaje de error
    header('Location: registro_clientes.php?error=delete-failed');
    exit;
}
?>