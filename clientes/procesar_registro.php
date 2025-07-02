<?php
// procesar_registro.php - Procesa el registro de un nuevo cliente
session_start();
require_once '../clases/config.php';
require_once '../clases/db.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $rut = trim($_POST['rut'] ?? '');
    $direccion = trim($_POST['direccion'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    // Validación básica
    if (empty($nombre) || empty($rut) || empty($direccion) || empty($email) || empty($password)) {
        $_SESSION['registro_exito'] = 'Todos los campos son obligatorios.';
        header('Location: registro.php');
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['registro_exito'] = 'Correo electrónico no válido.';
        header('Location: registro.php');
        exit;
    }

    try {
        $db = new db($dbhost, $dbuser, $dbpass, $dbname);
        // Verificar si el correo ya está registrado
        $query = "SELECT rc_id FROM registro_clientes WHERE rc_correo = ?";
        $existe = $db->query($query, [$email])->fetchAll();
        if (count($existe) > 0) {
            $_SESSION['registro_exito'] = 'El correo ya está registrado.';
            header('Location: registro.php');
            exit;
        }
        // Hashear la contraseña
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        // Insertar nuevo cliente
        $insert = "INSERT INTO registro_clientes (rc_nombre, rc_rut, rc_direccion, rc_correo, rc_password) VALUES (?, ?, ?, ?, ?)";
        $db->query($insert, [$nombre, $rut, $direccion, $email, $password_hash]);
        $_SESSION['registro_exito'] = '¡Registro exitoso! Ahora puedes iniciar sesión.';
        header('Location: registro.php');
        exit;
    } catch (Exception $e) {
        $_SESSION['registro_exito'] = 'Error: ' . $e->getMessage();
        header('Location: registro.php');
        exit;
    }
} else {
    header('Location: registro.php');
    exit;
}
