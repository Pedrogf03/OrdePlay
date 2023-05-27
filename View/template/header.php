<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Este css es para la cabecera de la página -->
    <link rel="stylesheet" href="./View/css/header.css" />
    <!-- El título y el css se cargan dependiendo de la vista -->
    <title><?= $controlador->titulo; ?></title>
    <link rel="stylesheet" href="./View/css/<?= $controlador->css; ?>.css" />
    <!-- Icono de la página -->
    <link rel="icon" href="./img/logo.png" />
    <!-- Conexión con ajax -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Conexión con Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Sans:wght@300;400;700&family=Press+Start+2P&display=swap" rel="stylesheet">
    <!-- Conexión con FontAwesome -->
    <script src="https://kit.fontawesome.com/3915de76d4.js" crossorigin="anonymous"></script>
  </head>
  <?php
    if($_SESSION['idCliente'] != NULL){
      $cliente = new Cliente($_SESSION['idCliente'], $_SESSION['usuario'], $_SESSION['email'], $_SESSION['picture']);
    }
  ?>
  <body>
    <!-- Cabecera de la página -->
    <header>
      <div>
        <div class="contenedor_icono_burger icono_barras">
          <span class=""></span>
          <span class=""></span>
          <span class=""></span>
        </div>
        <a class="inicio" href="index.php?action=web"><img src="img/logo.png" alt="Logotipo de la página."></a>
      </div>
      <div>
        <nav>
          <ul>
            <a href="index.php?action=webPC"><li class="pc"><i class="fa-solid fa-desktop"></i><p>PC</p></li></a>
            <a href="index.php?action=webPlay"><li class="ps"><i class="fa-brands fa-playstation"></i><p>PlayStation</p></li></a>
            <a href="index.php?action=webXbox"><li class="xbox"><i class="fa-brands fa-xbox"></i><p>Xbox</p></li></a>
            <a href="index.php?action=webNintendo"><li class="nintendo"><img class="nintendoIcon" src="img/icons/nintendo.svg"><p>Nintendo</p></li></a>
          </ul>
        </nav>
      </div>
      <div>
        <a href="index.php?action=verCarrito"><i class="fa-solid fa-cart-shopping"></i></a>
          <?php
          if($_SESSION['idCliente'] != NULL){
            if($_SESSION['picture'] == NULL){
              echo "<a href='index.php?action=configUser'><i class='fa-solid fa-circle-user'></i></i></a>";
            } else {
              echo "<a href='index.php?action=configUser'><img src='". $_SESSION['picture'] ."'></a>";
            }
          } else {
            echo "<a href='index.php?action=logIn'><i class='fa-regular fa-circle-user'></i></a>";
          }
          ?>
      </div>
    </header>
    <div class="desplegable off">
      <div class="listas">
        <div class="lista">
          <a href="index.php?action=crearLista">
            <p>Crear lista</p>
          </a>
        </div>
        <div class="lista">
          <a href="index.php?action=verBiblioteca">
            <p>Biblioteca</p>
          </a>
        </div>
        <?php
        if($_SESSION['idCliente'] != NULL){
          for($m = 0; $m < count($cliente->getListas()); $m++){
            ?>
            <div class="lista">
              <a href="index.php?action=verLista&idLista=<?=$cliente->getListas()[$m]->getIdLista()?>">
                <p><?=$cliente->getListas()[$m]->getNombre()?></p>
              </a>
              <?php
              if($cliente->getListas()[$m]->getNombre() != 'Favoritos' AND $cliente->getListas()[$m]->getNombre() != 'Deseados'){
                ?>
                <a href="index.php?action=borrarLista&idLista=<?=$cliente->getListas()[$m]->getIdLista()?>">
                  <i class="fa-solid fa-xmark"></i>
                </a>
                <?php
              }
              ?>
            </div>
            <?php
          }
        }
        ?>
      </div>
      <div class="bottom">
        <div><a href="index.php?action=cerrarSesion"><i class="fa-solid fa-arrow-right-from-bracket"></i>&nbsp;Cerrar sesión</a></div>
        <div><a href="index.php?action=configUser"><i class="fa-solid fa-gear"></i>&nbsp;Configuración</a></div>
      </div>
    </div>
