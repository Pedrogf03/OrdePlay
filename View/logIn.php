<div class="container">
  <div class="form">
    <h2>Iniciar Sesión</h2>
    <form action="https://ordeplay.cifpceuta.com/index.php?action=doLogIn" method="post" id="miFormulario">
      <div class="campo">
        <input type="text" name="email" required id="email">
        <label>Email</label>
      </div>
      <div class="campo">
        <input type="text" name="passwd" required id="passwd">
        <label>Contraseña</label>
      </div>
      <div class="loginButton">
        <button id="enviar">Iniciar Sesión</button>
        <br/>
        <br/>
        <a href="index.php?action=crearUser">Crear cuenta</a>
      </div>
      </form>
  </div>
</div>
<script>
  var miFormulario = document.getElementById('miFormulario');

  miFormulario.addEventListener('submit', function(ev) {
    ev.preventDefault();

    var datos = new FormData(miFormulario);

    // Validación de los datos
    var email = datos.get('email');
    var passwd = datos.get('passwd');

    let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    let regexPasswd = /^[a-zA-Z0-9!@#$%^&*()_+=[\]{}|\\;:'",.<>/?]{6,50}$/;

    if (regexUser.test(email)) {
      alert('El email no es válido.');
      return;
    }

    if (regexUser.test(passwd)) {
      alert('La contraseña no es válida.');
      return;
    }

    // Envío de los datos al servidor
    fetch(miFormulario.getAttribute('action'), {
      method: miFormulario.getAttribute('method'),
      body: datos
    })
    .then(function(respuesta) {
    return respuesta.json();
    })
    .then(function(datos) {
      console.log(datos);
    })
    .catch(function(error) {
      console.log(error);
    });
});
</script>
