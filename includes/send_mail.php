<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = htmlspecialchars(trim($_POST['nombre'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $mensaje = htmlspecialchars(trim($_POST['mensaje'] ?? ''));
    $origen = isset($_POST['origen']) ? $_POST['origen'] : '../index.php';

    if ($nombre && filter_var($email, FILTER_VALIDATE_EMAIL) && $mensaje) {
        $to = 'cadrm00@gmail.com';
        $subject = "Nuevo mensaje de contacto de $nombre";
        $body = "Nombre: $nombre\nCorreo: $email\nMensaje:\n$mensaje";
        $headers = "From: $email\r\nReply-To: $email\r\n";

        mail($to, $subject, $body, $headers);

        header('Location: ' . $origen . '?modal=contacto&enviado=ok');
        exit;
    } else {
        header('Location: ' . $origen . '?modal=contacto&enviado=error');
        exit;
    }
} else {
    header('Location: ../index.php');
    exit;
}