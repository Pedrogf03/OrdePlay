<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- El título y el css se cargan dependiendo de la vista -->
    <title><?= $controlador->titulo; ?></title>
    <link rel="stylesheet" href="view/css/<?= $controlador->css; ?>.css" />
    <!-- Este css es para la cabecera de la página -->
    <link rel="stylesheet" href="view/css/header.css" />
    <link rel="icon" href="img/logo.png" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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
            <li>PC</li>
            <li>Xbox</li>
            <li>PlayStation</li>
            <li>Nintendo</li>
          </ul>
        </nav>
      </div>
      <div>
        <div class="contenedor_icono_burger icono_barras">
          <span class=""></span>
          <span class=""></span>
          <span class=""></span>
        </div>
        <img src="img/logo.png" alt="Logotipo de la página.">
      </div>
    </header>
