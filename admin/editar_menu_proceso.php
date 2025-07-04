<?php
session_start();
require_once('../clases/config.php');
require_once('../clases/db.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $db = new db($dbhost, $dbuser, $dbpass, $dbname);

    // Obtener datos actuales del menú
    $sql = "SELECT * FROM menus WHERE me_id=?";
    $result = $db->query($sql, [$id]);
    $menus = $result->fetchAll();
    $menu = isset($menus[0]) ? $menus[0] : false;

    if (!$menu) {
        header('Location: gestion_menu.php');
        exit;
    }

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
} else {
    header('Location: gestion_menu.php');
    exit;
}