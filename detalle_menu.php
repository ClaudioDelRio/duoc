<?php
// Mostrar errores para depuración
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// No requiere inicio de sesión
require_once __DIR__ . '/clases/config.php';
require_once __DIR__ . '/clases/db.php';

// Validar parámetro id
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: index.php');
    exit;
}
$id = intval($_GET['id']);
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$result = $db->query('SELECT * FROM menus WHERE me_id = ?', [$id])->fetchAll();
$plato = isset($result[0]) ? $result[0] : null;
if (!$plato) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Plato | Family Lunch SpA</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <header>
        <?php include_once 'header.php'; ?>
    </header>
    <main>
        <section class="section" id="section-detalle-menu">
            <div class="section-title" style="margin-top: 90px;">Detalle del Plato</div>
            <div class="detalle-menu-card">
                <figure>
                    <img src="<?php echo htmlspecialchars($plato['me_imagen']); ?>" alt="<?php echo htmlspecialchars($plato['me_menu']); ?>">
                    <figcaption><?php echo htmlspecialchars($plato['me_menu']); ?></figcaption>
                </figure>
                <div class="info">
                    <?php if ($plato['me_especialidad']): ?><div class="etiqueta">Especialidad</div><?php endif; ?>
                    <?php if ($plato['me_mas_vendido']): ?><div class="destacado">Más Vendido</div><?php endif; ?>
                    <?php if ($plato['me_infantil']): ?><div class="favorito">Favorito Infantil</div><?php endif; ?>
                    <h3><?php echo htmlspecialchars($plato['me_menu']); ?></h3>
                    <p class="resena"><?php echo htmlspecialchars($plato['me_resena']); ?></p>
                    <div class="descripcion"><?php echo nl2br(htmlspecialchars($plato['me_descripcion'])); ?></div>
                    <div class="precio">$<?php echo number_format($plato['me_valor'], 0, ',', '.'); ?></div>
                </div>
            </div>
            <div style="text-align:center; margin-top:30px;">
                <a href="menu_completo.php" class="btn-menu-completo">Volver al Menú Completo</a>
            </div>
        </section>
    </main>
    <footer>
        <?php include_once 'footer.php'; ?>
    </footer>
</body>
</html>
