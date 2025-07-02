<?php
// procesar_login.php - Procesa el login de clientes
session_start();
require_once '../clases/db.php'; 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email_login'] ?? '');
    $password = $_POST['password_login'] ?? '';

    if (empty($email) || empty($password)) {
        $_SESSION['login_error'] = 'Debes ingresar tu correo y contraseña.';
        header('Location: registro.php');
        exit;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['login_error'] = 'Correo electrónico no válido.';
        header('Location: registro.php');
        exit;
    }

    $stmt = $conn->prepare('SELECT rc_id, rc_nombre, rc_password FROM registro_clientes WHERE rc_correo = ? LIMIT 1');
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $nombre, $password_hash);
        $stmt->fetch();
        if (password_verify($password, $password_hash)) {
            $_SESSION['cliente_id'] = $id;
            $_SESSION['cliente_nombre'] = $nombre;
            // Redirigir a la página principal
            header('Location: ../index.php');
            exit;
        } else {
            $_SESSION['login_error'] = 'Contraseña incorrecta.';
        }
    } else {
        $_SESSION['login_error'] = 'No existe una cuenta con ese correo.';
    }
    $stmt->close();
    $conn->close();
    header('Location: registro.php');
    exit;
} else {
    header('Location: registro.php');
    exit;
}
