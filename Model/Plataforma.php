<?php

class Plataforma{

  private $idPlataforma;
  private $nombre;
  private $desarrollador;

  public function __construct($idPlataforma, $nombre, $desarrollador){
    
    $this->idPlataforma = $idPlataforma;
    $this->nombre = $nombre;
    $this->desarrollador = $desarrollador;

  }

}

?>