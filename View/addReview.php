<div class="container">
  <div class="form">
    <h2>Añadir reseña</h2>
    <form action="https://ordeplay.cifpceuta.com/index.php?action=doAddReview&idJuego=<?=$_GET['idJuego']?>" method="post" id="miFormulario">
      <div class="campo">
        <input type="number" min="0" max="5" name="nota" required id="nota">
        <label>Nota</label>
      </div>
      <div class="campo" id="lastCampo">
        <label>Opinión</label>
        <textarea name="opinion"></textarea>
      </div>
      <div class="loginButton">
        <button id="enviar">Añadir</button>
      </div>
    </form>
  </div>
</div>
<script>

  document.getElementById('nota').addEventListener('focus', function(){
    document.getElementById('nota').setAttribute('placeholder', 'De 0 a 5');
  });

  document.getElementById('nota').addEventListener('blur', function(){
    document.getElementById('nota').removeAttribute('placeholder');
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