<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('../clases/config.php');
require_once('../clases/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $nombre = trim($_POST['nombre'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $rut = trim($_POST['rut'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    // Validación básica
    if (empty($nombre) || empty($username) || empty($rut)) {
        header("Location: editar_usuario.php?id=$id&error=1");
        exit;
    }
    if (!empty($password) && $password !== $password2) {
        header("Location: editar_usuario.php?id=$id&error=2");
        exit;
    }

    // Formatea RUT chileno XX.XXX.XXX-Y
    function formatear_rut($rut) {
        $rut = preg_replace('/[^kK0-9]/', '', $rut);
        $cuerpo = substr($rut, 0, -1);
        $dv = strtoupper(substr($rut, -1));
        $cuerpo = number_format($cuerpo, 0, '', '.');
        return $cuerpo . '-' . $dv;
    }
    $rut = formatear_rut($rut);

    $db = new db($dbhost, $dbuser, $dbpass, $dbname);

    // Verificar si el username o rut ya existen en otro usuario
    $db->query("SELECT u_id FROM usuarios WHERE (u_rut = '$rut' OR u_username = '$username') AND u_id != $id");
    $existe = $db->fetchAll();
    if (count($existe) > 0) {
        header("Location: editar_usuario.php?id=$id&error=3");
        exit;
    }

    // Actualizar datos
    if (!empty($password)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $db->query("UPDATE usuarios SET u_nombre='$nombre', u_username='$username', u_rut='$rut', u_password='$hash' WHERE u_id=$id");
    } else {
        $db->query("UPDATE usuarios SET u_nombre='$nombre', u_username='$username', u_rut='$rut' WHERE u_id=$id");
    }

    header('Location: usuarios.php');
    exit;
} else {
    header('Location: usuarios.php');
    exit;
}