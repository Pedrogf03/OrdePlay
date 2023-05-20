<div class="container">
  <div class="form">
    <h2>Crear lista nueva</h2>
    <form action="https://ordeplay.cifpceuta.com/index.php?action=doCrearLista" method="post" id="miFormulario">
      <div class="campo">
        <input type="text" name="nombreLista" required id="email">
        <label>Nombre</label>
      </div>
      <div class="campo" id="lastCampo">
        <label>Descripción</label>
        <textarea name="descripcion"></textarea>
      </div>
      <div class="loginButton">
        <button id="enviar">Crear</button>
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
      if(datos.exito){
        // Se dirige a la pantalla de inicio
        window.location.href = "https://ordeplay.cifpceuta.com";
      } else {
        if(!document.getElementById('mensaje')){
          let msg = document.createElement('p');
          msg.innerText = datos.mensaje;
          msg.id = 'mensaje';
          document.getElementById('lastCampo').appendChild(msg);
        } else {
          document.getElementById('mensaje').innerText = datos.mensaje;
        }
      }
    })
    .catch(function(error) {
      console.log(error);
    });
  });
</script>