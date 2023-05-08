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
    $this->titulo = constant("DEFAULT_TITLE"); // Por defecto, al iniciar, la vista será la predeterminada.

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

    if(isset($_SESSION['cliente'])) {
      return $this->web();
    } else {
      $this->vista = "logIn";
      $this->css = "logIn"; 
    }

  }

  // Función que recibe los datos de inicio de sesión, verifica que cumplan los requisitos y devuelve una respuesta.
  public function doLogIn(){

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = trim($_POST['email']); // Quitar espacios al principio y al final.
      $passwd = trim($_POST['passwd']); // Quitar espacios al principio y al final.
    
      // Validación de los datos.
      if (!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $email)) {
        $respuesta = array('exito' => false, 'mensaje' => 'El email no es válido.');
        echo json_encode($respuesta);
        exit;
      }

      if (!preg_match("/^[a-zA-Z0-9!@#$%^&*()_+=[\]{}|\\;:'\",.<>\/?]{6,50}$/", $passwd)) {
        $respuesta = array('exito' => false, 'mensaje' => 'La contraseña no es válida.');
        echo json_encode($respuesta);
        exit;
      }
    
      // Procesamiento de los datos.
      if(!$this->OrdePlay->comprobarUser($email, $passwd)){
        $respuesta = array('exito' => false, 'mensaje' => 'Email o contraseña incorrectos.');
        echo json_encode($respuesta);
        exit;
      }
    
      // Respuesta
      $respuesta = array('exito' => true, 'mensaje' => 'Los datos han sido procesados correctamente.');
      echo json_encode($respuesta);
      exit;
    }

  }

  // Vista de creación del usuario.
  public function crearUser(){
    
    if(isset($_SESSION['idCliente'])) {
      return $this->web();
    } else {
      $this->vista = "crearUser";
      $this->css = "crearUser"; 
    }

  }

  // Función que recibe los datos de creación de usuario, verifica que cumplan los requisitos y devuelve una respuesta.
  public function doCrearUser(){

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = trim($_POST['email']); // Quitar espacios al principio y al final.
      $user = trim($_POST['user']); // Quitar espacios al principio y al final.
      $passwd = trim($_POST['passwd']); // Quitar espacios al principio y al final.
      $passwd2 = trim($_POST['passwd2']); // Quitar espacios al principio y al final.
      
      // Validación de los datos.
      if (!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $email)) {
        $respuesta = array('exito' => false, 'mensaje' => 'El email no es válido.');
        echo json_encode($respuesta);
        exit;
      }

      if (!preg_match("/^[a-zA-Z0-9._]{5,20}$/", $user)) {
        $respuesta = array('exito' => false, 'mensaje' => 'El nombre de usuario no es válido.');
        echo json_encode($respuesta);
        exit;
      }
      
      if (!preg_match("/^[a-zA-Z0-9!@#$%^&*()_+=[\]{}|\\;:'\",.<>\/?]{6,50}$/", $passwd)) {
        $respuesta = array('exito' => false, 'mensaje' => 'La contraseña no es válida.');
        echo json_encode($respuesta);
        exit;
      }

      if($passwd != $passwd2) {
        $respuesta = array('exito' => false, 'mensaje' => 'Las contraseñas no coinciden.');
        echo json_encode($respuesta);
        exit;
      }
      
      // Procesamiento de los datos.
      if(!$this->OrdePlay->insertUser($email, $user, $passwd)){
        $respuesta = array('exito' => false, 'mensaje' => 'Ese email ya existe.');
        echo json_encode($respuesta);
        exit;
      }
      
      // Respuesta
      $respuesta = array('exito' => true, 'mensaje' => 'Los datos han sido procesados correctamente.');
      echo json_encode($respuesta);
      exit;
    }
  
  }

  // Función que borra las variables de sesión y la cierra.
  public function cerrarSesion() {
    $_SESSION['idCliente'] = "";
    $_SESSION['usuario'] = "";
    $_SESSION['email'] = "";
    $_SESSION['passwd'] = "";
    $_SESSION['picture'] = "";
    session_destroy();
    return $this->web();
  }

  // Vista de edición del usuario.
  public function configUser(){

    if(!isset($_SESSION['idCliente'])) {
      return $this->logIn();
    } else {
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
        
      // Validación de los datos.
      if (!preg_match("/^[^\s@]+@[^\s@]+\.[^\s@]+$/", $newEmail)) {
        $respuesta = array('exito' => false, 'mensaje' => 'El nuevo email no es válido.');
        echo json_encode($respuesta);
        exit;
      }

      if($newEmail != $repeatEmail){
        $respuesta = array('exito' => false, 'mensaje' => 'Los emails no coinciden.');
        echo json_encode($respuesta);
        exit;
      }
  
      if(!$this->OrdePlay->validarEmail($oldEmail)){
        $respuesta = array('exito' => false, 'mensaje' => 'Email incorrecto.');
        echo json_encode($respuesta);
        exit;
      }

      if(!$this->OrdePlay->cambiarEmail($newEmail, $oldEmail)){
        $respuesta = array('exito' => false, 'mensaje' => 'Ese correo ya existe.');
        echo json_encode($respuesta);
        exit;
      }
        
      // Respuesta
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
      
      // Validación de los datos.
      if (!preg_match("/^[a-zA-Z0-9!@#$%^&*()_+=[\]{}|\\;:'\",.<>\/?]{6,50}$/", $newPasswd)) {
        $respuesta = array('exito' => false, 'mensaje' => 'La nueva contraseña no es válida.');
        echo json_encode($respuesta);
        exit;
      }

      if($newPasswd != $repeatPasswd){
        $respuesta = array('exito' => false, 'mensaje' => 'Las contraseñas no coinciden.');
        echo json_encode($respuesta);
        exit;
      }

      if(!$this->OrdePlay->cambiarPasswd($newPasswd, $oldPasswd)){
        $respuesta = array('exito' => false, 'mensaje' => 'Contraseña incorrecta.');
        echo json_encode($respuesta);
        exit;
      }
      
      // Respuesta
      $respuesta = array('exito' => true, 'mensaje' => 'Contraseña cambiada con éxito.');
      echo json_encode($respuesta);
      exit;
    }

  }

  // Función que valida el cambio de usuario del usuario y envía una respuesta.
  public function cambiarUser() {

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $user = trim($_POST['user']); // Quitar espacios al principio y al final.
          
      // Validación de los datos.
      if (!preg_match("/^[a-zA-Z0-9._]{5,20}$/", $user)) {
        $respuesta = array('exito' => false, 'mensaje' => 'Usuario no válido.');
        echo json_encode($respuesta);
        exit;
      }
    
      if(!$this->OrdePlay->cambiarUser($user)){
        $respuesta = array('exito' => false, 'mensaje' => 'Error inesperado.');
        echo json_encode($respuesta);
        exit;
      }
          
      // Respuesta
      $respuesta = array('exito' => true, 'mensaje' => 'Usuario cambiado con éxito.');
      echo json_encode($respuesta);
      exit;
    }
    
  }

  public function cambiarFoto(){

    $destino = "./img/userIcons/";
    $archivo = $destino . "iconUser" . $_SESSION['idCliente'];

    // Obtener la extensión del archivo subido
    $extension = strtolower(pathinfo($_FILES['picture']['name'], PATHINFO_EXTENSION));

    // Verificar si la extensión es válida
    $allowedExtensions = array("jpg", "jpeg", "png");
    if (!in_array($extension, $allowedExtensions)) {
      $respuesta = array('exito' => false, 'mensaje' => 'Solo se permiten archivos PNG, JPG y JPEG.');
      echo json_encode($respuesta);
      exit;
    }

    // Sobrescribir el archivo si ya existe
    if (file_exists($archivo)) {
      unlink($archivo .".png");
      unlink($archivo .".jpg");
      unlink($archivo .".jpeg");
    }

    // Mover el archivo subido a la carpeta de destino
    $archivo = $archivo . "." . $extension;
    if (!move_uploaded_file($_FILES["picture"]["tmp_name"], $archivo)) {
      $respuesta = array('exito' => false, 'mensaje' => 'Error al subir el archivo.');
      echo json_encode($respuesta);
      exit;
    }

    $this->OrdePlay->cambiarFoto($archivo);

    // Respuesta
    $respuesta = array('exito' => true, 'mensaje' => 'Usuario cambiado con éxito.');
    echo json_encode($respuesta);
    exit;

  }

  public function verJuego() {

    $this->vista = "verJuego";
    $this->css = "verJuego";

  }

}

?>