<?php
session_start();
require_once('../clases/config.php');
require_once('../clases/db.php');

// Solo usuarios logueados
if (!isset($_SESSION['u_id'])) {
    header('Location: ../index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Insertar Menú</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="menu-edit-container">
        <a href="gestion_menu.php" class="btn-back" title="Volver a gestión de menús">
            <i class="bi bi-arrow-left-circle"></i>
        </a>
        <h2 class="menu-edit-title">Insertar Menú</h2>
        <form method="POST" class="menu-edit-form" enctype="multipart/form-data" action="insertar_menu_proceso.php">
            <label for="me_menu">Nombre Menú:</label>
            <input type="text" name="me_menu" id="me_menu" required>

            <div class="checkbox-group">
                <label>
                    <input type="checkbox" name="me_mas_vendido">
                    Más Vendido
                </label>
                <label>
                    <input type="checkbox" name="me_infantil">
                    Infantil
                </label>
                <label>
                    <input type="checkbox" name="me_especialidad">
                    Especialidad
                </label>
            </div>

            <label for="me_resena">Reseña:</label>
            <textarea name="me_resena" id="me_resena" required></textarea>

            <label for="me_valor">Valor:</label>
            <input type="number" name="me_valor" id="me_valor" required>

            <label for="me_imagen">Subir imagen:</label>
            <input type="file" name="me_imagen" id="me_imagen" accept="image/*">

            <button type="submit">Guardar Menú</button>
        </form>
    </div>
</body>
</html>