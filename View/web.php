<div class="container"> <!-- Div que contiene toda la vista. -->
  <div class="juegos"> <!-- Div que almacena todos los juegos. -->
  <?php
  foreach($datos as $juego){ // Por cada juego.
  ?>

    <div class="juego"> <!-- Div que contiene toda la información de un juego. -->
      <img class="portada" src="<?=$juego->getImg()?>" alt="Portada del juego"> 
      <?php
      switch ($juego->getIdPlataforma()){ // Dependiendo del idPortada del juego, se muestra un icono u otro.
        case 1:
          ?>
          <i class="fa-brands fa-playstation"></i>
          <?php
          break;
        case 2:
          ?>
          <i class="fa-brands fa-xbox"></i>
          <?php
          break;
        case 3:
          ?>
          <img class="nintendoIcon" src="img/icons/nintendo.svg">
          <?php
          break;
        case 4:
          ?>
          <i class="fa-solid fa-desktop"></i>
          <?php
          break;
      }
      ?>
      <div><p><?=$juego->getNombre()?></p><p><?=$juego->getPrecio()?>€</p></div>
    </div>

  <?php
  }
  ?>
  </div>
</div>