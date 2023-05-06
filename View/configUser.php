<div class="container">
  <div class="info">
    <div class='img'>
      <img src="<?= $_SESSION['picture'] ?>" />
      <form action="index.php?action=cambiarFoto" method="post" id="miFormularioFoto">
        <input type="file" id="picture" name="picture" accept=".jpg, .jpeg, .png" style="display: none;" />
        <button id="cambiarFoto" onclick="document.getElementById('picture').click();"><div><i class="fa-solid fa-pen-to-square"></i></div></button>
    </div>
    <div class="nameUser">
      <h3><?= $_SESSION['usuario'] ?></h3>
      <p><?= $_SESSION['email'] ?></p>
        <input type="submit" name="enviar" value="Cambiar foto" class="enviarFoto"/>
      </form>
    </div>
  </div>
  <div class="nav">
    <nav>
      <button class="perfil">Perfil</button>
      <button class="pago">Métodos de pago</button>
      <button class="pedidos">Pedidos</button>
      <button class="reviews">Reseñas</button>
    </nav>
  </div>
  <section class="lienzoperfil visible">
    <div>
      <div class="form">
        <h2>Cambiar correo electrónico</h2>
        <form action="https://ordeplay.cifpceuta.com/index.php?action=cambiarEmail" method="post" id="miFormularioEmail">
          <div class="campo">
            <input type="text" name="oldEmail" required id="oldEmail">
            <label>Correo actual</label>
          </div>
          <div class="campo">
            <input type="text" name="newEmail" required id="newEmail">
            <label>Correo nuevo</label>
          </div>
          <div class="campo" id="lastCampoEmail">
            <input type="text" name="repeatEmail" required id="repeatEmail">
            <label>Repetir correo nuevo</label>
          </div>
          <div class="loginButton">
            <button>Cambiar</button>
          </div>
        </form>
      </div>
      <div class="form">
        <h2>Cambiar usuario</h2>
        <form action="https://ordeplay.cifpceuta.com/index.php?action=cambiarUser" method="post" id="miFormularioUser">
          <div class="campo" id="lastCampoUser">
            <input type="text" name="user" required id="user">
            <label>Nuevo usuario</label>
          </div>
          <div class="loginButton">
            <button>Cambiar</button>
          </div>
        </form>
      </div>
      <div class="form">
        <h2>Cambiar contraseña</h2>
        <form action="https://ordeplay.cifpceuta.com/index.php?action=cambiarPasswd" method="post" id="miFormularioPasswd">
          <div class="campo">
            <input type="password" name="oldPasswd" required id="oldPasswd">
            <label>Contraseña actual</label>
            <i class="fa-regular fa-eye" id="eyeIcon1"></i>
          </div>
          <div class="campo">
            <input type="password" name="newPasswd" required id="newPasswd">
            <label>Contraseña nueva</label>
            <i class="fa-regular fa-eye" id="eyeIcon2"></i>
          </div>
          <div class="campo" id="lastCampoPasswd">
            <input type="password" name="repeatPasswd" required id="repeatPasswd">
            <label>Repetir contraseña nueva</label>
          </div>
          <div class="loginButton">
            <button>Cambiar</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
