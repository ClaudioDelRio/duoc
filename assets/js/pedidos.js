// Pedidos: advertencia si no ha iniciado sesión el cliente
window.addEventListener('DOMContentLoaded', function() {
  const btnPedidos = document.getElementById('btnPedidos');
  if (btnPedidos) {
    btnPedidos.addEventListener('click', function(e) {
      // Este bloque será reemplazado por PHP al renderizar
      if (window.pedidosClienteLogueado !== true) {
        e.preventDefault();
        alert('Debes iniciar sesión como cliente antes de realizar un pedido.');
      } else {
        window.location.href = 'clientes/pedidos.php';
      }
    });
  }
});
