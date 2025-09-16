 <h1 class="nombre-pagina">Olvide contraseña</h1>
 <p class="descripcion-pagina">Reestablece tu contraseña a través del correo </p>

  <?php include_once __DIR__ . "/../templates/alertas.php"?>

 <form action="/olvide" method="POST" class="formulario"> 
    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Email" name="email">
    </div> 

    <input type="submit" class="boton" value="Recuperar">

    <div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/crear-cuenta">¿Aun no tiene una cuenta? Registrarme</a> 
</div>

</form>