<script>

  document.getElementById('cambiarFoto').addEventListener('click', function(ev){
    ev.preventDefault();
  });

  // Envío de datos del formulario de cambio del email con respuesta del servidor.
  var miFormularioFoto = document.getElementById('miFormularioFoto');
  miFormularioFoto.addEventListener('submit', function(ev) {
    ev.preventDefault();

    var datos = new FormData(miFormularioFoto);

    // Envío de los datos al servidor
    fetch(miFormularioFoto.getAttribute('action'), {
      method: miFormularioFoto.getAttribute('method'),
      body: datos
    })
    .then(function(respuesta) {
      return respuesta.json();
    })
    // Trabajo con la respuesta que da el servidor.
    .then(function(datos) {
      if(datos.exito){
        location.reload(true);
      }
    })
    .catch(function(error) {
      console.log(error);
    });
  });

  // Envío de datos del formulario de cambio del email con respuesta del servidor.
  var miFormularioEmail = document.getElementById('miFormularioEmail');
  miFormularioEmail.addEventListener('submit', function(ev) {
    ev.preventDefault();

    var datos = new FormData(miFormularioEmail);

    // Envío de los datos al servidor
    fetch(miFormularioEmail.getAttribute('action'), {
      method: miFormularioEmail.getAttribute('method'),
      body: datos
    })
    .then(function(respuesta) {
    return respuesta.json();
    })
    // Trabajo con la respuesta que da el servidor.
    .then(function(datos) {
      if(datos.exito){
        location.reload(true);
      } else {
        if(!document.getElementById('mensaje')){
          let msg = document.createElement('p');
          msg.id = 'mensaje';
          msg.innerText = datos.mensaje;
          msg.classList.toggle('false', !datos.exito);
          document.getElementById('lastCampoEmail').appendChild(msg);
        } else {
          document.getElementById('mensaje').innerText = datos.mensaje;
          document.getElementById('mensaje').classList.toggle('false', !datos.exito);
        }
      }
    })
    .catch(function(error) {
      console.log(error);
    });
  });

  // Envío de datos del formulario de cambio del usuario con respuesta del servidor.
  var miFormularioUser = document.getElementById('miFormularioUser');
  miFormularioUser.addEventListener('submit', function(ev) {
    ev.preventDefault();

    var datos = new FormData(miFormularioUser);

    // Envío de los datos al servidor
    fetch(miFormularioUser.getAttribute('action'), {
      method: miFormularioUser.getAttribute('method'),
      body: datos
    })
    .then(function(respuesta) {
    return respuesta.json();
    })
    // Trabajo con la respuesta que da el servidor.
    .then(function(datos) {
      if(datos.exito){
        location.reload(true);
      } else {
        if(!document.getElementById('mensaje')){
          let msg = document.createElement('p');
          msg.id = 'mensaje';
          msg.innerText = datos.mensaje;
          msg.classList.toggle('false', !datos.exito);
          document.getElementById('lastCampoEmail').appendChild(msg);
        } else {
          document.getElementById('mensaje').innerText = datos.mensaje;
          document.getElementById('mensaje').classList.toggle('false', !datos.exito);
        }
      }
    })
    .catch(function(error) {
      console.log(error);
    });
  });

  // Envío de datos del formulario de cambio de la contraseña con respuesta del servidor.
  var miFormularioPasswd = document.getElementById('miFormularioPasswd');
  miFormularioPasswd.addEventListener('submit', function(ev) {
    ev.preventDefault();

    var datos = new FormData(miFormularioPasswd);

    // Envío de los datos al servidor
    fetch(miFormularioPasswd.getAttribute('action'), {
      method: miFormularioPasswd.getAttribute('method'),
      body: datos
    })
    .then(function(respuesta) {
    return respuesta.json();
    })
    // Trabajo con la respuesta que da el servidor.
    .then(function(datos) {
      if(datos.exito){
        location.reload(true);
      } else {
        if(!document.getElementById('mensaje')){
          let msg = document.createElement('p');
          msg.id = 'mensaje';
          msg.innerText = datos.mensaje;
          msg.classList.toggle('false', !datos.exito);
          document.getElementById('lastCampoEmail').appendChild(msg);
        } else {
          document.getElementById('mensaje').innerText = datos.mensaje;
          document.getElementById('mensaje').classList.toggle('false', !datos.exito);
        }
      }
    })
    .catch(function(error) {
      console.log(error);
    });
  });

  // Ver contraseña
  document.getElementById('eyeIcon1').addEventListener("mousedown", function() {
  document.getElementById('oldPasswd').setAttribute('type', "text");
  })
  document.getElementById('eyeIcon1').addEventListener("mouseup", function() {
    document.getElementById('oldPasswd').setAttribute('type', "password");
  })

  // Ver contraseña
  document.getElementById('eyeIcon2').addEventListener("mousedown", function() {
  document.getElementById('newPasswd').setAttribute('type', "text");
  })
  document.getElementById('eyeIcon2').addEventListener("mouseup", function() {
    document.getElementById('newPasswd').setAttribute('type', "password");
  })

</script>