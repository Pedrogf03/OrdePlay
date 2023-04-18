<?php

class Cliente {

  private int $idCliente;
  private string $usuario;
  private string $email;
  private string $password;

  public function __construct($idCliente, $usuario, $email, $password){

    $this->idCliente = $idCliente;
    $this->usuario = $usuario;
    $this->email = $email;
    $this->password = $password;

  }

}