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

  // Función que loguea al usuario.
  public function doLogIn(){

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = trim($_POST['email']); // Quitar espacios al principio y al final.
      $passwd = trim($_POST['passwd']); // Quitar espacios al principio y al final.
    
      // Validación de los datos
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
    
      // Procesamiento de los datos
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
    
    if(isset($_SESSION['cliente'])) {
      return $this->web();
    } else {
      $this->vista = "crearUser";
      $this->css = "crearUser"; 
    }

  
  }

  // Función que inserta en base de datos al usuario.
  public function doCrearUser(){

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      $email = trim($_POST['email']); // Quitar espacios al principio y al final.
      $user = trim($_POST['user']); // Quitar espacios al principio y al final.
      $passwd = trim($_POST['passwd']); // Quitar espacios al principio y al final.
      $passwd2 = trim($_POST['passwd2']); // Quitar espacios al principio y al final.
      
      // Validación de los datos
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
      
      // Procesamiento de los datos
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

  public function cerrarSesion() {
    $_SESSION['idCliente'] = "";
    $_SESSION['usuario'] = "";
    $_SESSION['email'] = "";
    $_SESSION['passwd'] = "";
    $_SESSION['picture'] = "";
    session_destroy();
    return $this->web();
  }

  public function getClienteById($id){

    return $this->OrdePlay->getClienteById($id);

  }

}

?>