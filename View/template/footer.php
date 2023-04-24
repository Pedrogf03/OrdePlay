    <script>
      // jQuery para cambiar entre clases
      // Cada vez que se hace click en el elemento con la
      // clase .contenedor_icono_burguer, se va intercambiando
      // la clase .icono_cruz por .icono_barras y viceversa.
      $('.contenedor_icono_burger').on('click', function () {
        $(this).toggleClass('icono_cruz icono_barras');
      });
    </script>
  </body>
</html>