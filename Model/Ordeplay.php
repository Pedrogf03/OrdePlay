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

    // Si no hay argumentos, la consulta selecciona todos los juegos.
    if(func_num_args() == 0) {
      $sql = "SELECT * FROM Videojuego"; 
    } else {
      // Si lo hay, selecciona los juegos cuyo id haya sido pasado como parámetro.
      $sql = "SELECT * FROM Videojuego WHERE idPlataforma = ". func_get_args()[0] ."";
    }

    // Ejecuta la consulta.
    $result = $this->connection->query($sql);

    // Si ha devuelto algún registro.
    if ($result->num_rows > 0) {
      $i = 0; // Variable para recorrer el array.

      // Mientras sigan habiendo registros.
      while ($row = $result->fetch_assoc()) { 
        // Se añade al array de videojuegos un nuevo juego con todos los datos traídos de la base de datos.
        $this->videojuegos[$i] = new Videojuego($row['idVideojuego'], $row['nombre'], $row['descripcion'], $row['genero'], $row['precio'], $row['desarrollador'], $row['fechaLanzamiento'], $row['idPlataforma'], $row['img']); 
        $i++; // Aumenta el iterador.
      }

      // Una vez se han acabado los registros y se ha rellenado el array, se devuelve.
      return $this->videojuegos; // Devuelve el array con todos los videojuegos.
    }

  }

  // Función que devuelve una array con todos los videojuegos de la base de datos que cumplan con el filtro.
  public function buscaJuegos($filtro) {
    
    // Consulta con un filtro 'buscador'.
    $sql = "SELECT * FROM Videojuego WHERE nombre LIKE '%". $filtro ."%'"; // Consulta.

    // Resultado de la consulta.
    $result = $this->connection->query($sql);

    // Recorrer cada fila y rellenar el array.
    if ($result->num_rows > 0) {
      $i = 0; // Variable para recorrer el array.

      while ($row = $result->fetch_assoc()) { 
        $this->videojuegos[$i] = new Videojuego($row['idVideojuego'], $row['nombre'], $row['descripcion'], $row['genero'], $row['precio'], $row['desarrollador'], $row['fechaLanzamiento'], $row['idPlataforma'], $row['img']); 
        $i++; 
      }

      // Devolver el array.
      return $this->videojuegos; 
    }

  }

  // Función que comprueba si un usuario existe o no en la base de datos.
  public function comprobarUser($email, $passwd){

    $sql = "SELECT * FROM Cliente WHERE email = '".$email."'"; // Consulta.
  
    // Resultado de la consulta.
    $result = $this->connection->query($sql);
  
    if ($result->num_rows == 0) {
      return false; // Si no devuelve nada, es que no existe el email en la base de datos.
    } else {
      // Si devuelve algo, se comprueba que el email sea correcto y la contraseña, ecnriptada, coincida con la que hay en la base de datos.
      $row = $result->fetch_assoc();
      if($row['email'] == $email && password_verify($passwd, $row['passwd'])) {
        // Crea variables de sesión con cada dato del usuario.
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
  
      // Consulta de inserción en base de datos con los datos del usuario.
      $sql = "INSERT INTO Cliente (email, usuario, passwd) VALUES ('$email', '$user', '$passwd_hash')"; 
  
      // Si se ha insertado correctamente.
      if ($this->connection->query($sql)) {

        $sql = "SELECT * FROM Cliente WHERE email = '".$email."'"; // Consulta.
        $result = $this->connection->query($sql);
        $row = $result->fetch_assoc();
        // Se crean variables de sesión con los datos del usuario.
        $_SESSION['idCliente'] = $row['idCliente'];
        $_SESSION['usuario'] = $row['usuario'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['picture'] = $row['picture'];

        $sql = "INSERT INTO Lista (idCliente, nombre, descripcion) VALUES ('".$row['idCliente']."', 'Favoritos', 'Los juegos que más me gustan.'), ('".$row['idCliente']."', 'Deseados', 'Los juegos que quiero comprar.')"; 
        $result = $this->connection->query($sql);

        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }
  }

  // Función que, dado un email, comprueba si existe y si corresponde al usuario activo.
  public function validarEmail($email) {

    $sql = "SELECT idCliente, email FROM Cliente WHERE email = '$email'"; // Consulta.
    $result = $this->connection->query($sql);

    if($result->num_rows != 1){
      return false; 
    } else {
      $row = $result->fetch_assoc();
      // Si el idCliente de la BBDD no coincide con el que hay en la variable de sesión.
      if($row['idCliente'] != $_SESSION['idCliente']) {
        return false; // Devuelve false.
      } else {
        return true; // Si si coincide, devuelve true.
      }
    }

  }

  // Función que verifica si el nuevo email existe y actualiza la base de datos.
  public function cambiarEmail($new, $old) {

    $sql = "SELECT email FROM Cliente WHERE email = '$new'"; // Consulta para comprobar que el nuevo email no exista.
    $result = $this->connection->query($sql);

    if($result->num_rows == 0){ // Si no existe aún, actualiza el usuario con el nuevo email.
      $sql = "UPDATE Cliente SET email = '$new' WHERE email = '$old'";
      if($this->connection->query($sql)){
        $_SESSION['email'] = $new; // Si se actualiza correctamente, se cambia la variable de sesión.
        return true;
      }
    } else {
      return false;
    }

  }

  // Función que comprueba que la contraseña sea correcta y actualiza la base de datos.
  public function cambiarPasswd($new, $old) {

    $sql = "SELECT passwd FROM Cliente WHERE idCliente = '". $_SESSION['idCliente'] ."'"; // Selecciona la contraseña del usuario.
    $result = $this->connection->query($sql);
    $row = $result->fetch_assoc();

    if(password_verify($old, $row['passwd'])) { // Si la contraseña, encriptada, coincide con la que ha introducido el usuario.
      $passwd_hash = password_hash($new, PASSWORD_DEFAULT); // Encripta la nueva contraseña.
      // Actualiza el cliente con la nueva contraseña.
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

  // Función que actualiza en la base de datos el nombre de usuario.
  public function cambiarUser($user) {
    $sql = "UPDATE Cliente SET usuario = '$user' WHERE idCliente = '". $_SESSION['idCliente'] ."'";
    if($this->connection->query($sql)){
      $_SESSION['usuario'] = $user;
      return true;
    } else {
      return false;
    }
  }

  // Función que cambia la foto (ruta donde está guardada) en la base de datos.
  public function cambiarFoto($foto){

    $sql = "UPDATE Cliente SET picture = '$foto' WHERE idCliente = '". $_SESSION['idCliente'] ."'";
    if($this->connection->query($sql)){
      $_SESSION['picture'] = $foto;
      return true;
    } else {
      return false;
    }

  }

  public function borrarTarjeta($id){

    $sql = "DELETE FROM Tarjeta WHERE idTarjeta = $id";

    if($this->connection->query($sql)){
      return true;
    } else {
      return false;
    }

  }

  public function guardarTarjeta($idCliente, $numero, $fechaExp, $cvc, $nombreTit) {

    $sql = "INSERT INTO Tarjeta (idCliente, numero, fechaExp, cvc, titular) VALUES ('$idCliente', '$numero', '$fechaExp', '$cvc', '$nombreTit')";
    if ($this->connection->query($sql)) {
        return true;
    } else {
        return false;
    }

  }

  // Función que, dado un idVideojuego, devuelve toda la iformación del mismo.
  public function getVideojuegoById($id){

    $sql = "SELECT * FROM Videojuego WHERE idVideojuego = ". $id;
    $result = $this->connection->query($sql);

    if ($result->num_rows == 1) {

      $row = $result->fetch_assoc();
      return new Videojuego($row['idVideojuego'], $row['nombre'], $row['descripcion'], $row['genero'], $row['precio'], $row['desarrollador'], $row['fechaLanzamiento'], $row['idPlataforma'], $row['img']); 

    }

  }

  public function addJuegoToFav($id, $nombre) {

    $sql = "SELECT idLista FROM Lista WHERE idCliente = '". $_SESSION['idCliente'] ."' AND nombre = '$nombre'";
    $result = $this->connection->query($sql);

    if ($result->num_rows == 1) {
        
      $row = $result->fetch_assoc();
      $sql = "INSERT INTO ListaJuego (idVideojuego, idLista) VALUES ('$id', '". $row['idLista'] ."')";

      try{
        if ($this->connection->query($sql)) {
          return true;
        } else {
          return false;
        }
      } catch(Exception $e) {
        return false;
      }

    }

    return false;

  }

  public function removeJuegoFromLista($idJuego, $idLista = null) {

    if($idLista == null){

      $sql = "SELECT idLista FROM Lista WHERE idCliente = '". $_SESSION['idCliente'] ."' AND nombre = 'Favoritos'";
      $result = $this->connection->query($sql);

      if ($result->num_rows == 1) {
          
        $row = $result->fetch_assoc();
        $sql = "DELETE FROM ListaJuego WHERE idVideojuego = $idJuego AND idLista = ". $row['idLista'];

      } else {
        return false;
      }

    } else {
      
      $sql = "DELETE FROM ListaJuego WHERE idVideojuego = $idJuego AND idLista = ". $idLista;

    }

    try{

      if ($this->connection->query($sql)) {
        return true;
      } else {
        return false;
      }

    } catch(Exception $e) {

      return false;

    }

  }

  public function verLista($idLista){

    $sql = "SELECT * FROM Videojuego v JOIN ListaJuego lj ON v.idVideojuego = lj.idVideojuego WHERE lj.idLista = $idLista";
    $result = $this->connection->query($sql);

    if($result->num_rows > 0){

      $juegos = array();
      $i = 0;

      while($row = $result->fetch_assoc()){

        $juegos[$i] = new Videojuego($row['idVideojuego'], $row['nombre'], $row['descripcion'], $row['genero'], $row['precio'], $row['desarrollador'], $row['fechaLanzamiento'], $row['idPlataforma'], $row['img']);
        $i++;

      }

      return $juegos;

    } else {
      return false;
    }

  }

  public function getListaById($idLista){

    $sql = "SELECT * FROM Lista WHERE idLista = $idLista";
    $result = $this->connection->query($sql);

    if($result->num_rows > 0){

      $row = $result->fetch_assoc();
      return new Lista($row['idLista'], $row['idCliente'], $row['nombre'], $row['descripcion']);

    } else {
      return false;
    }

  }

}

?>