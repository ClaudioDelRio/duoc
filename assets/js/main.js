// Formatea el RUT chileno en tiempo real en el input con id 'rut'
document.addEventListener('DOMContentLoaded', function() {
    const rutInput = document.getElementById('rut');
    if (!rutInput) return;
    rutInput.addEventListener('input', function(e) {
        let value = rutInput.value.replace(/[^0-9kK]/g, '').toUpperCase();
        if (value.length > 1) {
            let cuerpo = value.slice(0, -1);
            let dv = value.slice(-1);
            // Formatear cuerpo con puntos (de derecha a izquierda)
            cuerpo = cuerpo.split('').reverse().join('').replace(/(\d{3})(?=\d)/g, '$1.').split('').reverse().join('');
            rutInput.value = cuerpo + '-' + dv;
        } else {
            rutInput.value = value;
        }
    });
    // Evita que el usuario escriba más de 12 caracteres (sin puntos ni guion)
    rutInput.addEventListener('keypress', function(e) {
        let value = rutInput.value.replace(/[^0-9kK]/g, '');
        if (value.length >= 9 && !['Backspace', 'Delete'].includes(e.key)) {
            e.preventDefault();
        }
    });
});
