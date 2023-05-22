import { mostrarCarrito } from './carrito.js';

// Obtener los datos del carrito en una cadena JSON
var cartJSON = mostrarCarrito();

// Realizar una petición AJAX para enviar los datos a PHP
$.ajax({
  type: 'POST',
  url: 'ruta-a-tu-archivo-php.php',
  data: { cartData: cartJSON },
  success: function (response) {
    // El servidor ha respondido correctamente
    console.log(response);
  },
  error: function (xhr, status, error) {
    // Ha ocurrido un error al realizar la petición
    console.error(error);
  },
});
