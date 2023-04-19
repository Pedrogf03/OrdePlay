<?php

class Lista{

  private int $idLista;
  private string $nombre;
  private string $descipcion;

  public function __construct($idLista, $nombre, $descipcion){
    
    $this->idLista = $idLista;
    $this->nombre = $nombre;
    $this->descipcion = $descipcion;

  }
  
}

?>