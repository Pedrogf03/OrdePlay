function addToCart(idVideojuego) {
  // Comprobar si la cookie "carrito" existe
  var cartCookie = getCookie('carrito');
  var cartItems = [];

  if (cartCookie) {
    // Si la cookie existe, obtener los elementos del carrito actual
    cartItems = JSON.parse(cartCookie);
  }

  // Agregar el id del videojuego al carrito
  cartItems.push(idVideojuego);

  // Guardar los elementos del carrito en la cookie
  setCookie('carrito', JSON.stringify(cartItems), 365); // Guardar la cookie por 1 año.

  // Mostrar mensaje de éxito o redirigir a la página del carrito, etc.
  window.location.href = 'index.php?action=verCarrito';
}

// Función para obtener el valor de una cookie
function getCookie(name) {
  var cookieName = name + '=';
  var decodedCookie = decodeURIComponent(document.cookie); // Decodifica el contenido de la cookie almacenada en el navegador.
  var cookieArray = decodedCookie.split(';');

  for (var i = 0; i < cookieArray.length; i++) {
    var cookie = cookieArray[i];

    while (cookie.charAt(0) == ' ') {
      cookie = cookie.substring(1); // Eliminar los espacios en blanco iniciales en una cookie.
    }

    if (cookie.indexOf(cookieName) == 0) {
      return cookie.substring(cookieName.length, cookie.length); // Devuelve un substring que contiene la cookie del carrito.
    }
  }

  return null;
}

// Función para establecer el valor de una cookie
function setCookie(name, value, days) {
  var expires = '';

  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    expires = '; expires=' + date.toUTCString();
  }

  document.cookie = name + '=' + value + expires + '; path=/';
}
