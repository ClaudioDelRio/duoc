<?php
// cerrar_sesion.php - Cierra la sesión del cliente
session_start();
if (isset($_SESSION['cliente_id']) || isset($_SESSION['cliente_nombre'])) {
    unset($_SESSION['cliente_id']);
    unset($_SESSION['cliente_nombre']);
}
session_write_close();
header('Location: ../index.php');
exit;
