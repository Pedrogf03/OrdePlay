<?php

include_once "Cliente.php";

class Pedido {

  private $idPedido;
  private $fechaPedido;
  private $precioTotal;
  private $cliente;

  public function __construct($idPedido, $fechaPedido, $precioTotal, $cliente){

    $this->idPedido = $idPedido;
    $this->fechaPedido = $fechaPedido;
    $this->precioTotal = $precioTotal;
    $this->cliente = $cliente;

  }

}