<div class="container">
  <div class="info">
    <div class='img'>
      <img src="<?= $_SESSION['picture'] ?>" />
      <a href=""><div><i class="fa-solid fa-pen-to-square"></i></div></a>
    </div>
    <div class="nameUser">
      <h3><?= $_SESSION['usuario'] ?></h3>
      <p><?= $_SESSION['email'] ?></p>
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
            <button id="enviar">Cambiar</button>
          </div>
        </form>
      </div>
      <div class="form">
        <h2>Cambiar contraseña</h2>
        <form action="https://ordeplay.cifpceuta.com/index.php" method="post" id="miFormularioEmail">
          <div class="campo">
            <input type="text" name="oldPasswd" required id="oldPasswd">
            <label>Contraseña actual</label>
          </div>
          <div class="campo">
            <input type="text" name="newPasswd" required id="newPasswd">
            <label>Contraseña nueva</label>
          </div>
          <div class="campo" id="lastCampoPasswd">
            <input type="text" name="repeatPasswd" required id="repeatPasswd">
            <label>Repetir contraseña nueva</label>
          </div>
          <div class="loginButton">
            <button id="enviar">Cambiar</button>
          </div>
        </form>
      </div>
    </div>
  </section>
</div>
<script>

  // Validación y envío de datos del formulario con respuesta del servidor.
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
      if(!document.getElementById('mensaje')){
          let msg = document.createElement('p');
          msg.id = 'mensaje';
          msg.innerText = datos.mensaje;
          document.getElementById('lastCampoEmail').appendChild(msg);
        }
    })
    .catch(function(error) {
      console.log(error);
    });
  });

</script>