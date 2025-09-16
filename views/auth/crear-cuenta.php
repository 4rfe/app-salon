 <h1 class="nombre-pagina">Crear cuenta</h1>
 <p class="descripcion-pagina">Llena el formulario para crear una cuenta </p>

 <?php include_once __DIR__ . "/../templates/alertas.php"?>

 <form action="/crear-cuenta" method="POST" class="formulario"> 
    <div class="campo"> 
        <label for="nombre">Nombre</label>
        <input type="text" id="nombre" placeholder="Nombre" name="nombre" value= "<?php echo s($usuario->nombre)?>">
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text" id="apellido" placeholder="Apellido" name="apellido" value= "<?php echo s($usuario->apellido)?>">
    </div>

     <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel" id="telefono" placeholder="Telefono" name="telefono" value= "<?php echo s($usuario->telefono)?>">
    </div>

    <div class="campo">
        <label for="email">Email</label>
        <input type="email" id="email" placeholder="Email" name="email" value= "<?php echo s($usuario->email)?> ">
    </div>

    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="password" name="password" value= "<?php echo s($usuario->password)?>">
    </div>

    <input type="submit" class="boton" value="Crear Cuenta">

    <div class="acciones">
    <a href="/">¿Ya tienes una cuenta? Inicia Sesión</a>
    <a href="/olvide">¿Has olvidado tu contraseña? Reestablecerla</a>
</div>

</form>
