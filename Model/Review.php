<?php

require_once "Cliente.php";

class Review {

  private $idCliente;
  private $idVideojuego;
  private $nota;
  private $opinion;

  public function __construct($idCliente, $idVideojuego, $nota, $opinion){

    $this->idCliente = $idCliente;
    $this->idVideojuego = $idVideojuego;
    $this->nota = $nota;
    $this->opinion = $opinion;

  }

  // Getters
  public function getIdCliente(){
    return $this->idCliente;
  }
  public function getIdVideojuego(){
    return $this->idVideojuego;
  }
  public function getNota(){
    return $this->nota;
  }
  public function getOpinion(){
    return $this->opinion;
  }

}

?>