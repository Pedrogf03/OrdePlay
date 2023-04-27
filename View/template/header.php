<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- El título y el css se cargan dependiendo de la vista -->
    <title><?= $controlador->titulo; ?></title>
    <link rel="stylesheet" href="./View/css/<?= $controlador->css; ?>.css" />
    <!-- Este css es para la cabecera de la página -->
    <link rel="stylesheet" href="./View/css/header.css" />
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
  
  <body>
    <!-- Cabecera de la página -->
    <header>
      <div>
        <div class="contenedor_icono_burger icono_barras">
          <span class=""></span>
          <span class=""></span>
          <span class=""></span>
        </div>
        <img src="img/logo.png" alt="Logotipo de la página.">
      </div>
      <div>
        <nav>
          <ul>
            <li class="pc"><i class="fa-solid fa-desktop"></i>&nbsp;PC</li>
            <li class="ps"><i class="fa-brands fa-playstation"></i>&nbsp;PlayStation</li>
            <li class="xbox"><i class="fa-brands fa-xbox"></i>&nbsp;Xbox</li>
            <li class="nintendo"><img class="nintendoIcon" src="img/icons/nintendo.svg">&nbsp;Nintendo</li>
          </ul>
        </nav>
      </div>
      <div>
        <i class="fa-solid fa-cart-shopping"></i>
        <div class="profilePicture"></div>
      </div>
    </header>
    <div class="desplegable off">
        <div class="listas">
          <i class="fa-solid fa-bookmark"></i>
          <p>Biblioteca</p>
          <i class="fa-solid fa-heart"></i>
          <p>Favoritos</p>
          <i class="fa-solid fa-cloud"></i>
          <p>Deseados</p>
          <i class="fa-solid fa-circle-plus"></i>
          <p>Crear lista</p>
        </div>
        <div class="config"><i class="fa-solid fa-gear"></i>&nbsp;Configuración</div>
    </div>
