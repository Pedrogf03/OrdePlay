<?php

include_once "db.php";

class Videojuego{

  private $idVideojuego;
  private $nombre;
  private $descripcion;
  private $genero;
  private $precio;
  private $desarrollador;
  private $fechaLanzamiento;
  private $idPlataforma;
  private $img;
  private $reviews;
  private $connection;

  public function __construct($idVideojuego, $nombre, $descripcion, $genero, $precio, $desarrollador, $fechaLanzamiento, $idPlataforma, $img){
    
    $this->idVideojuego = $idVideojuego;
    $this->nombre = $nombre;
    $this->descripcion = $descripcion;
    $this->genero = $genero;
    $this->precio = $precio;
    $this->desarrollador = $desarrollador;
    $this->fechaLanzamiento = $fechaLanzamiento;
    $this->idPlataforma = $idPlataforma;
    $this->img = $img;
    
    $this->reviews = array();

    $dbObj = new Db(); // Crea un objeto Base de datos.
		$this->connection = $dbObj->connection; // Almacena el objeto en una propiedad de este objeto.

  }

  // Getters
  public function getIdVideojuego(){
    return $this->idVideojuego;
  }
  public function getNombre(){
    return $this->nombre;
  }
  public function getDescripcion(){
    return $this->descripcion;
  }
  public function getGenero(){
    return $this->genero;
  }
  public function getPrecio(){
    return $this->precio;
  }
  public function getDesarrollador(){
    return $this->desarrollador;
  }
  public function getFechaLanzamiento(){
    return $this->fechaLanzamiento;
  }
  public function getIdPlataforma(){
    return $this->idPlataforma;
  }
  public function getImg(){
    return $this->img;
  }

  public function getReviews(){
    $sql = "SELECT * FROM Review WHERE idVideojuego = " . $this->getIdVideojuego();
    $result = $this->connection->query($sql);
  
    if ($result->num_rows > 0) {
      $i = 0;
      while ($row = $result->fetch_assoc()) {
        $sql2 = "SELECT * FROM Cliente WHERE idCliente = " . $row['idCliente'];
        $result2 = $this->connection->query($sql2);
        $row2 = $result2->fetch_assoc();
  
        $cliente = new Cliente($row2['idCliente'], $row2['usuario'], $row2['email'], null, $row2['picture']);

        $this->reviews[$i] = new Review($cliente, $row['idVideojuego'], $row['nota'], $row['opinion']);
        $i++;
      }
      return $this->reviews;
    } else {
      return false;
    }
  }

  public function isInLista($nombreLista){

    $sql = "SELECT * FROM ListaJuego lj JOIN Lista l ON lj.idLista = l.idLista WHERE lj.idVideojuego = '". $this->getIdVideojuego() ."' AND l.nombre = '$nombreLista' AND l.idCliente = '". $_SESSION['idCliente'] ."'";

    $result = $this->connection->query($sql);

    if($result->num_rows == 1) {
      return true;
    } else {
      return false;
    }

  }

}

?>