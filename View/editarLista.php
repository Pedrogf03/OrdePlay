<div class="container">
  <div class="form">
    <h2>Editar lista</h2>
    <form action="https://ordeplay.cifpceuta.com/index.php?action=doEditarLista" method="post" id="miFormulario">
      <div class="campo">
        <input type="text" name="nombreLista" required id="nombreLista" value="<?=$datos->getNombre()?>">
        <label>Nombre</label>
      </div>
      <div class="campo" id="lastCampo">
        <label>Descripción</label>
        <textarea name="descripcion"><?=$datos->getDescripcion()?></textarea>
        <input type="hidden" name="idLista" value="<?=$datos->getIdLista()?>">
      </div>
      <div class="loginButton">
        <button id="enviar">Actualizar</button>
      </div>
    </form>
  </div>
</div>
<script>

  // Mostrar placeholders al tener el foco y quitarlo al perderlo.
  document.getElementById('nombreLista').addEventListener('focus', function(){
    document.getElementById('nombreLista').setAttribute('placeholder', 'Jugados');
  });
  document.getElementById('nombreLista').addEventListener('blur', function(){
    document.getElementById('nombreLista').removeAttribute('placeholder');
  });

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