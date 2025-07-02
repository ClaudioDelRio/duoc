// Alternar entre registro y login en registro de clientes
window.addEventListener('DOMContentLoaded', function() {
    const formRegistro = document.getElementById('form-registro');
    const formLogin = document.getElementById('form-login');
    const switchBtn = document.getElementById('switch-btn');
    const switchText = document.getElementById('switch-text');
    const tituloForm = document.getElementById('titulo-form');
    let mostrandoRegistro = true;
    if (switchBtn) {
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
    }
});
