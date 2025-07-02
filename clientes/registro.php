<?php
// registro.php - Registro y login de clientes
session_start();
$mensaje = '';
if (isset($_SESSION['registro_exito'])) {
    $mensaje = $_SESSION['registro_exito'];
    unset($_SESSION['registro_exito']);
}
if (isset($_SESSION['login_error'])) {
    $mensaje = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Clientes | Family Lunch SpA</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Los estilos de registro de clientes están en custom.scss/style.css -->
</head>
<body>
    <div class="registro-container">
        <div class="registro-titulo" id="titulo-form">Registro de Cliente</div>
        <?php if ($mensaje): ?>
            <div class="registro-mensaje"><?php echo $mensaje; ?></div>
        <?php endif; ?>
        <form class="registro-form" id="form-registro" method="POST" action="procesar_registro.php" autocomplete="off" style="display:block;">
            <label for="nombre">Nombre completo</label>
            <input type="text" name="nombre" id="nombre" required>
            <label for="rut">RUT</label>
            <input type="text" name="rut" id="rut" required maxlength="12">
            <label for="direccion">Dirección</label>
            <input type="text" name="direccion" id="direccion" required maxlength="120">
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" id="email" required>
            <label for="password">Contraseña</label>
            <input type="password" name="password" id="password" required>
            <button type="submit">Registrarse</button>
        </form>
        <form class="registro-form" id="form-login" method="POST" action="procesar_login.php" autocomplete="off" style="display:none;">
            <label for="email_login">Correo electrónico</label>
            <input type="email" name="email_login" id="email_login" required>
            <label for="password_login">Contraseña</label>
            <input type="password" name="password_login" id="password_login" required>
            <button type="submit">Iniciar Sesión</button>
        </form>
        <div class="registro-switch">
            <span id="switch-text">¿Ya tienes cuenta?</span>
            <button type="button" id="switch-btn">Iniciar Sesión</button>
        </div>
    </div>
    <script>
        // Alternar entre registro y login
        const formRegistro = document.getElementById('form-registro');
        const formLogin = document.getElementById('form-login');
        const switchBtn = document.getElementById('switch-btn');
        const switchText = document.getElementById('switch-text');
        const tituloForm = document.getElementById('titulo-form');
        let mostrandoRegistro = true;
        switchBtn.addEventListener('click', function() {
            mostrandoRegistro = !mostrandoRegistro;
            if (mostrandoRegistro) {
                formRegistro.style.display = 'block';
                formLogin.style.display = 'none';
                switchBtn.textContent = 'Iniciar Sesión';
                switchText.textContent = '¿Ya tienes cuenta?';
                tituloForm.textContent = 'Registro de Cliente';
            } else {
                formRegistro.style.display = 'none';
                formLogin.style.display = 'block';
                switchBtn.textContent = 'Registrarse';
                switchText.textContent = '¿No tienes cuenta?';
                tituloForm.textContent = 'Iniciar Sesión';
            }
        });
    </script>
</body>
</html>
