<?php

class Cliente {

  private $idCliente;
  private $usuario;
  private $email;
  private $password;
  private $picture;
  private $metodosPago;
  private $listas;
  private $connection;

  public function __construct($idCliente, $usuario, $email, $password, $picture = NULL){

    $this->idCliente = $idCliente;
    $this->usuario = $usuario;
    $this->email = $email;
    $this->password = $password;
    $this->picture = $picture;

    $this->metodosPago = array();
    $this->listas = array();

    $dbObj = new Db(); // Crea un objeto Base de datos.
		$this->connection = $dbObj->connection; // Almacena el objeto en una propiedad de este objeto.

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

  public function getMetodosPago(){

    $sql = "SELECT * FROM Tarjeta WHERE idCliente = ". $this->idCliente;

    $result = $this->connection->query($sql);

    if($result->num_rows == 0){
      return 0;
    } else {
      $i = 0;
      while($row = $result->fetch_assoc()){
        $this->metodosPago[$i] = new Tarjeta($row['idTarjeta'], $row['numero'], $row['fechaExp'], $row['cvc'], $row['titular'], $row['idCliente']);
        $i++;
      }
      return $this->metodosPago;
    }

  }

  public function getListas() {

    $sql = "SELECT * FROM Lista WHERE idCliente = ". $_SESSION['idCliente'];

    $result = $this->connection->query($sql);

    if($result->num_rows == 0){
      return 0;
    } else {
      $i = 0;
      while($row = $result->fetch_assoc()){
        $this->listas[$i] = new Lista($row['idLista'], $row['idCliente'], $row['nombre'], $row['descripcion']);
        $i++;
      }
      return $this->listas;
    }

  }

}

