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


}

?>