<?php
session_start();
require_once '../clases/config.php';
require_once '../clases/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email_login'] ?? '');
    $password = $_POST['password_login'] ?? '';

    // Validación básica
    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = 'Debes ingresar tu correo y contraseña.';
        header('Location: registro.php');
        exit;
    }

    $db = new db($dbhost, $dbuser, $dbpass, $dbname);

    // Buscar usuario por correo
    $query = "SELECT rc_id, rc_nombre, rc_password FROM registro_clientes WHERE rc_correo = ?";
    $result = $db->query($query, [$email])->fetchAll();

    if (count($result) === 1) {
        $cliente = $result[0];
        if (password_verify($password, $cliente['rc_password'])) {
            // Login exitoso
            $_SESSION['cliente_id'] = $cliente['rc_id'];
            $_SESSION['cliente_nombre'] = $cliente['rc_nombre'];
            session_write_close();
            header('Location: ../index.php');
            exit;
        }
    }

    // Login fallido
    $_SESSION['login_error'] = 'Usuario o contraseña incorrecta.';
    header('Location: registro.php');
    exit;
} else {
    header('Location: registro.php');
    exit;
}