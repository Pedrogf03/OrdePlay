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

      if(func_num_args() == 0) {
        $sql = "SELECT * FROM Videojuego"; // Consulta
      } else {
        $sql = "SELECT * FROM Videojuego WHERE idPlataforma = ". func_get_args()[0] ."";
      }

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

  // Función que devuelve una array con todos los videojuegos de la base de datos que cumplan con el filtro.
  public function buscaJuegos($filtro) {
    
    $sql = "SELECT * FROM Videojuego WHERE nombre LIKE '%". $filtro ."%'"; // Consulta

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

  public function comprobarUser($email, $passwd){

    $sql = "SELECT email, passwd FROM Cliente WHERE email = ".$email.""; // Consulta.

    $result = $this->connection->query($sql);

    if ($result->num_rows == 0) {
      return false; // Si no devuelve nada, es que no existe el email en la base de datos.
    } else {

      // Si devuelve algo, se comprueba que el email sea correcto y la contraseña, ecnriptada, coincida con la que hay en la base de datos.
      $row = $result->fetch_assoc();
      if($row['email'] == $email && !password_verify($passwd, $row['passwd'])) {
        return true;
      } else {
        return false;
      }

    }

  }

}

?>