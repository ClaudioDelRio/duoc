<?php
session_start();
include_once('config.php');
include_once('db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar token CSRF si está configurado
    if (isset($_SESSION['csrf_token']) && isset($_POST['csrf_token'])) {
        if ($_SESSION['csrf_token'] !== $_POST['csrf_token']) {
            header('Location: ../admin/login.php?error=1&message=' . urlencode("Error de seguridad. Por favor, intente de nuevo."));
            exit();
        }
    }
    
    $u_username = $_POST['username'];
    $u_password = $_POST['password'];
    
    // Validación básica
    if (empty($u_username) || empty($u_password)) {
        header('Location: ../admin/login.php?error=1&message=' . urlencode("Usuario y contraseña son requeridos"));
        exit();
    }
    
    $db = new db($dbhost, $dbuser, $dbpass, $dbname);
   
    // Obtenemos el usuario solo por username
    $query = "SELECT * FROM usuarios WHERE u_username = ?";
    $resultado = $db->query($query, [$u_username])->fetchAll();
    
    if (count($resultado) > 0) {
        // Verificamos la contraseña sin modificarla
        if (password_verify($u_password, $resultado[0]['u_password'])) {
            // Autenticación exitosa
            $_SESSION['u_id'] = $resultado[0]['u_id'];
            $_SESSION['u_username'] = $resultado[0]['u_username'];
            $_SESSION['u_nombre'] = $resultado[0]['u_nombre'];
           
            // Redirigir a la página de opciones
            header('Location: ../admin/opciones.php');
            exit();
        }
    }
   
    // Si llegamos aquí, la autenticación falló
    header('Location: ../index.php?login_error=1');
    exit();
} else {
    // Si no es una petición POST, redirigir a login
    header('Location: ../admin/login.php');
    exit();
}
?>