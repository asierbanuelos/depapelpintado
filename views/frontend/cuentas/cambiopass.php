<?php 
if($usuario->user_id!=1){
?>
  <div class="wrapper mi-cuenta">
    <div class="container">
      <h2 class="h5 mt-2">Cambio de Contraseña</h1>
      <?php
      if(isset($cambiook))
        echo "<p class='titulo-2 text-center mt-4 pt-4 mb-4 pb-4'>".$cambiook."</p>";

      if(isset($cambioko))
        echo "<p class='titulo-2 text-center mt-4 pt-4 mb-4 pb-4'>".$cambioko."</p>";
      ?>

      <section id="content" class="page-content card card-block  m-auto p-4">
        <form id="login-form" method="post" action='/tienda/clave'>
          <div>
            <div class="form-group row ">
              <label class="col-md-4 form-control-label required" for="oldpass">
                Contraseña Antigua:
              </label>
              <div class="col-md-8">
                <div class="input-group js-parent-focus">
                  <input id="field-old-password" class="form-control" name="oldpass" type="password" value="" required="" placeholder="" /> 
                  <span id="imgContrasenaVieja" data-activo=false><img src="/includes/iconos/show_hide_password_2_32.png" class="icon"></span>
               </div>
              </div>
            </div>

            <div class="form-group row ">
              <label class="col-md-4 form-control-label required" for="pass">
                Nueva Contraseña:
              </label>
              <div class="col-md-8">
                <div class="input-group js-parent-focus">
                  <input id="field-password" class="form-control" name="pass" type="password" value="" required="" placeholder="" /> 
                  <span id="imgContrasena" data-activo=false><img src="/includes/iconos/show_hide_password_2_32.png" class="icon"></span>
                </div>
              </div>
            </div>

            <div class="form-group row ">
              <label class="col-md-4 form-control-label required" for="pass2">
                Repita Contraseña:
              </label>
              <div class="col-md-8">
                <div class="input-group js-parent-focus">
                  <input id="field-password-rep" class="form-control" name="pass2" type="password" value="" required="" placeholder="" /> 
                  <span id="imgContrasenaRep" data-activo=false><img src="/includes/iconos/show_hide_password_2_32.png" class="icon"></span>
                </div>
                <div class="">
                  <input class="boton-opciones" type="submit" name="cambiopass" value="Enviar">
                </div>
              </div>
            </div>
          </div>
        </form>
      </section>
    </div>
  </div>

  <?php
  /*

  <h1>Cambio de Contraseña</h1>
  <?php 
  if(isset($cambiook)){
    //AKI HAY QUE PONER EL MENSAJE DE CAMBIO CORRECTO
  ?>
  <h3><?=$cambiook?></h3>
  <?
  }
  ?>
  <?if(isset($cambioko)){
    //AKI HAY QUE PONER EL MENSAJE DE CAMBIO INCORRECTO
  ?>
    <h3><?=$cambioko?></h3>
  <?}?>

  <form method="post">
    <input type="password" name="oldpass" placeholder="Contraseña Antigua" value="<?$this->input->post('user')?>"/>
    <input name="pass" type="password" placeholder="Contraseña"/>
    <input name="pass2" type="password" placeholder="Repita Contraseña"/>
    <button type="submit" name="cambiopass" value="cambio">Aceptar</button>
  </form>
  <?php
  */
}
?>
