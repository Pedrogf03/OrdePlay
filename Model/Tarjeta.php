<?php

include_once "Cliente.php";

class Tarjeta{

  private int $idTarjeta;
  private string $numeroTarjeta;
  private string $fechaExp;
  private int $cvc;
  private string $nombreTitular;
  private Cliente $cliente;

  public function __construct($idTarjeta, $numeroTarjeta, $fechaExp, $cvc, $nombreTitular, $cliente){
    
    $this->idTarjeta = $idTarjeta;
    $this->numeroTarjeta = $numeroTarjeta;
    $this->fechaExp = $fechaExp;
    $this->cvc = $cvc;
    $this->nombreTitular = $nombreTitular;
    $this->cliente = $cliente;

  }

}

?>