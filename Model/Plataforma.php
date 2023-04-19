<?php

class Plataforma{

  private int $idPlataforma;
  private string $nombre;
  private string $desarrollador;

  public function __construct($idPlataforma, $nombre, $desarrollador){
    
    $this->idPlataforma = $idPlataforma;
    $this->nombre = $nombre;
    $this->desarrollador = $desarrollador;

  }

}

?>