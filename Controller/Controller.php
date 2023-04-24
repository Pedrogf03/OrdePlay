<?php

include_once 'config/config.php';

class Controller {

  public string $vista;
  public string $titulo;
  public string $css;

  public function __construct(){

    $this->vista = constant("DEFAULT_ACTION"); // Por defecto, al iniciar, la vista será la predeterminada.
    $this->css = constant("DEFAULT_ACTION"); // Por defecto, al iniciar, la vista será la predeterminada.
    $this->titulo = constant("DEFAULT_TITLE"); // Por defecto, al iniciar, la vista será la predeterminada.
    
  }

  public function web(){

    $this->vista = "web";
    $this->css = "web"; // Por defecto, al iniciar, la vista será la predeterminada.
    $this->titulo = "SocialGaming"; // Por defecto, al iniciar, la vista será la predeterminada.

  }

}

?>