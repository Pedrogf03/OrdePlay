<?php

class Lista{

  private $idLista;
  private $idCliente;
  private $nombre;
  private $descripcion;

  public function __construct($idLista, $idCliente, $nombre, $descripcion){
    
    $this->idLista = $idLista;
    $this->idCliente = $idCliente;
    $this->nombre = $nombre;
    $this->descripcion = $descripcion;

  }

  // Getters
  public function getIdLista(){
    return $this->idLista;
  }
  public function getIdCliente(){
    return $this->idCliente;
  }
  public function getNombre(){
    return $this->nombre;
  }
  public function getDescripcion(){
    return $this->descripcion;
  }
  
}

?>