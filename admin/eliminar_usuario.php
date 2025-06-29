<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('../clases/config.php');
require_once('../clases/db.php');

if (!isset($_GET['id'])) {
    header('Location: usuarios.php');
    exit;
}

$id = intval($_GET['id']);
$db = new db($dbhost, $dbuser, $dbpass, $dbname);

// Valicacion para no eliminar mi propia sesión
    if ($_SESSION['u_id'] == $id) {
        header('Location: usuarios.php?error=auto-delete');
        exit;
    }

$db->query("DELETE FROM usuarios WHERE u_id = $id");

header('Location: usuarios.php');
exit;