<?php

class Cliente {

  private $idCliente;
  private $usuario;
  private $email;
  private $password;
  private $picture;
  private $metodosPago;
  private $listas;
  private $reviews;
  private $connection;

  public function __construct($idCliente, $usuario, $email, $password, $picture = NULL){

    $this->idCliente = $idCliente;
    $this->usuario = $usuario;
    $this->email = $email;
    $this->password = $password;
    $this->picture = $picture;

    $this->metodosPago = array();
    $this->listas = array();
    $this->reviews = array();

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

  // Funcion que devuelve todas las tarjetas asociadas al usuario.
  public function getMetodosPago(){

    $sql = "SELECT * FROM Tarjeta WHERE idCliente = ". $this->idCliente; // Consulta.

    $result = $this->connection->query($sql); // Se ejecuta la consulta.

    // Si no devuelve nada, la funcion devuelve 0.
    if($result->num_rows == 0){
      return 0;
    } else {
      // Si devuelve algo, se rellena el array de metodosPago
      $i = 0;
      while($row = $result->fetch_assoc()){
        $this->metodosPago[$i] = new Tarjeta($row['idTarjeta'], $row['numero'], $row['fechaExp'], $row['cvc'], $row['titular'], $row['idCliente']);
        $i++;
      }
      // Una vez relleno, se devuelve
      return $this->metodosPago;
    }

  }

  // Funcion que devuelve las listas asociadas al usuario.
  public function getListas() {

    $sql = "SELECT * FROM Lista WHERE idCliente = ". $_SESSION['idCliente']; // Consulta

    $result = $this->connection->query($sql); // Ejecucion de la consulta

    // Si no devuelve nada, la funcion devuelve 0.
    if($result->num_rows == 0){
      return 0;
    } else {
      // Si devuelve algo, se rellena el array listas 
      $i = 0;
      while($row = $result->fetch_assoc()){
        $this->listas[$i] = new Lista($row['idLista'], $row['idCliente'], $row['nombre'], $row['descripcion']);
        $i++;
      }
      // Devuelve el array
      return $this->listas;
    }

  }

  // Funcion que devuelve los pedidos hechos por el usuario.
  public function getPedidos(){

    // Consulta
    $sql = "SELECT * FROM Videojuego v JOIN Biblioteca b ON v.idVideojuego = b.idVideojuego WHERE b.idCliente = ". $this->idCliente;
    $result = $this->connection->query($sql); // Ejecucion de la consulta

    // Se comprueba si devuelve algo
    if($result->num_rows > 0) {
      
      // Crea una rray
      $codigoJuego = array();

      // Se va rellenando el array con los datos de la consulta.
      while($row = $result->fetch_assoc()){

        $codigo = $row['codigo'];
        $idVideojuego = $row['idVideojuego'];

        $codigoJuego[$codigo] = $idVideojuego;

      }

      return $codigoJuego;

    } else {
      return false;
    }

  }

  // Funcion que devuelve las reseñas hechas por el usuario
  public function getReviews(){

    // Consulta
    $sql = "SELECT * FROM Review WHERE idCliente = ". $this->idCliente;
    $result = $this->connection->query($sql); // Ejecucion

    // Se comprueba si devuelve algo
    if($result->num_rows > 0) {
      
      $i = 0;
      // Se va rellenando el array con los datos de la consulta.  
      while($row = $result->fetch_assoc()){

        $this->reviews[$i] = new Review($this, $row['idVideojuego'], $row['nota'], $row['opinion']);
        $i++;

      }

      return $this->reviews;

    } else {
      return false;
    }

  }

}

