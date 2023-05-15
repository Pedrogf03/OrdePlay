<?php

include_once './config/config.php';
include_once './Model/Ordeplay.php';

class Controller {

  public string $vista;
  public string $titulo;
  public string $css;
  public $OrdePlay;

  public function __construct(){

    $this->vista = constant("DEFAULT_ACTION"); // Por defecto, al iniciar, la vista será la predeterminada.
    $this->css = constant("DEFAULT_ACTION"); // Por defecto, al iniciar, el css será el predeterminado.
    $this->titulo = constant("DEFAULT_TITLE"); // Por defecto, al iniciar, el título será el predeterminado.

    $this->OrdePlay = new OrdePlay();
    
  }

  // Vista que muestra todos los juegos de la base de datos.
  public function web(){

    $this->vista = "web";
    $this->css = "web"; 

    return $this->OrdePlay->getVideojuegos();

  }

  // Vista que muestra todos los juegos de PlayStation de la base de datos.
  public function webPlay(){

    $this->vista = "web";
    $this->css = "web"; 

    return $this->OrdePlay->getVideojuegos(1);

  }

  // Vista que muestra todos los juegos de Xbox de la base de datos.
  public function webXbox(){

    $this->vista = "web";
    $this->css = "web"; 

    return $this->OrdePlay->getVideojuegos(2);

  }

  // Vista que muestra todos los juegos de PC de la base de datos.
  public function webPC(){

    $this->vista = "web";
    $this->css = "web"; 

    return $this->OrdePlay->getVideojuegos(3);

  }

  // Vista que muestra todos los juegos de Nintendo de la base de datos.
  public function webNintendo(){

    $this->vista = "web";
    $this->css = "web"; 

    return $this->OrdePlay->getVideojuegos(4);

  }

  // Vista que muestra todos los juegos filtrados por el nombre.
  public function buscaJuegos(){

    $this->vista = "web";
    $this->css = "web"; 

    return $this->OrdePlay->buscaJuegos($_POST['filtro']);

  }

  // Vista de inicio de sesión del usuario.
  public function logIn(){

    // Se comprueba si ya hay iniciada una sesión, te lleva a la página principal.
    if(isset($_SESSION['cliente'])) {
      return $this->web();
    } else {
      // Si no, te lleva a la vista de inicio de sesión.
      $this->vista = "logIn";
      $this->css = "logIn"; 
    }

  }

  // Función que recibe los datos de inicio de sesión, verifica que cumplan los requisitos y devuelve una respuesta.
  public function doLogIn(){

    // Si el método de envío de los datos es POST.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = trim($_POST['email']); // Quitar espacios al principio y al final.
      $passwd = trim($_POST['passwd']); // Quitar espacios al principio y al final.
    
      // Se valida el email mediante un expresión regular.
      if (!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $email)) {
        // Si el email es correcto, continúa; si no, devuelve un mensaje de error en formato json.
        $respuesta = array('exito' => false, 'mensaje' => 'El email no es válido.');
        echo json_encode($respuesta);
        // Y para la ejecución.
        exit;
      }

      // Se valida la contraseña mediante una expresión regular.
      if (!preg_match("/^[a-zA-Z0-9!@#$%^&*()_+=[\]{}|\\;:'\",.<>\/?]{6,50}$/", $passwd)) {
        // Si la contraseña es correcta, continúa; si no, devuelve un mensaje de error en formato json.
        $respuesta = array('exito' => false, 'mensaje' => 'La contraseña no es válida.');
        echo json_encode($respuesta);
        // Y para la ejecución.
        exit;
      }
    
      // Se comprueban los credenciales de inicio de sesión.
      if(!$this->OrdePlay->comprobarUser($email, $passwd)){
        // Si son correctos, continúa; si no, devuelve un mensaje de error en formato json.
        $respuesta = array('exito' => false, 'mensaje' => 'Email o contraseña incorrectos.');
        echo json_encode($respuesta);
        // Y para la ejecución.
        exit;
      }
    
