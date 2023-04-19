<?php

class Videojuego{

  private int $idVideojuego;
  private string $nombre;
  private string $descripcion;
  private string $genero;
  private float $precio;
  private string $desarrollador;
  private string $fechaLanzamiento;

  public function __construct($idVideojuego, $nombre, $descripcion, $genero, $precio, $desarrollador,$fechaLanzamiento){
    
    $this->idVideojuego = $idVideojuego;
    $this->nombre = $nombre;
    $this->descripcion = $descripcion;
    $this->genero = $genero;
    $this->precio = $precio;
    $this->desarrollador = $desarrollador;
    $this->fechaLanzamiento = $fechaLanzamiento;

  }

}

?>