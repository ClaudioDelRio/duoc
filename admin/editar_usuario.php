<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('../clases/config.php');
require_once('../clases/db.php');

if (!isset($_GET['id'])) {
    header('Location: usuarios.php');
    exit;
}

$id = intval($_GET['id']);
$db = new db($dbhost, $dbuser, $dbpass, $dbname);
$db->query("SELECT * FROM usuarios WHERE u_id = $id");
$result = $db->fetchAll();
$usuario = isset($result[0]) ? $result[0] : false;

if (!$usuario) {
    header('Location: usuarios.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
  <div class="registro-container">
    <h2 class="registro-titulo">Editar Usuario</h2>
    <form method="post" action="editar_usuario_proceso.php" class="registro-form" autocomplete="off">
      <input type="hidden" name="id" value="<?php echo htmlspecialchars($usuario['u_id']); ?>">

      <label for="nombre">Nombre completo:</label>
      <input type="text" name="nombre" id="nombre" maxlength="80" required value="<?php echo htmlspecialchars($usuario['u_nombre']); ?>">

      <label for="username">Nombre de usuario:</label>
      <input type="text" name="username" id="username" maxlength="30" required value="<?php echo htmlspecialchars($usuario['u_username']); ?>">

      <label for="rut">RUT:</label>
      <input type="text" name="rut" id="rut" maxlength="12" required value="<?php echo htmlspecialchars($usuario['u_rut']); ?>">

      <label for="password">Nueva contraseña (opcional):</label>
      <input type="password" name="password" id="password" minlength="6">

      <label for="password2">Repetir nueva contraseña:</label>
      <input type="password" name="password2" id="password2" minlength="6">

      <button type="submit">Guardar Cambios</button>
    </form>
  </div>
</body>
</html>