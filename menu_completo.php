<?php
if (session_status() === PHP_SESSION_NONE) session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Completo | Family Lunch SpA</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <header>
        <?php include_once 'header.php'; ?>
    </header>
    <main>
        <section class="section" id="section-menu-completo">
            <div class="section-title">Menú Completo</div>
            <div class="section-desc">Todos nuestros platos disponibles</div>
            <?php
            require_once __DIR__ . '/clases/config.php';
            require_once __DIR__ . '/clases/db.php';
            $db = new db($dbhost, $dbuser, $dbpass, $dbname);
            $platos = $db->query("SELECT * FROM menus ORDER BY me_menu ASC")->fetchAll();
            ?>
            <div class="menu-completo-list">
                <?php foreach ($platos as $plato): ?>
                <article class="menu-card">
                    <figure>
                        <img src="<?php echo htmlspecialchars(preg_replace('/^proyecto\//', '', $plato['me_imagen'])); ?>" alt="<?php echo htmlspecialchars($plato['me_menu']); ?>">
                        <figcaption class="menu-nombre-principal"><?php echo htmlspecialchars($plato['me_menu']); ?></figcaption>
                    </figure>
                    <div class="info">
                        
                        <!-- Nombre eliminado, solo se muestra en figcaption -->
                        <p><?php echo htmlspecialchars($plato['me_resena']); ?></p>
                        <div class="precio">$<?php echo number_format($plato['me_valor'], 0, ',', '.'); ?></div>
                        <a class="btn-detalles" href="detalle_menu.php?id=<?php echo $plato['me_id']; ?>">Ver Detalles</a>
                    </div>
                </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>
    <footer>
        <?php include_once 'footer.php'; ?>
    </footer>
</body>
</html>
<!--
// =============================
// Estilos para menú completo
// =============================
.menu-completo-list {
  display: flex;
  flex-wrap: wrap;
  gap: 30px;
  justify-content: center;
  margin-bottom: 30px;
}
@media (max-width: 900px) {
  .menu-completo-list {
    flex-direction: column;
    align-items: center;
  }
}
-->
