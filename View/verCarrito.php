<div class="container">
  <div class="infoCarrito">
    <div class="carrito">
      <?php      
      $carrito = $_COOKIE['carrito'];

      // Decodificar el string JSON en un arreglo de PHP
      $arrayCarrito = json_decode($carrito, true);
      
      // Crear un arreglo asociativo para contar las repeticiones de cada idVideojuego
      $contador = array();

      // Recorrer el arreglo y realizar una acción para cada idVideojuego
      foreach ($arrayCarrito as $idVideojuego) {
        // Incrementar el contador para el idVideojuego actual
        if (isset($contador[$idVideojuego])) {
            $contador[$idVideojuego]++;
        } else {
            $contador[$idVideojuego] = 1;
        }
      }

      // Mostrar los idVideojuegos y el recuento, mostrando solo uno cuando se repiten tres veces
      foreach ($contador as $idVideojuego => $cantidad) {
      
        $juego = $controlador->OrdePlay->getVideojuegoById($idVideojuego);

        ?>
        <div class="juego">
          <img src="<?=$juego->getImg()?>" />
          <div class="infoJuego">
            <?php
            switch ($juego->getIdPlataforma()){ // Dependiendo del idPlataforma del juego, se muestra un icono u otro.
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
                <i class="fa-solid fa-desktop"></i>
                <?php
                break;
              case 4:
                ?>
                <img class="nintendoIcon" src="img/icons/nintendo.svg">
                <?php
                break;
            }
            ?>
            <p><?=$juego->getNombre()?></p>
            <div class="borrar">
              <a href="">
                <i class="fa-solid fa-xmark"></i>
              </a>
              <p>|</p>
              <a href="">Añadir a deseados</a>
            </div>
          </div>
          <div class="precioCantidad"></div>
        </div>
        <?php

      }
      ?>
    </div>
    <div class="comprar">
      <p>hola</p>
    </div>
  </div>
</div>