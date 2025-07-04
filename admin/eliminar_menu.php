<?php
// filepath: g:\Mi unidad\Duoc\7mo Semestre\Proyecto Integrado\proyecto\admin\eliminar_menu.php
session_start();
require_once('../clases/config.php');
require_once('../clases/db.php');

// Solo usuarios logueados
if (!isset($_SESSION['u_id'])) {
    header('Location: ../index.php');
    exit;
}

// Validar ID recibido por GET
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: gestion_menu.php');
    exit;
}

$id = intval($_GET['id']);
$db = new db($dbhost, $dbuser, $dbpass, $dbname);

// Obtener la ruta de la imagen para eliminar el archivo físico si existe
$sql = "SELECT me_imagen FROM menus WHERE me_id=?";
$result = $db->query($sql, [$id]);
$menus = $result->fetchAll();
$menu = isset($menus[0]) ? $menus[0] : false;

if ($menu && !empty($menu['me_imagen'])) {
    $ruta_imagen = '../' . $menu['me_imagen'];
    if (file_exists($ruta_imagen)) {
        unlink($ruta_imagen);
    }
}

// Eliminar el menú de la base de datos
$sql = "DELETE FROM menus WHERE me_id=?";
$db->query($sql, [$id]);

header('Location: gestion_menu.php');
exit;