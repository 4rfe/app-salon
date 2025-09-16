 <?php foreach ($alertas as $key => $alerta) {  
      foreach($alerta as $mensajes):
   ?>
    
             <div class="alerta <?php echo $key ?>">
             <?php echo $mensajes; ?>
            </div>

        <?php endforeach;
       }?> 