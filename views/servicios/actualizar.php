<?php
   include_once __DIR__ . "/../templates/barra.php"
?>
 
 <h1 class="nombre-pagina">Servicios</h1>
 <p class="descripcion-pagina">Actualizar servicios</p>

 <?php
   include_once __DIR__ . "/../templates/alertas.php"
?>

  <form action="/servicios/actualizar?id=<?php echo $servicio->id; ?>" method="POST" class="formulario">
    <?php include_once __DIR__. "/formulario.php"?>

    <input type="submit" class="boton" value="Actualizar Servicio">
 </form>