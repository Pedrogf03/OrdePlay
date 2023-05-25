<?php

require_once "Cliente.php";

class Review {

  private Cliente $cliente;
  private $idVideojuego;
  private $nota;
  private $opinion;

  public function __construct($cliente, $idVideojuego, $nota, $opinion){

    $this->cliente = $cliente;
    $this->idVideojuego = $idVideojuego;
    $this->nota = $nota;
    $this->opinion = $opinion;

  }

  // Getters
  public function getCliente(){
    return $this->cliente;
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