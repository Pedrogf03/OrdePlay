<div class="container">
  <div class="form">
    <h2>Iniciar Sesión</h2>
    <form action="https://ordeplay.cifpceuta.com/index.php?action=doLogIn" method="post" id="miFormulario">
      <div class="campo">
        <input type="text" name="email" required id="email">
        <label>Email</label>
      </div>
      <div class="campo" id="lastCampo">
        <input type="password" name="passwd" required id="passwd">
        <label>Contraseña</label>
        <i class="fa-regular fa-eye" id="eyeIcon"></i>
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

  // Validación y envío de datos del formulario con respuesta del servidor.
  var miFormulario = document.getElementById('miFormulario');
  miFormulario.addEventListener('submit', function(ev) {
    ev.preventDefault();

    var datos = new FormData(miFormulario);

    // Envío de los datos al servidor
    fetch(miFormulario.getAttribute('action'), {
      method: miFormulario.getAttribute('method'),
      body: datos
    })
    .then(function(respuesta) {
    return respuesta.json();
    })
    // Trabajo con la respuesta que da el servidor.
    .then(function(datos) {
      console.log(datos);

      if(datos.exito){
        window.location.href = "https://ordeplay.cifpceuta.com";
      } else {
        if(!document.getElementById('mensaje')){
          let msg = document.createElement('p');
          msg.innerText = datos.mensaje;
          msg.id = 'mensaje';
          document.getElementById('lastCampo').appendChild(msg);
        }
      }

    })
    .catch(function(error) {
      console.log(error);
    });
  });

  // Ver contraseña
  document.getElementById('eyeIcon').addEventListener("mousedown", function() {
    document.getElementById('passwd').setAttribute('type', "text");
  })
  document.getElementById('eyeIcon').addEventListener("mouseup", function() {
    document.getElementById('passwd').setAttribute('type', "password");
  })



</script>
