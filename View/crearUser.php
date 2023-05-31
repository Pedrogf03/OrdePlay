<div class="container">
  <div class="form">
    <h2>Crear cuenta</h2>
    <form action="https://ordeplay.cifpceuta.com/index.php?action=doCrearUser" method="post" id="miFormulario">
      <div class="campo">
        <input type="email" name="email" required id="email">
        <label>Email</label>
      </div>
      <div class="campo">
        <input type="text" name="user" required id="user">
        <label>Nombre de usuario</label>
      </div>
      <div class="campo">
        <input type="password" name="passwd" required id="passwd">
        <label>Contraseña</label>
        <i class="fa-regular fa-eye" id="eyeIcon"></i>
      </div>
      
      <div class="campo">
        <input type="password" name="passwd2" required id="passwd2">
        <label>Repetir contraseña</label>
      </div>
      <div class="loginButton">
        <button id="enviar">Crear cuenta</button>
        <br/>
        <br/>
        <a href="index.php?action=logIn">Iniciar Sesión</a>
      </div>
      </form>
  </div>
</div>
<script>
  // Mostrar placeholders al tener el foco y quitarlo al perderlo.
  document.getElementById('email').addEventListener('focus', function(){
    document.getElementById('email').setAttribute('placeholder', 'example@notemail.es');
  });
  document.getElementById('email').addEventListener('blur', function(){
    document.getElementById('email').removeAttribute('placeholder');
  });

  document.getElementById('user').addEventListener('focus', function(){
    document.getElementById('user').setAttribute('placeholder', 'P@ssw0rd!2023');
  });
  document.getElementById('passwd').addEventListener('blur', function(){
    document.getElementById('passwd').removeAttribute('placeholder');
  });

  var miFormulario = document.getElementById('miFormulario');

  miFormulario.addEventListener('submit', function(ev) {
    ev.preventDefault();

    var datos = new FormData(miFormulario);

    // Envío de los datos al servidor
    fetch(miFormulario.getAttribute('action'), {
      method: miFormulario.getAttribute('method'),
      body: datos
    })
    .then(function(respuesta) {
    return respuesta.json();
    })
    // Trabajo con la respuesta que da el servidor.
    .then(function(datos) {

      if(datos.exito){
        window.location.href = "https://ordeplay.cifpceuta.com";
      } else {
        if(!document.getElementById('mensaje')){
          let msg = document.createElement('p');
          msg.innerText = datos.mensaje;
          msg.id = 'mensaje';
          document.getElementById('lastCampo').appendChild(msg);
        } else {
          document.getElementById('mensaje').innerText = datos.mensaje;
        }
      }

    })
    .catch(function(error) {
      console.log(error);
    });

  });

  // Ver contraseña
  document.getElementById('eyeIcon').addEventListener("click", function() {
      if (document.getElementById('passwd').type === 'password') {
        document.getElementById('passwd').type = 'text';
        document.getElementById('eyeIcon').classList.remove('fa-regular');
        document.getElementById('eyeIcon').classList.add('fa-solid');
    } else {
      document.getElementById('passwd').type = 'password';
        document.getElementById('eyeIcon').classList.remove('fa-solid');
        document.getElementById('eyeIcon').classList.add('fa-regular');
    }
  })
</script>
