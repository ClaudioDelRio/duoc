<?php
session_start();
if (!isset($_SESSION['cliente_id']) || !isset($_POST['testimonio'])) {
    header('Location: insertar_testimonio.php?msg=Acceso%20no%20autorizado');
    exit;
}
require_once '../clases/config.php';
require_once '../clases/db.php';
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$rc_id = $_SESSION['cliente_id'];
$testimonio = trim($_POST['testimonio']);
if ($testimonio === '' || strlen($testimonio) > 255) {
    header('Location: insertar_testimonio.php?msg=Testimonio%20inv%C3%A1lido');
    exit;
}
// Insertar testimonio
try {
    $db->query('INSERT INTO testimonios (t_rc_id, t_testimonio) VALUES (?, ?)', $rc_id, $testimonio);
    $mensaje = '¡Gracias por tu testimonio!';
} catch (Exception $e) {
    $mensaje = 'Error al guardar el testimonio';
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Testimonio</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <main>
        <section class="section section-testimonio-form">
            <div class="testimonios-title">Agrega tu testimonio</div>
            <div class="testimonios-desc">Cuéntanos tu experiencia en Family Lunch</div>
            <div class="testimonio-form-container">
                <div class="testimonio-form-mensaje"> <?php echo htmlspecialchars($mensaje); ?> </div>
                <a href="../index.php" class="btn-back" title="Volver al inicio" style="display:inline-block;margin-top:18px;">
                    <i class="bi bi-arrow-left-circle"></i> Volver al inicio
                </a>
            </div>
        </section>
    </main>
</body>
</html>
