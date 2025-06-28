document.addEventListener('DOMContentLoaded', function() {
    var abrir = document.getElementById('abrirModalContacto');
    var cerrar = document.getElementById('cerrarModalContacto');
    var modal = document.getElementById('modalContacto');
    if (abrir && cerrar && modal) {
        abrir.onclick = function(e) {
            e.preventDefault();
            modal.style.display = 'block';
        };
        cerrar.onclick = function() {
            modal.style.display = 'none';
        };
        window.onclick = function(event) {
            if (event.target == modal) {
            modal.style.display = 'none';
            }
        };
        // Abrir automáticamente si hay ?modal=contacto en la URL
        if (window.location.search.indexOf('modal=contacto') !== -1) {
            modal.style.display = 'block';
        }
    }
});