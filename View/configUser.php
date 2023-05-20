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
      <button class="botonPerfil">Perfil</button>
      <button class="botonPagos">Métodos de pago</button>
      <button class="botonPedidos">Pedidos</button>
      <button class="botonReviews">Reseñas</button>
    </nav>
  </div>
  <section class="lienzoPerfil visible">
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
      <div class="form formUser">
        <form action="https://ordeplay.cifpceuta.com/index.php?action=cambiarUser" method="post" id="miFormularioUser">
          <h2>Cambiar usuario</h2>
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
  <section class="lienzoPagos invisible">
    <div>
      <table>
        <?php
        $cliente = new Cliente($_SESSION['idCliente'], $_SESSION['usuario'], $_SESSION['email'], null, $_SESSION['picture']);
        if($cliente->getMetodosPago() == 0){
        ?>
        <tr>
          <td>
            <h3>Actualmente no tienes métodos de pago activos.</h3>
          </td>
        </tr>
        <?php
        } else {
        ?>
        <tr>
          <th>Titular</th>
          <th>Número</th>
          <th>Fecha de Expiración</th>
          <th>Borrar</th>
        </tr>
        <?php
        for($i = 0; $i < count($cliente->getMetodosPago()); $i++){
        ?>
        <tr>
          <td><?=$cliente->getMetodosPago()[$i]->getTitular()?></td>
          <td><?=$cliente->getMetodosPago()[$i]->getNumTarjeta()?></td>
          <td><?=$cliente->getMetodosPago()[$i]->getFechaExp()?></td>
          <td><a href="index.php?action=borrarTarjeta&idTarjeta=<?=$cliente->getMetodosPago()[$i]->getIdTarjeta()?>"><button><i class="fa-regular fa-circle-xmark"></i></button></a></td>
        </tr>
        <?php
        }

        }
        ?>
        <tr>
          <td colspan="4"><a href="index.php?action=addTarjeta"><button>Añadir tarjeta</button></a></td>
        </tr>
      </table>
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

  $(document).ready(function () {
        $('.botonPerfil').on('click', function () {
          $(this).parents().find('.lienzoPerfil').removeClass('invisible');
          $(this).parents().find('.lienzoPagos').removeClass('visible');
          $(this).parents().find('.lienzoPedidos').removeClass('visible');
          $(this).parents().find('.lienzoReviews').removeClass('visible');

          $(this).parents().find('.lienzoPerfil').addClass('visible');
          $(this).parents().find('.lienzoPagos').addClass('invisible');
          $(this).parents().find('.lienzoPedidos').addClass('invisible');
          $(this).parents().find('.lienzoReviews').addClass('invisible');
        });

        $('.botonPagos').on('click', function () {
          $(this).parents().find('.lienzoPerfil').removeClass('visible');
          $(this).parents().find('.lienzoPagos').removeClass('invisible');
          $(this).parents().find('.lienzoPedidos').removeClass('visible');
          $(this).parents().find('.lienzoReviews').removeClass('visible');

          $(this).parents().find('.lienzoPerfil').addClass('invisible');
          $(this).parents().find('.lienzoPagos').addClass('visible');
          $(this).parents().find('.lienzoPedidos').addClass('invisible');
          $(this).parents().find('.lienzoReviews').addClass('invisible');
        });

        $('.botonPedidos').on('click', function () {
          $(this).parents().find('.lienzoPerfil').removeClass('visible');
          $(this).parents().find('.lienzoPagos').removeClass('visible');
          $(this).parents().find('.lienzoPedidos').removeClass('invisible');
          $(this).parents().find('.lienzoReviews').removeClass('visible');

          $(this).parents().find('.lienzoPerfil').addClass('invisible');
          $(this).parents().find('.lienzoPagos').addClass('invisible');
          $(this).parents().find('.lienzoPedidos').addClass('visible');
          $(this).parents().find('.lienzoReviews').addClass('invisible');
        });

        $('.botonReviews').on('click', function () {
          $(this).parents().find('.lienzoPerfil').removeClass('visible');
          $(this).parents().find('.lienzoPagos').removeClass('visible');
          $(this).parents().find('.lienzoPedidos').removeClass('visible');
          $(this).parents().find('.lienzoReviews').removeClass('invisible');

          $(this).parents().find('.lienzoPerfil').addClass('invisible');
          $(this).parents().find('.lienzoPagos').addClass('invisible');
          $(this).parents().find('.lienzoPedidos').addClass('invisible');
          $(this).parents().find('.lienzoReviews').addClass('visible');
        });
      });

</script>