<div class="container">
  <div class="infoJuego">
    <div class="left">
      <img src="<?=$datos->getImg()?>" />
      <?php
      switch ($datos->getIdPlataforma()){ // Dependiendo del idPlataforma del juego, se muestra un icono u otro.
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
      <div><h2><?=$datos->getNombre()?></h2><span><i class="fa-regular fa-heart"></i>&nbsp;&nbsp;&nbsp;<i class="fa-solid fa-plus"></i></span></div>
      <p><?=$datos->getDescripcion()?></p>
    </div>
    <div class="right">
      <p><?=$datos->getPrecio()?>€</p>
      <button>Añadir al carrito</button>
    </div>
  </div>
  <div class="reviews">
    <?php
    if($datos->getReviews()){
      for($i = 0; $i < count($datos->getReviews()); $i++){
        ?>
        <div class="review">
          <img src="<?=$datos->getReviews()[$i]->getCliente()->getPicture()?>" />
          <div class="infoReview">
            <h3><?=$datos->getReviews()[$i]->getCliente()->getUsuario()?></h3>
            <p><?=$datos->getReviews()[$i]->getOpinion()?></p>
          </div>
          <div class="nota">
            <?php
            switch ($datos->getReviews()[$i]->getNota()){ // Dependiendo de la nota del juego, se muestran unos iconos u otros.
              case 0:
                ?>
                <i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i>
                <?php
                break;
              case 1:
                ?>
                <i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i>
                <?php
                break;
              case 2:
                ?>
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i>
                <?php
                break;
              case 3:
                ?>
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i><i class="fa-regular fa-star"></i>
                <?php
                break;
              case 4:
                ?>
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-regular fa-star"></i>
                <?php
                break;
              case 5:
                ?>
                <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                <?php
                break;
            }
            ?>
          </div>
        </div>
        <?php
      }
    }
    ?>
  </div>
</div>
