    <?php
    if($controlador->getVista() != "logIn" && $controlador->getVista() != "crearUser"){
    ?>
    <footer>
      <div>
        <img src="img/logo.png" alt="Logotipo de la página.">
        <p>OrdePlay</p>
      </div>
      <a href="https://github.com/Pedrogf23"><p>Pedro González Fernández - 2ºDAW - C.I.F.P. Nº1, Ceuta</p></a>
    </footer>
    <?php
    }
    ?>
    <script>
      // jQuery para cambiar entre clases
      $('.contenedor_icono_burger').on('click', function () {
        // Cada vez que se hace click en el elemento con la
        // clase .contenedor_icono_burguer, se va intercambiando
        // la clase .icono_cruz por .icono_barras y viceversa.
        $(this).toggleClass('icono_cruz icono_barras');
        // Además, también intercambia las clases on y off del
        // elemento con clase .desplegable.
        $('.desplegable').toggleClass('on off');
      });
    </script>
  </body>
</html>