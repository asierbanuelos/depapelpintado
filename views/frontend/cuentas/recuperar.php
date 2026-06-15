<div class="wrapper mi-cuenta">
  <div class="container">
    <?php 
    if(!isset($cual)){
    ///// No hay datos
    ?>
      <h1 class="gris-34-300 text-center mb-4 pb-4">Introduzca su email, para recuperar la contraseña</h1>
      <section id="content" class="page-content card card-block col-md-6 col-12 m-auto p-4">
        <form id="login-form" method="post" action='/tienda/recuperar_contrasena'>
          <div>
            <div class="form-group row ">
              <label class="col-md-4 form-control-label required" for="field-email">
                Dirección de correo electrónico
              </label>
              <div class="col-md-8">
                <input id="field-email" class="form-control" name="email" type="email" value="" autocomplete="email" required="" placeholder="E-mail" /> 
                <div class="">
                  <input class="boton-opciones" type="submit" name="enviar" value="Enviar">
                </div>
              </div>
            </div>
          </div>
        </form>
      </section>
      <?php
      /* 
      echo form_open();
      echo "Email: ".  form_input("email", urldecode($mail))."<br>".  form_submit("enviar", "Enviar");
      echo form_close();
      */
    }
    else if($cual=="enviado"){
    //se ha enviado un email con instrucciones
    ?>
      <div class="mt-4 pt-4 mb-4 pb-4">
        <p class="titulo-2 text-center mt-4 pt-4 mb-4 pb-4">Se ha enviado un email con instrucciones para reestablecer la contraseña a <?=$mail?></p>
      </div>
    <?
    }
    else if($cual=="reset"){
      //formulario para resetear
      ?>
      <h1 class="gris-34-300 text-center mb-4 pb-4">Introduzca la nueva contraseña para <?=$mail?></h1>
      <?php
      if($msg!="")
        echo "<p class='titulo-2 text-center mt-4 pt-4 mb-4 pb-4'>".$msg."</p>";
      ?>
      <section id="content" class="page-content card card-block col-md-6 col-12 m-auto p-4">
        <form id="login-form" method="post">
          <div>
            <div class="form-group row ">
              <label class="col-md-4 form-control-label required" for="field-email">
                Nueva Contraseña
              </label>
              <div class="col-md-8">
                <input id="field-pass" class="form-control" name="pass" type="password" value="" required="" placeholder="" /> 
              </div>
            </div>
            <div class="form-group row ">
              <label class="col-md-4 form-control-label required" for="field-email">
                Repita Contraseña
              </label>
              <div class="col-md-8">
                <input id="field-pass2" class="form-control" name="pass2" type="password" value="" required="" placeholder="" /> 
                <div class="">
                  <input class="boton-opciones" type="submit" name="enviar" value="Enviar">
                </div>
              </div>
            </div>
          </div>
        </form>
      </section>
      <?php
      /* 
      echo form_open();
      echo "Nueva Contraseña: ".form_password("pass")."<br>";
      echo "Repita Contraseña: ".form_password("pass2")."<br>".form_submit("enviar", "Enviar");
      echo form_close();
      */
    }
    else if($cual=="hecho"){
    //proceso terminado
    ?>
      <div class="mt-4 pt-4 mb-4 pb-4">
        <p class="titulo-2 text-center mt-4 pt-4 mb-4 pb-4">Su contraseña ha sido reestablecida correctamente.</p>
      </div>
    <?
    }
    ?>
  </div>
</div>
