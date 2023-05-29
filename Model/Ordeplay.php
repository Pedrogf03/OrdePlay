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

  public function addJuegoToLista($idJuego, $idLista = NULL) {

    if($idLista == NULL){
      $sql = "SELECT idLista FROM Lista WHERE idCliente = '". $_SESSION['idCliente'] ."' AND nombre = 'Favoritos'";
      $result = $this->connection->query($sql);

      if ($result->num_rows == 1) {
          
        $row = $result->fetch_assoc();
        $sql = "INSERT INTO ListaJuego (idVideojuego, idLista) VALUES ('$idJuego', '". $row['idLista'] ."')";

      } else {
        return false;
      }
    } else {

      $sql = "INSERT INTO ListaJuego (idVideojuego, idLista) VALUES ('$idJuego', '". $idLista ."')";

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

  public function crearLista($nombre, $descripcion){

    $sql = "SELECT * FROM Lista WHERE nombre = '$nombre' AND idCliente = " . $_SESSION['idCliente'];
    $result = $this->connection->query($sql);
    
    if ($result->num_rows == 0) {
    
      $sql = "INSERT INTO Lista (idCliente, nombre, descripcion) VALUES (" . $_SESSION['idCliente'] . ", '$nombre', '$descripcion')";
    
      if ($this->connection->query($sql)) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }

  }

  public function editarLista($idLista, $nombre, $descripcion){

    $sql = "SELECT nombre FROM Lista WHERE idLista = $idLista";
    $result = $this->connection->query($sql);
    $row = $result->fetch_assoc();

    $sql = "SELECT * FROM Lista WHERE nombre = '$nombre' AND nombre <> '" . $row['nombre'] . "' AND idCliente = " . $_SESSION['idCliente'];
    $result = $this->connection->query($sql);
    
    if ($result->num_rows == 0) {
    
      $sql = "UPDATE Lista SET nombre = '$nombre', descripcion = '$descripcion' WHERE idLista = $idLista";
    
      if ($this->connection->query($sql)) {
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }

  }

  public function borrarLista($idLista){

    $sql = "DELETE FROM ListaJuego WHERE idLista = ". $idLista;

    if($this->connection->query($sql)){
      $sql = "DELETE FROM Lista WHERE idLista = ". $idLista;

      if($this->connection->query($sql)){
        return true;
      } else {
        return false;
      }
    } else {
      return false;
    }

  }

  public function crearPedido($precioTotal, $idCliente) {
    $sql = "INSERT INTO Pedido (fecha, precioTotal, idCliente) VALUES (NOW(), $precioTotal, $idCliente)";

    if ($this->connection->query($sql)) {
        return $this->connection->insert_id;
    } else {
        return 0;
    }
}

  public function crearLineaPed($idVideojuego, $idPedido, $cantidad, $precioUnidad){

    $sql = "INSERT INTO LineaPedido (idVideojuego, idPedido, cantidad, precioUnidad) VALUES ($idVideojuego, $idPedido, $cantidad, $precioUnidad)";

    if($this->connection->query($sql)){
      return true;
    } else {
      return false;
    }

  }

  public function comprobarCVC($idTarjeta, $cvc){

    $sql = "SELECT * FROM Tarjeta WHERE idTarjeta = $idTarjeta";
    $result = $this->connection->query($sql);
    
    if ($result->num_rows == 0) {
      return false;
    } else {
      $row = $result->fetch_assoc();

      if($row['cvc'] == $cvc) {
        return true;
      } else {
        return false;
      }

    }

  }

  // Función que genera de forma aleatoria un código de 16 caracteres alfanuméricos separado cada 4 por un gión.
  public function generarCodigo() {
    $longitud = 16; // Longitud total del código
    $codigo = '';
    
    for ($i = 0; $i < $longitud; $i++) {
        // Generar un caracter aleatorio
        $caracter = chr(mt_rand(48, 57)); // Números: 0-9
        $caracter .= chr(mt_rand(65, 90)); // Letras mayúsculas: A-Z
        
        // Agregar el caracter al código
        $codigo .= $caracter[mt_rand(0, 1)];
        
        // Insertar guion cada 4 caracteres
        if (($i + 1) % 4 == 0 && $i != $longitud - 1) {
            $codigo .= '-';
        }
    }
    
    return $codigo;

  }

  // Función que añade a la biblioteca un juego y envía un mail al usuario con el código del juego que ha comprado.
  public function addToBiblioteca($idJuego){

    // Se genera un código y se hace una consulta para saber si ese código ya existe previamente.
    do {
      $code = $this->generarCodigo();
      $sql = "SELECT * FROM Biblioteca WHERE codigo = '$code'";
      $result = $this->connection->query($sql);
      // Si ya existe (es decir, si la consulta devuelve algún resultado), se va a repetir este proceso.
    } while ($result->num_rows != 0);

    // Se inserta en la tabla biblioteca un registro con el código, el id del juego al que pertenece y el id del usuario que lo ha comprado.
    $sql = "INSERT INTO Biblioteca (codigo, idVideojuego, idCliente) VALUES ('$code', '$idJuego', " . $_SESSION['idCliente'] . ")";
    if ($this->connection->query($sql)) {
  
      $juego = $this->getVideojuegoById($idJuego);
  
      switch ($juego->getIdPlataforma()) {
        case 1:
          $plataforma = "PlayStation";
          break;
        case 2:
          $plataforma = "Xbox";
          break;
        case 3:
          $plataforma = "PC";
          break;
        case 4:
          $plataforma = "Nintendo Switch";
          break;
      }
  
      // Se envía un mail al usuario con el código del juego que ha comprado.
      $destinatario = $_SESSION['email'];
      $asunto = "Código de activación de OrdePlay.";
      $cuerpo = '
      <html>
        <head>
          <title>Contraseña nueva</title>
        </head>
          <body>
            <p>Aquí tiene su código para activar ' . $juego->getNombre() . ' en ' . $plataforma . '</p>
            <h1> ' . $code . ' </h1>
            <p>Gracias por su compra.</p>
          </body>
      </html>
      ';
  
      // Para el envío en formato HTML
      $headers = "MIME-Version: 1.0\r\n";
      $headers .= "Content-type: text/html; charset=iso-8859-1\r\n";
  
      // Dirección del remitente
      $headers .= "From: OrdePlay <noreply@OrdePlay.com>\r\n";
  
      mail($destinatario, $asunto, $cuerpo, $headers);

      setcookie('carrito', '[]', time() + (365 * 24 * 60 * 60), '/'); // Se borra el carrito.

      return true;

    } else {

      return false;

    }
    
  }

  public function getJuegosFromBiblioteca($idCliente) {

    $sql = "SELECT * FROM Videojuego v JOIN Biblioteca b ON v.idVideojuego = b.idVideojuego WHERE b.idCliente = $idCliente";
    $result = $this->connection->query($sql);

    if($result->num_rows > 0) {
      
      $codigoJuego = array();

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

  public function addReview($idCliente, $idJuego, $nota, $opinion) {

    $sql = "INSERT INTO Review (idCliente, idVideojuego, nota, opinion) VALUES ('$idCliente', '$idJuego', '$nota', '$opinion')";

    try{
      if($this->connection->query($sql)){
        return true;
      }
    } catch (Exception $e) {
      return false;
    }

  }

  public function addJuegoToDeseados($idJuego) {

    $sql = "SELECT idLista FROM Lista WHERE idCliente = '". $_SESSION['idCliente'] ."' AND nombre = 'Deseados'";
    $result = $this->connection->query($sql);

    if ($result->num_rows == 1) {
          
      $row = $result->fetch_assoc();
      $sql = "INSERT INTO ListaJuego (idVideojuego, idLista) VALUES ('$idJuego', '". $row['idLista'] ."')";

    } else {
      return false;
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

}

?>