 <h1 class="nombre-pagina">Reestablecer password</h1>
<p class="descripcion-pagina">Coloca tu nuevo password aqui</p>

 <?php include_once __DIR__ . "/../templates/alertas.php";?>

 <?php if($error){
  return;
  }
 ?>

  <form method="POST" class="formulario"> 
    <div class="campo">
        <label for="password">Password</label>
        <input type="password" id="password" placeholder="Password" name="password">
    </div> 

    <input type="submit" class="boton" value="Reestablecer">

 <div class="acciones">
    <a href="/">¿Ya tienes cuenta? Iniciar Sesión</a> 
    <a href="/crear-cuenta">¿Aun no tiene una cuenta? Registrarme</a> 
</div>

  </form>