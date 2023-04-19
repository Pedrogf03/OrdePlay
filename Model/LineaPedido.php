<?php

include_once "Pedido.php";
include_once "Videojuego.php";

class Linea{

  private int $idLinea;
  private int $cantidadProducto;
  private float $precioPorUnidad;
  private Pedido $pedido;

  public function __construct($idLinea, $cantidadProducto, $precioPorUnidad, $pedido){
    
    $this->idLinea = $idLinea;
    $this->cantidadProducto = $cantidadProducto;
    $this->precioPorUnidad = $precioPorUnidad;
    $this->pedido = $pedido;

  }

}

?>