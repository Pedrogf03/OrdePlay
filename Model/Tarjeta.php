<?php

include_once "Cliente.php";

class Tarjeta{

  private $idTarjeta;
  private $numeroTarjeta;
  private  $fechaExp;
  private $cvc;
  private $nombreTitular;
  private $idCliente;

  public function __construct($idTarjeta, $numeroTarjeta, $fechaExp, $cvc, $nombreTitular, $idCliente){
    
    $this->idTarjeta = $idTarjeta;
    $this->numeroTarjeta = $numeroTarjeta;
    $this->fechaExp = $fechaExp;
    $this->cvc = $cvc;
    $this->nombreTitular = $nombreTitular;
    $this->idCliente = $idCliente;

  }

  // Getters
  public function getIdTarjeta(){
    return $this->idTarjeta;
  }
  public function getNumTarjeta(){
    return $this->numeroTarjeta;
  }
  public function getFechaExp(){
    return $this->fechaExp;
  }
  public function getCvc(){
    return $this->cvc;
  }
  public function getTitular(){
    return $this->nombreTitular;
  }

}

?>