<?php

include_once "Plataforma.php";
include_once "Videojuego.php";

class VideojuegoPlataforma{

  private Plataforma $plataforma;
  private Videojuego $videojuego;
  private string $codigo;


  public function __construct($plataforma, $videojuego, $codigo){
    
    $this->plataforma = $plataforma;
    $this->videojuego = $videojuego;
    $this->codigo = $codigo;

  }

}

?>