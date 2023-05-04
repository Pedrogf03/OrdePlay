<?php

class Cliente {

  private $idCliente;
  private $usuario;
  private $email;
  private $password;
  private $picture;

  public function __construct($idCliente, $usuario, $email, $password, $picture = NULL){

    $this->idCliente = $idCliente;
    $this->usuario = $usuario;
    $this->email = $email;
    $this->password = $password;
    $this->picture = $picture;

  }

  // Getters

  public function getIdCliente(){
    return $this->idCliente;
  }
  public function getUsuario(){
    return $this->usuario;
  }
  public function getEmail(){
    return $this->email;
  }
  public function getPassword(){
    return $this->password;
  }

  public function getPicture(){
    return $this->picture;
  }

}