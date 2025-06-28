<?php
if (isset($_GET['enviado'])) {
    if ($_GET['enviado'] === 'ok') {
        echo '<div class="mensaje-exito">¡Mensaje enviado correctamente!</div>';
    } elseif ($_GET['enviado'] === 'error') {
        echo '<div class="mensaje-error">Hubo un error al enviar el mensaje. Intenta nuevamente.</div>';
    }
}
?>
<h2 class="titulo-contacto-modal">Formulario de Consultas</h2>
<form method="post" action="includes/send_mail.php" class="form-contacto" autocomplete="off">
  <input type="hidden" name="origen" value="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">

  <label for="nombre">Nombre:</label>
  <input type="text" name="nombre" id="nombre" required maxlength="50">

  <label for="email">Correo electrónico:</label>
  <input type="email" name="email" id="email" required maxlength="80">

  <label for="mensaje">Mensaje:</label>
  <textarea name="mensaje" id="mensaje" required maxlength="500"></textarea>

  <button type="submit" class="btn-orange">Enviar</button>
</form>