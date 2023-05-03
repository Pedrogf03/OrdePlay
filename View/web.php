<div class="container">
  <div class="juegos">
  <?php
  foreach($datos as $juego){
  ?>

    <div class="juego">
      <img class="portada" src="<?=$juego->getImg()?>" alt="Portada del juego">
      <?php
      switch ($juego->getIdPlataforma()){
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