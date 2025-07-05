<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Más Testimonios | Family Lunch SpA</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        /* Ajustes mínimos para asegurar que los estilos se apliquen si el CSS principal no está actualizado */
    </style>
</head>
<body>
    <header>
        <?php include_once 'header.php'; ?>
    </header>
    <main>
        <section class="mas-testimonios-section">
            <div class="mas-testimonios-title">Todos los testimonios de nuestros clientes</div>
            <div class="mas-testimonios-desc">Experiencias reales de familias que nos han visitado</div>
            <div class="mas-testimonios-grid">
                <?php
                require_once __DIR__ . '/clases/config.php';
                require_once __DIR__ . '/clases/db.php';
                $db = new db($dbhost, $dbuser, $dbpass, $dbname);
                $testimonios = $db->query('SELECT t.t_testimonio, rc.rc_nombre FROM testimonios t JOIN registro_clientes rc ON t.t_rc_id = rc.rc_id ORDER BY t.t_id DESC')->fetchAll();
                if ($testimonios && count($testimonios) > 0):
                    foreach ($testimonios as $testimonio): ?>
                        <article class="mas-testimonio-card">
                            <div class="mas-testimonio-nombre"><?php echo htmlspecialchars($testimonio['rc_nombre']); ?></div>
                            <div class="mas-testimonio-texto"><?php echo htmlspecialchars($testimonio['t_testimonio']); ?></div>
                        </article>
                <?php endforeach;
                else: ?>
                    <div class="mas-testimonios-vacio">Aún no hay testimonios registrados.</div>
                <?php endif; ?>
            </div>
            <div class="mas-testimonios-volver">
                <a href="index.php" class="btn-menu-completo btn-volver-inicio"><i class="bi bi-arrow-left"></i> Volver al inicio</a>
                <?php if (isset($_SESSION['cliente_nombre'])): ?>
                    <a href="./clientes/insertar_testimonio.php" class="btn-menu-completo btn-agregar-testimonio">Agregar Testimonio</a>
                <?php endif; ?>
            </div>
        </section>
    </main>
    <footer>
        <?php include_once 'footer.php'; ?>
    </footer>
</body>
</html>
