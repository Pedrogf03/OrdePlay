<div class="container">
  <div class="form">
    <h2>Añadir tarjeta de crédito</h2>
    <form action="https://ordeplay.cifpceuta.com/index.php?action=saveTarjeta" method="post" id="miFormulario">
      <div class="campo">
        <input type="text" name="numTarjeta" required id="numTarjeta">
        <label>Número de la Tarjeta</label>
      </div>
      <div class="campo">
        <input type="date" name="fechaExp" required id="fechaExp">
      </div>
      <div class="campo">
        <input type="text" name="cvc" required id="cvc">
        <label>CVC</label>
      </div>
      <div class="campo" id="lastCampo">
        <input type="text" name="nombreTit" required id="nombreTit">
        <label>Nombre del Titular</label>
      </div>
      <div class="loginButton">
        <button id="enviar">Guardar Tarjeta</button>
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
        window.location.href = "https://ordeplay.cifpceuta.com?action=configUser";
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
</script>