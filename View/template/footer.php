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