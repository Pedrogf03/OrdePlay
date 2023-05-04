<?php

include_once './config/config.php';
include_once './Model/Ordeplay.php';

class Controller {

  public string $vista;
  public string $titulo;
  public string $css;
  public $OrdePlay;

  public function __construct(){

    $this->vista = constant("DEFAULT_ACTION"); // Por defecto, al iniciar, la vista será la predeterminada.
    $this->css = constant("DEFAULT_ACTION"); // Por defecto, al iniciar, la vista será la predeterminada.
    $this->titulo = constant("DEFAULT_TITLE"); // Por defecto, al iniciar, la vista será la predeterminada.

    $this->OrdePlay = new OrdePlay();
    
  }

  // Función que devuelve todos los juegos de la base de datos.
  public function web(){

    $this->vista = "web";
    $this->css = "web"; 
    $this->titulo = "OrdePlay"; 

    return $this->OrdePlay->getVideojuegos();

  }

  // Función que devuelve todos los juegos de PlayStation de la base de datos.
  public function webPlay(){

    $this->vista = "web";
    $this->css = "web"; 
    $this->titulo = "OrdePlay"; 

    return $this->OrdePlay->getVideojuegos(1);

  }

  // Función que devuelve todos los juegos de Xbox de la base de datos.
  public function webXbox(){

    $this->vista = "web";
    $this->css = "web"; 
    $this->titulo = "OrdePlay"; 

    return $this->OrdePlay->getVideojuegos(2);

  }

  // Función que devuelve todos los juegos de PC de la base de datos.
  public function webPC(){

    $this->vista = "web";
    $this->css = "web"; 
    $this->titulo = "OrdePlay"; 

    return $this->OrdePlay->getVideojuegos(3);

  }

  // Función que devuelve todos los juegos de Nintendo de la base de datos.
  public function webNintendo(){

    $this->vista = "web";
    $this->css = "web"; 
    $this->titulo = "OrdePlay"; 

    return $this->OrdePlay->getVideojuegos(4);

  }

  public function buscaJuegos(){

    $this->vista = "web";
    $this->css = "web"; 
    $this->titulo = "OrdePlay"; 

    return $this->OrdePlay->buscaJuegos($_POST['filtro']);

  }

}

?>