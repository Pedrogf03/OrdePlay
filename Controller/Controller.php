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

  public function web(){

    $this->vista = "web";
    $this->css = "web"; 
    $this->titulo = "OrdePlay"; 

    return $this->OrdePlay->getVideojuegos();

  }

}

?>