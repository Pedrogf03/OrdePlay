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
    
    $sql = "SELECT * FROM Videojuego WHERE nombre LIKE '%". $filtro ."%'"; // Consulta.

    $result = $this->connection->query($sql);

    if ($result->num_rows > 0) {
      $i = 0; // Variable para recorrer el array.

      while ($row = $result->fetch_assoc()) { 
        $this->videojuegos[$i] = new Videojuego($row['idVideojuego'], $row['nombre'], $row['descripcion'], $row['genero'], $row['precio'], $row['desarrollador'], $row['fechaLanzamiento'], $row['idPlataforma'], $row['img']); 
        $i++; 
      }

      return $this->videojuegos; 
    }

  }

  // Función que comprueba si un usuario existe o no en la base de datos.
  public function comprobarUser($email, $passwd){
    $sql = "SELECT * FROM Cliente WHERE email = '".$email."'"; // Consulta.
  
    $result = $this->connection->query($sql);
  
    if ($result->num_rows == 0) {
      return false; // Si no devuelve nada, es que no existe el email en la base de datos.
    } else {
      // Si devuelve algo, se comprueba que el email sea correcto y la contraseña, ecnriptada, coincida con la que hay en la base de datos.
      $row = $result->fetch_assoc();
      if($row['email'] == $email && password_verify($passwd, $row['passwd'])) {
        $_SESSION['idCliente'] = $row['idCliente'];
        $_SESSION['usuario'] = $row['usuario'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['picture'] = $row['picture'];
        return true;
      } else {
        return false;
      }
    }
  }
  

  // Función que inserta un usuario en la base de datos.
  public function insertUser($email, $user, $passwd){
    $sql = "SELECT email FROM Cliente WHERE email = '".$email."'"; // Consulta.
    $result = $this->connection->query($sql);
  
    if ($result->num_rows == 0) { // Si no devuelve nada, es que no existe el email en la base de datos.
      $passwd_hash = password_hash($passwd, PASSWORD_DEFAULT); // Se encripta la contraseña.
  
      $sql = "INSERT INTO Cliente (email, usuario, passwd) VALUES ('$email', '$user', '$passwd_hash')"; // Consulta.
  
      if ($this->connection->query($sql)) {

        $sql = "SELECT * FROM Cliente WHERE email = '".$email."'"; // Consulta.
        $result = $this->connection->query($sql);
        $row = $result->fetch_assoc();
        // Se crean variables de sesión con los datos del usuario.
        $_SESSION['idCliente'] = $row['idCliente'];
        $_SESSION['usuario'] = $row['usuario'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['picture'] = $row['picture'];

        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  public function validarEmail($email) {

    $sql = "SELECT idCliente, email FROM Cliente WHERE email = '$email'"; // Consulta.
    $result = $this->connection->query($sql);

    if($result->num_rows != 1){
      return false;
    } else {
      $row = $result->fetch_assoc();
      if($row['idCliente'] != $_SESSION['idCliente']) {
        return false;
      } else {
        return true;
      }
    }

  }

  // Función que verifica si el nuevo email existe y actualiza la base de datos.
  public function cambiarEmail($new, $old) {

    $sql = "SELECT email FROM Cliente WHERE email = '$new'";
    $result = $this->connection->query($sql);

    if($result->num_rows == 0){
      $sql = "UPDATE Cliente SET email = '$new' WHERE email = '$old'";
      if($this->connection->query($sql)){
        $_SESSION['email'] = $new;
        return true;
      }
    } else {
      return false;
    }

  }

  // Función que comprueba que la contraseña sea correcta y actualiza la base de datos.
  public function cambiarPasswd($new, $old) {

    $sql = "SELECT passwd FROM Cliente WHERE idCliente = '". $_SESSION['idCliente'] ."'";
    $result = $this->connection->query($sql);
    $row = $result->fetch_assoc();

    if(password_verify($old, $row['passwd'])) {
      $passwd_hash = password_hash($new, PASSWORD_DEFAULT);
      $sql = "UPDATE Cliente SET passwd = '$passwd_hash' WHERE idCliente = '". $_SESSION['idCliente'] ."'";
      if($this->connection->query($sql)){
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }

  }

  // Función que cambia el usuario.
  public function cambiarUser($user) {
    $sql = "UPDATE Cliente SET usuario = '$user' WHERE idCliente = '". $_SESSION['idCliente'] ."'";
    if($this->connection->query($sql)){
      $_SESSION['usuario'] = $user;
      return true;
    } else {
      return false;
    }
  }

  public function cambiarFoto($foto){

    $sql = "UPDATE Cliente SET picture = '$foto' WHERE idCliente = '". $_SESSION['idCliente'] ."'";
    if($this->connection->query($sql)){
      $_SESSION['picture'] = $foto;
      return true;
    } else {
      return false;
    }

  }

}

?>