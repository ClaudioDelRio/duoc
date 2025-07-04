<?php
session_start();
if (!isset($_SESSION['cliente_id']) || !isset($_SESSION['cliente_nombre'])) {
    header('Location: ../index.php');
    exit;
}
$nombre = $_SESSION['cliente_nombre'];
$mensaje = isset($_GET['msg']) ? $_GET['msg'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Testimonio</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <main>
        <section class="section section-testimonio-form">
            <div class="testimonios-title">Agrega tu testimonio</div>
            <div class="testimonios-desc">Cuéntanos tu experiencia en Family Lunch</div>
            <div class="testimonio-form-container">
                <?php if ($mensaje): ?>
                    <div class="testimonio-form-mensaje"> <?php echo htmlspecialchars($mensaje); ?> </div>
                <?php endif; ?>
                <form class="form-testimonio" method="post" action="procesar_testimonio.php">
                    <label for="nombre">Nombre</label>
                    <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($nombre); ?>" readonly>
                    <label for="testimonio">Testimonio</label>
                    <textarea id="testimonio" name="testimonio" maxlength="255" required placeholder="Escribe tu experiencia..." rows="5"></textarea>
                    <button type="submit" class="btn-menu-completo btn-enviar-testimonio">Enviar Testimonio</button>
                </form>
            </div>
        </section>
    </main>
</body>
</html>
