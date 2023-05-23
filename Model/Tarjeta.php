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

  // Función que devuelve el numero de la tarjeta de credito ocultando los primeros 12 digitos.
  public function getNumTarjetaOcult(){
    // Generar una cadena de "X" con una longitud de 12
    $sustitucion = str_repeat("X", 12);

    // Obtener los últimos 4 dígitos del número
    $ultimosDigitos = substr($this->numeroTarjeta, -4);

    // Sustituir los primeros 12 dígitos por "X"
    $numeroOculto = $sustitucion . $ultimosDigitos;

    // Agregar guiones después de cada grupo de 4 dígitos
    $numeroFormateado = implode("-", str_split($numeroOculto, 4));

    return $numeroFormateado;
  }

}

?>