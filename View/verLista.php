<div class="container">
  <div class="lista">
    <?php
    $lista = $controlador->getListaById($_GET['idLista']);
    ?>
    <h1><?=$lista->getNombre()?></h1>
    <hr />
    <div class="juegos"> <!-- Div que almacena todos los juegos. -->
    <?php
    foreach($datos as $juego){ // Por cada juego.
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
            <p><?=$juego->getDescripcion()?></p>
          </div>
          <div>
            <p><?=$juego->getPrecio()?>€</p>
          </div>
          </a>
          <a href="index.php?action=removeJuegoFromLista&idJuego=<?=$juego->getIdVideojuego()?>&idLista=<?=$lista->getIdLista()?>" class="borrar">
            <i class="fa-solid fa-xmark"></i>
          </a>
      </div>
    <?php
    }
    ?>
    </div>
  </div>
</div>
