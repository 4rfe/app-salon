<?php
   include_once __DIR__ . "/../templates/barra.php"
?>
 
 <h1 class="nombre-pagina">Crear una cita</h1>
 <p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>

 

 <div class="" id="app">
 <nav class="tabs">
    <button type="button" data-paso="1">Servicios</button>
    <button type="button" data-paso="2">Información Cita</button>
    <button type="button" data-paso="3">Resumen</button>
    </nav>
       
    <div class="seccion" id="paso-1">
        <h2>Servicios</h2>

        <p class="text-center" >Elige tus servicios aquí</p>

        <div class="listado-servicios" id="servicios"></div>

    </div>

    <div class="seccion" id="paso-2">
        <h2>Tus datos y cita</h2>
        <p class="text-center">Coloca tus datos y fecha de tu cita</p>

    <form class="formulario">

    <div class="campo"> 
        <label for="nombre">Nombre</label>
        <input disabled type="text" id="nombre" placeholder="Nombre" name="nombre" value= "<?php echo $nombre ?>">
    </div>

    <div class="campo">
        <label for="fecha">Fecha</label>
        <input type="date" id="fecha" name="fecha" value= "" min="<?php echo date("Y-m-d") ?>">
    </div>

     <div class="campo">
        <label for="hora">Hora</label>
        <input type="time" id="hora"  name="hora">
    </div>

     <input type="hidden" id="id"  name="id" value = "<?php echo $id; ?>">


    </form>
  </div>

    <div class="seccion contenedor-resumen" id="paso-3">
        <h2>Resumen</h2>
        <p class="text-center">Verifica que la información sea correcta</p>
    </div>
 
      <div class="paginacion">
        <button class="boton" id="anterior">&laquo; Anterior</button>
        <button class="boton" id="siguiente">Siguiente &raquo;</button>
    </div>
 
 </div>

 <?php
     $script = "
     <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>   
     <script src='build/js/app.js'></script>
     ";
 ?>