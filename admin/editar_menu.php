<?php

session_start();
require_once('../clases/config.php');
require_once('../clases/db.php');

if (!isset($_GET['id'])) {
    header('Location: gestion_menu.php');
    exit;
}

$id = intval($_GET['id']);
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$sql = "SELECT * FROM menus WHERE me_id=?";
$result = $db->query($sql, [$id]);
$menus = $result->fetchAll();
$menu = isset($menus[0]) ? $menus[0] : false;

if (!$menu) {
    header('Location: gestion_menu.php');
    exit;
}

// Si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $me_menu = trim($_POST['me_menu']);
    $me_mas_vendido = isset($_POST['me_mas_vendido']) ? 1 : 0;
    $me_infantil = isset($_POST['me_infantil']) ? 1 : 0;
    $me_especialidad = isset($_POST['me_especialidad']) ? 1 : 0;
    $me_resena = trim($_POST['me_resena']);
    $me_valor = intval($_POST['me_valor']);

    // Manejo de imagen
    $me_imagen = $menu['me_imagen'];
    if (isset($_FILES['me_imagen']) && $_FILES['me_imagen']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['me_imagen']['name'], PATHINFO_EXTENSION);
        $nombre_archivo = 'menu_' . $id . '_' . time() . '.' . $ext;
        $ruta_destino = '../assets/img/menus/' . $nombre_archivo;

        // Crear carpeta si no existe
        if (!is_dir('../assets/img/menus/')) {
            mkdir('../assets/img/menus/', 0777, true);
        }

        if (move_uploaded_file($_FILES['me_imagen']['tmp_name'], $ruta_destino)) {
            $me_imagen = 'assets/img/menus/' . $nombre_archivo;
        }
    }

    // Actualizar menú
    $sql = "UPDATE menus SET me_menu=?, me_mas_vendido=?, me_infantil=?, me_especialidad=?, me_resena=?, me_valor=?, me_imagen=? WHERE me_id=?";
    $db->query($sql, [$me_menu, $me_mas_vendido, $me_infantil, $me_especialidad, $me_resena, $me_valor, $me_imagen, $id]);

    header("Location: gestion_menu.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Menú</title>
    <link rel="stylesheet" href="../assets/css/style.css">
   
</head>
<body>
    <div class="menu-edit-container">
        <a href="gestion_menu.php" class="btn-back" title="Volver a gestión de menús">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h2 class="menu-edit-title">Editar Menú</h2>
        <form method="POST" class="menu-edit-form" enctype="multipart/form-data">
            <label for="me_menu">Nombre Menú:</label>
            <input type="text" name="me_menu" id="me_menu" value="<?php echo htmlspecialchars($menu['me_menu']); ?>" required>

            <div class="checkbox-group">
                <label>
                    <input type="checkbox" name="me_mas_vendido" <?php if($menu['me_mas_vendido']) echo 'checked'; ?>>
                    Más Vendido
                </label>
                <label>
                    <input type="checkbox" name="me_infantil" <?php if($menu['me_infantil']) echo 'checked'; ?>>
                    Infantil
                </label>
                <label>
                    <input type="checkbox" name="me_especialidad" <?php if($menu['me_especialidad']) echo 'checked'; ?>>
                    Especialidad
                </label>
            </div>

            <label for="me_resena">Reseña:</label>
            <textarea name="me_resena" id="me_resena" required><?php echo htmlspecialchars($menu['me_resena']); ?></textarea>

            <label for="me_valor">Valor:</label>
            <input type="number" name="me_valor" id="me_valor" value="<?php echo htmlspecialchars($menu['me_valor']); ?>" required>

            <label>Imagen actual:</label>
            <?php if ($menu['me_imagen']): ?>
                <img src="../<?php echo htmlspecialchars($menu['me_imagen']); ?>" alt="Imagen menú">
            <?php else: ?>
                <span style="color:#ee6926;">No hay imagen</span>
            <?php endif; ?>

            <label for="me_imagen">Subir nueva imagen:</label>
            <input type="file" name="me_imagen" id="me_imagen" accept="image/*">

            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</body>
</html>