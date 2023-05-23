<div class="container">
  <div class="tarjetas">
    <h2>Escoger tarjeta</h2>
    <form action="index.php?action=pagarCarrito" method="POST">
      <?php
      $tarjetas = $cliente->getMetodosPago();
      for($i = 0; $i < count($tarjetas); $i++) {
      ?>
      <div class="tarjeta">
        <div>
          <p>Numero de la tarjeta:</p>
          <p><?=$tarjetas[$i]->getNumTarjetaOcult()?></p>
          <p>Titular:</p>
          <p><?=$tarjetas[$i]->getTitular()?></p>
          <p>Fecha de expiración:</p>
          <p><?=$tarjetas[$i]->getFechaExp()?></p>
        </div>
        <input type="radio" name="escogerTarjeta" value="<?=$i?>">
      </div>
      <?php
      }
      ?>
      <input type="submit" value="Escoger" class="elegir">
    </form>
  </div>
</div>