<?php
session_start();
require_once('../clases/config.php');
require_once('../clases/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $db = new db($dbhost, $dbuser, $dbpass, $dbname);

    $me_menu = trim($_POST['me_menu']);
    $me_mas_vendido = isset($_POST['me_mas_vendido']) ? 1 : 0;
    $me_infantil = isset($_POST['me_infantil']) ? 1 : 0;
    $me_especialidad = isset($_POST['me_especialidad']) ? 1 : 0;
    $me_resena = trim($_POST['me_resena']);
    $me_valor = intval($_POST['me_valor']);

    // Imagen
    $me_imagen = '';
    if (isset($_FILES['me_imagen']) && $_FILES['me_imagen']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['me_imagen']['name'], PATHINFO_EXTENSION);
        $nombre_archivo = 'menu_' . time() . '.' . $ext;
        $ruta_destino = '../assets/img/menus/' . $nombre_archivo;

        if (!is_dir('../assets/img/menus/')) {
            mkdir('../assets/img/menus/', 0777, true);
        }

        if (move_uploaded_file($_FILES['me_imagen']['tmp_name'], $ruta_destino)) {
            $me_imagen = 'assets/img/menus/' . $nombre_archivo;
        }
    }

    // Insertar menú
    $sql = "INSERT INTO menus (me_menu, me_mas_vendido, me_infantil, me_especialidad, me_resena, me_valor, me_imagen)
            VALUES (?, ?, ?, ?, ?, ?, ?)";
    $db->query($sql, [$me_menu, $me_mas_vendido, $me_infantil, $me_especialidad, $me_resena, $me_valor, $me_imagen]);

    header("Location: gestion_menu.php");
    exit;
} else {
    header('Location: gestion_menu.php');
    exit;
}