<div class="container">
  <div class="form">
    <?php
    if($cliente->getMetodosPago() != 0){
      if(isset($_POST['escogerTarjeta'])){
        $num = $_POST['escogerTarjeta'];
      } else {
        $num = 0;
      }
    ?>
    <form action="https://ordeplay.cifpceuta.com/index.php?action=comprobarCVC&idTarjeta=<?=$cliente->getMetodosPago()[$num]->getIdTarjeta()?>" method="post" id="miFormulario">
      <div class="tarjeta">
        <h2>Tarjeta de crédito / débito</h2>
        <div class="infoTarjeta">
          <div class="campo1">
            <p>Numero de la tarjeta</p>
            <p><?=$cliente->getMetodosPago()[$num]->getNumTarjetaOcult()?></p>
          </div>
          <div class="campo2">
            <label>Fecha de expiración</label>
            <input type="date" name="FechaExp" value="<?=$cliente->getMetodosPago()[$num]->getFechaExp()?>">
          </div>
          <div class="campo3" id="lastCampo">
            <label>CVC</label>
            <input type="text" name="cvc" maxlength="3">
          </div>
        </div>
        <a href="index.php?action=escogerTarjeta">Usar otra tarjeta</a>
      </div>
      <?php
    } else {
    ?>
    <form action="https://ordeplay.cifpceuta.com/index.php?action=saveTarjeta" method="post" id="miFormulario">
      <div class="tarjeta">
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
    <?php
    }
    ?>
      <div class="comprar">
        <div><p>Precio total</p> <p><?=$datos?>€</p></div>
        <button>Pagar</button>
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