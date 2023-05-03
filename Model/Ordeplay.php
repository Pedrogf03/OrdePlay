<?php

include_once './Videojuego.php';

class OrdePlay{

  private $connection;
  private array $videojuegos;

  function __construct(){
		$this->getConection();
	}

  // Conexión con la Base de Datos.
  public function getConection(){

		$dbObj = new Db(); // Crea un objeto Base de datos.
		$this->connection = $dbObj->connection; // Almacena el objeto en una propiedad de este objeto.

	}

    // Función que devuelve una array con todos los videojuegos de la base de datos.
    public function getVideojuegos() {

      $sql = "SELECT * FROM Videojuego"; // Consulta
      $result = $this->connection->query($sql);

      if ($result->num_rows > 0) {
        $i = 0; // Variable para recorrer el array.

        while ($row = $result->fetch_assoc()) { // Se recorre cada fila de la tabla.
          $this->videojuegos[$i] = new Videojuego($row['idVideojuego'], $row['nombre'], $row['descripcion'], $row['genero'], $row['precio'], $row['desarrollador'], $row['fechaLanzamiento'], $row['idPlataforma'], $row['img']); 
          $i++; 
        }

        return $this->videojuegos; // Devuelve el array con todos los videojuegos.
      }

  }

}

?>