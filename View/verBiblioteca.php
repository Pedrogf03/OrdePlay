<div class="container">
  <div class="verLista">
    <h1>Biblioteca</h1>
    <p>Juegos que he comprado.</p>
    <hr />
    <div class="juegos"> <!-- Div que almacena todos los juegos. -->
    <?php
    foreach($datos as $codigo => $idJuego){ // Por cada juego.
      $juego = $controlador->getJuegoById($idJuego);
      switch ($juego->getIdPlataforma()){ // Dependiendo del idPlataforma del juego, se muestra un icono u otro.
        case 1:
          $plataforma = '<i class="fa-brands fa-playstation"></i>';
          break;
        case 2:
          $plataforma = '<i class="fa-brands fa-xbox"></i>';
          break;
        case 3:
          $plataforma = '<i class="fa-solid fa-desktop"></i>';
          break;
        case 4:
          $plataforma = '<img class="nintendoIcon" src="img/icons/nintendo.svg">';
          break;
      }
    ?>
      <div class="juego"> <!-- Div que contiene toda la información de un juego. -->
        <a href="index.php?action=verJuego&idJuego=<?=$juego->getIdVideojuego()?>">
          <img class="portada" src="<?=$juego->getImg()?>" alt="Portada del juego" id="imgJuego"/> 
          <div class="info">
            <h3><?=$juego->getNombre()?>&nbsp;<?=$plataforma?></h3>
            <p><?=$juego->getDescripcion()?></span></p>
          </div>
          <div>
            <p><?=$juego->getPrecio()?>€</p>
          </div>
        </a>
      </div>
      <a href="index.php?action=addReview&idJuego=<?=$idJuego?>" class="addReview">Añadir reseña</a>
    <?php
    }
    ?>
    </div>
  </div>
</div>