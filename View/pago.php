<div class="container">
  <div class="form">
    <form action="https://ordeplay.cifpceuta.com/index.php?action=saveTarjeta" method="post" id="miFormulario">
    <?php
    if($cliente->getMetodosPago() != 0){

    } else {
    ?>
      <div class="addTarjeta">
      <h2>Tarjeta de crédito / débito</h2>
        <div class="campo">
          <input type="text" name="numTarjeta" required id="numTarjeta">
          <label>Número de la Tarjeta</label>
        </div>
        <div class="campo">
          <input type="text" name="nombreTit" required id="nombreTit">
          <label>Nombre del Titular</label>
        </div>
        <div class="campo">
          <input type="date" name="fechaExp" required id="fechaExp">
        </div>
        <div class="campo">
          <input type="text" name="cvc" required id="cvc">
          <label>CVC</label>
        </div>
        <div class="saveTarjeta" id="lastCampo">
          <label>Gurdar tarjeta para futuras compras</label>
          <input type="checkbox" name="guardar" />
        </div>
      </div>
      <div class="comprar">
        <div><p>Precio total</p> <p><?=$datos?>€</p></div>
        <button>Pagar</button>
      </div>
    <?php
    }
    ?>
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