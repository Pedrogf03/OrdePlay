<div class="container"> <!-- Div que contiene toda la vista. -->
  <div class="juegos"> <!-- Div que almacena todos los juegos. -->
  <?php
  foreach($datos as $juego){ // Por cada juego.
  ?>

    <a href="">
    <div class="juego"> <!-- Div que contiene toda la información de un juego. -->
      <img class="portada" src="<?=$juego->getImg()?>" alt="Portada del juego"> 
      <?php
      switch ($juego->getIdPlataforma()){ // Dependiendo del idPortada del juego, se muestra un icono u otro.
        case 1:
          ?>
          <div class="plataforma"><i class="fa-brands fa-playstation"></i></div>
          <?php
          break;
        case 2:
          ?>
          <div class="plataforma"><i class="fa-brands fa-xbox"></i></div>
          <?php
          break;
        case 3:
          ?>
          <div class="plataforma"><i class="fa-solid fa-desktop"></i></div>
          <?php
          break;
        case 4:
          ?>
          <div class="plataforma"><img class="nintendoIcon" src="img/icons/nintendo.svg"></div>
          <?php
          break;
      }
      ?>
      <div class="info"><p><?=$juego->getNombre()?></p><p><?=$juego->getPrecio()?>€</p></div>
    </div>
    </a>

  <?php
  }
  ?>
  </div>
</div>