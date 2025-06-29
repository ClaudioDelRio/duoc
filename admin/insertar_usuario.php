<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once('../clases/config.php');
require_once('../clases/db.php');

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = trim($_POST['nombre'] ?? '');
    $username = trim($_POST['username'] ?? '');
    $rut = trim($_POST['rut'] ?? '');
    $password = $_POST['password'] ?? '';
    $password2 = $_POST['password2'] ?? '';

    // Función para validar RUT chileno
    function validar_rut($rut) {
        $rut = preg_replace('/[^kK0-9]/', '', $rut);
        if (strlen($rut) < 8) return false;
        $cuerpo = substr($rut, 0, -1);
        $dv = strtoupper(substr($rut, -1));
        $suma = 0;
        $multiplo = 2;
        for ($i = strlen($cuerpo) - 1; $i >= 0; $i--) {
            $suma += $cuerpo[$i] * $multiplo;
            $multiplo = $multiplo == 7 ? 2 : $multiplo + 1;
        }
        $resto = $suma % 11;
        $dvEsperado = 11 - $resto;
        if ($dvEsperado == 11) $dvEsperado = '0';
        elseif ($dvEsperado == 10) $dvEsperado = 'K';
        else $dvEsperado = (string)$dvEsperado;
        return $dv == $dvEsperado;
    }

    // Formatea RUT chileno XX.XXX.XXX-Y
    function formatear_rut($rut) {
        $rut = preg_replace('/[^kK0-9]/', '', $rut);
        $cuerpo = substr($rut, 0, -1);
        $dv = strtoupper(substr($rut, -1));
        $cuerpo = number_format($cuerpo, 0, '', '.');
        return $cuerpo . '-' . $dv;
    }

    // Validación básica
    if (empty($nombre) || empty($username) || empty($rut) || empty($password) || empty($password2)) {
        $mensaje = "Todos los campos son obligatorios.";
    } elseif (!validar_rut($rut)) {
        $mensaje = "El RUT ingresado no es válido.";
    } elseif ($password !== $password2) {
        $mensaje = "Las contraseñas no coinciden.";
    } else {
        try {
            $rut = formatear_rut($rut);
            $db = new db($dbhost, $dbuser, $dbpass, $dbname);

            // Verificar si el RUT o el nombre de usuario ya existen
            $query = "SELECT u_id FROM usuarios WHERE u_rut = ? OR u_username = ?";
            $existe = $db->query($query, [$rut, $username])->fetchAll();
            if (count($existe) > 0) {
                $mensaje = "El RUT o el nombre de usuario ya está registrado.";
            } else {
                // Hashear la contraseña
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $insert = "INSERT INTO usuarios (u_nombre, u_username, u_rut, u_password) VALUES (?, ?, ?, ?)";
                $db->query($insert, [$nombre, $username, $rut, $hash]);
                header('Location: usuarios.php');
                exit;
            }
        } catch (Exception $e) {
            $mensaje = "Error: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Usuario</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <script src="../assets/js/main.js"></script>
</head>
<body>
  <div class="registro-container">
    <h2 class="registro-titulo">Registrar Usuario</h2>
    <?php if ($mensaje): ?>
      <div class="registro-mensaje<?php if ($mensaje === "Usuario registrado correctamente.") echo ' registro-exito'; ?>">
        <?php echo htmlspecialchars($mensaje); ?>
      </div>
    <?php endif; ?>
    <form method="post" class="registro-form" autocomplete="off">
      <label for="nombre">Nombre completo:</label>
      <input type="text" name="nombre" id="nombre" maxlength="80" required>

      <label for="username">Nombre de usuario:</label>
      <input type="text" name="username" id="username" maxlength="30" required>

      <label for="rut">RUT:</label>
      <input type="text" name="rut" id="rut" maxlength="12" required>

      <label for="password">Contraseña:</label>
      <input type="password" name="password" id="password" minlength="6" required>

      <label for="password2">Repetir contraseña:</label>
      <input type="password" name="password2" id="password2" minlength="6" required>

      <button type="submit">Registrar</button>
    </form>
  </div>
</body>
</html>