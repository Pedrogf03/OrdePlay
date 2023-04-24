<?php

// Iniciamos la sesión 
session_start();

// Archivos necesarios
require_once 'Config/config.php';
require_once 'Model/db.php';
require_once 'Model/Cliente.php';
require_once 'Model/LineaPedido.php';
require_once 'Model/Lista.php';
require_once 'Model/Pedido.php';
require_once 'Model/Plataforma.php';
require_once 'Model/Tarjeta.php';
require_once 'Model/Videojuego.php';
require_once 'Model/VideojuegoPlataforma.php';
require_once 'Controller/Controller.php';

// Si no hay definida una acción, se pone la por defecto, definida en config/config.php
if (!isset($_GET["action"])) $_GET["action"] = constant("DEFAULT_ACTION");

// Crea un objeto controlador, para controlar las acciones que se quieran tomar.
$controlador = new Controller();

// Se crea un array que conenga todos los datos necesarios para cada acción.
$datos = array();
$datos = $controlador->{$_GET["action"]}(); // Llamada a las funciones del controlador, a través de la variable get action.

/* Includes */
include_once 'view/templates/header.php';
include_once 'view/' . $controlador->getVista() . '.php'; // Incluye la vita concreta, necesaria en cada momento, dependiendo del atrubuto view del objeto noteController.
include_once 'view/templates/footer.php';


?>