<?php

include_once 'config/config.php';

class Controller {

  private string $vista;
  private string $titulo;
  private string $css;

  public function __construct(){

    $this->vista = constant("DEFAULT_ACTION"); // Por defecto, al iniciar, la vista será la predeterminada.
    
  }

}

?>