      // Si todo ha ido bien, devuele un mensaje de confirmación en formato json.
      $respuesta = array('exito' => true, 'mensaje' => 'Los datos han sido procesados correctamente.');
      echo json_encode($respuesta);
      // Y para la ejecución.
      exit;
    }

  }

  // Vista de creación del usuario.
  public function crearUser(){
    
    // Se comprueba si ya hay iniciada una sesión, te lleva a la página principal.
    if(isset($_SESSION['idCliente'])) {
      return $this->web();
    } else {
      // Si no, te lleva a la vista de creación de usuario.
      $this->vista = "crearUser";
      $this->css = "crearUser"; 
    }

  }

  // Función que recibe los datos de creación de usuario, verifica que cumplan los requisitos y devuelve una respuesta.
  public function doCrearUser(){

    // Si el método de envío de los datos es POST.
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = trim($_POST['email']); // Quitar espacios al principio y al final.
      $user = trim($_POST['user']); // Quitar espacios al principio y al final.
      $passwd = trim($_POST['passwd']); // Quitar espacios al principio y al final.
      $passwd2 = trim($_POST['passwd2']); // Quitar espacios al principio y al final.
      
      // Se valida el email mediante un expresión regular.
      if (!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $email)) {
        $respuesta = array('exito' => false, 'mensaje' => 'El email no es válido.');
        echo json_encode($respuesta);
        exit;
      }

      // Se valida el nombre de usuario mediante un expresión regular.
      if (!preg_match("/^[a-zA-Z0-9._]{5,20}$/", $user)) {
        $respuesta = array('exito' => false, 'mensaje' => 'El nombre de usuario no es válido.');
        echo json_encode($respuesta);
        exit;
      }
      
      // Se valida la contraseña mediante un expresión regular.
      if (!preg_match("/^[a-zA-Z0-9!@#$%^&*()_+=[\]{}|\\;:'\",.<>\/?]{6,50}$/", $passwd)) {
        $respuesta = array('exito' => false, 'mensaje' => 'La contraseña no es válida.');
        echo json_encode($respuesta);
        exit;
      }

      // Se comprueba que la contraseña y la confirmación de la misma sean iguales.
      if($passwd != $passwd2) {
        $respuesta = array('exito' => false, 'mensaje' => 'Las contraseñas no coinciden.');
        echo json_encode($respuesta);
        exit;
      }
      
      // Se inserta el usuario en la base de datos.
      if(!$this->OrdePlay->insertUser($email, $user, $passwd)){
        $respuesta = array('exito' => false, 'mensaje' => 'Ese email ya existe.');
        echo json_encode($respuesta);
        exit;
      }
      
      // Se envía una respuesta de confirmación.
      $respuesta = array('exito' => true, 'mensaje' => 'Los datos han sido procesados correctamente.');
      echo json_encode($respuesta);
      exit;
    }
  
  }

  // Función que borra las variables de sesión y la cierra.
  public function cerrarSesion() {
    // Vacía las variables de sesión del cliente.
    $_SESSION['idCliente'] = "";
    $_SESSION['usuario'] = "";
    $_SESSION['email'] = "";
    $_SESSION['passwd'] = "";
    $_SESSION['picture'] = "";
    // Se cierra sesión.
    session_destroy();
    // Y muestra la página principal.
    return $this->web();
  }

  // Vista de edición del usuario.
  public function configUser(){

    // Se comprueba si hay una sesión iniciada.
    if(!isset($_SESSION['idCliente'])) {
      // Si no, te lleva a la vista de loggin.
      return $this->logIn();
    } else {
      // Si si la hay, te lleva a la página de configuración de usuario.
      $this->vista = "configUser";
      $this->css = "configUser"; 
    }
  
  }

  // Función que valida el cambio del email del usuario y envía una respuesta.
  public function cambiarEmail() {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $oldEmail = trim($_POST['oldEmail']); // Quitar espacios al principio y al final.
      $newEmail = trim($_POST['newEmail']); // Quitar espacios al principio y al final.
      $repeatEmail = trim($_POST['repeatEmail']); // Quitar espacios al principio y al final.
        
      // Validación de los datos mediante expresiones regulares.
      if (!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $newEmail)) {
        $respuesta = array('exito' => false, 'mensaje' => 'El nuevo email no es válido.');
        echo json_encode($respuesta);
        exit;
      }

      // Comprobación de que el email y la repetición del mismo coincidan.
      if($newEmail != $repeatEmail){
        $respuesta = array('exito' => false, 'mensaje' => 'Los emails no coinciden.');
        echo json_encode($respuesta);
        exit;
      }
  
      // Comprobación de que el email antiguo corresponda al usuario.
      if(!$this->OrdePlay->validarEmail($oldEmail)){
        $respuesta = array('exito' => false, 'mensaje' => 'Email incorrecto.');
        echo json_encode($respuesta);
        exit;
      }

      // Actualiza la base de datos con el nuevo email.
      if(!$this->OrdePlay->cambiarEmail($newEmail, $oldEmail)){
        // Si no se inserta, devuelve un json de error.
        $respuesta = array('exito' => false, 'mensaje' => 'Ese correo ya existe.');
        echo json_encode($respuesta);
        exit;
      }
        
      // Respuesta confirmando el éxito.
      $respuesta = array('exito' => true, 'mensaje' => 'Email cambiado con éxito.');
      echo json_encode($respuesta);
      exit;
    }

  }

  // Función que valida el cambio de la contraseña del usuario y envía una respuesta.
  public function cambiarPasswd() {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $oldPasswd = trim($_POST['oldPasswd']); // Quitar espacios al principio y al final.
      $newPasswd = trim($_POST['newPasswd']); // Quitar espacios al principio y al final.
      $repeatPasswd = trim($_POST['repeatPasswd']); // Quitar espacios al principio y al final.
      
      // Validación de los datos mediante expresiones regulares.
      if (!preg_match("/^[a-zA-Z0-9!@#$%^&*()_+=[\]{}|\\;:'\",.<>\/?]{6,50}$/", $newPasswd)) {
        $respuesta = array('exito' => false, 'mensaje' => 'La nueva contraseña no es válida.');
        echo json_encode($respuesta);
        exit;
      }

      // Confirmación de que la contraseña y la confirmación de la misma coinciden.
      if($newPasswd != $repeatPasswd){
        $respuesta = array('exito' => false, 'mensaje' => 'Las contraseñas no coinciden.');
        echo json_encode($respuesta);
        exit;
      }

      // Comprueba la contraseña del usuario y, si es correcta, la cambia.
      if(!$this->OrdePlay->cambiarPasswd($newPasswd, $oldPasswd)){
        $respuesta = array('exito' => false, 'mensaje' => 'Contraseña incorrecta.');
        echo json_encode($respuesta);
        exit;
      }
      
      // Respuesta de éxtio en formato json.
      $respuesta = array('exito' => true, 'mensaje' => 'Contraseña cambiada con éxito.');
      echo json_encode($respuesta);
      exit;
    }

  }

  // Función que valida el cambio de usuario del usuario y envía una respuesta.
  public function cambiarUser() {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $user = trim($_POST['user']); // Quitar espacios al principio y al final.
          
      // Validación de los datos mediante expresiones regulares.
      if (!preg_match("/^[a-zA-Z0-9._]{5,20}$/", $user)) {
        $respuesta = array('exito' => false, 'mensaje' => 'Usuario no válido.');
        echo json_encode($respuesta);
        exit;
      }
    
      // Se actualiza la base de datos con el nuevo usuario.
      if(!$this->OrdePlay->cambiarUser($user)){
        $respuesta = array('exito' => false, 'mensaje' => 'Error inesperado.');
        echo json_encode($respuesta);
        exit;
      }
          
      // Respuesta de éxito en formato json.
      $respuesta = array('exito' => true, 'mensaje' => 'Usuario cambiado con éxito.');
      echo json_encode($respuesta);
      exit;
    }
    
  }

  // Función que valida el cambio de foto de perfil del usuario y envía una respuesta.
  public function cambiarFoto(){

    $destino = "./img/userIcons/"; // Directorio dónde se guardan las fotos de perfil.
    $archivo = $destino . "iconUser" . $_SESSION['idCliente']; // Ruta completa con el nombre que va a tener la foto.

    // Obtener la extensión del archivo subido
    $extension = strtolower(pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION));

    // Verificar si la extensión es válida
    $allowedExtensions = array("jpg", "jpeg", "png"); // Extensiones válidas.
    if (!in_array($extension, $allowedExtensions)) { // Si la extensión del archivo no está entre las válidas.
      // Devuelve un json de error.
      $respuesta = array('exito' => false, 'mensaje' => 'Solo se permiten archivos PNG, JPG y JPEG.');
      echo json_encode($respuesta);
      // Y para la ejecución.
      exit;
    }

    // Borrar el archivo si ya existe.
    if (file_exists($archivo)) {
      unlink($archivo .".png");
      unlink($archivo .".jpg");
      unlink($archivo .".jpeg");
    }

    // Mover el archivo subido a la carpeta de destino.
    $archivo = $archivo . "." . $extension; // Ruta completa del archivo añadiendole la extensión.
    if (!move_uploaded_file($_FILES["picture"]["tmp_name"], $archivo)) {
      // Si ocurre algún error subiendo el archivo, se devuelve un json con un mensaje.
      $respuesta = array('exito' => false, 'mensaje' => 'Error al subir el archivo.');
      echo json_encode($respuesta);
      // Y para la ejecución.
      exit;
    }

    // Actualiza la base de datos.
    $this->OrdePlay->cambiarFoto($archivo);

    // Respuesta de conformación.
    $respuesta = array('exito' => true, 'mensaje' => 'Foto cambiada con éxito.');
    echo json_encode($respuesta);
    exit;

  }

  // Función que lleva a la vista que muestra información del juego.
  public function verJuego(){

    $this->vista = "verJuego";
    $this->css = "verJuego"; 

    return $this->OrdePlay->getVideojuegoById($_GET['idJuego']);

  }

}

?>