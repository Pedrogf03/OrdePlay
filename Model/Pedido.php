<?php

include_once "Cliente.php";

class Pedido {

  private int $idPedido;
  private string $fechaPedido;
  private float $precioTotal;
  private Cliente $cliente;

  public function __construct($idPedido, $fechaPedido, $precioTotal, $cliente){

    $this->idPedido = $idPedido;
    $this->fechaPedido = $fechaPedido;
    $this->precioTotal = $precioTotal;
    $this->cliente = $cliente;

  }

}