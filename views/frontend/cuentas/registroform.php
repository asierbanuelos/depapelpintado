<?php
/* 
$registro_recaptcha_v3=new stdClass;
$registro_recaptcha_v3->aktibaturik=true;
$registro_recaptcha_v3->action='';
$registro_recaptcha_v3->form_id='#login-form';

print '<pre><xmp>';
print_r($registro_recaptcha_v3);
print '</xmp></pre>';
print '<pre><xmp>';
print_r($_POST);
print '</xmp></pre>';

*/
?>
<h1 class="gris-34-300 text-center mb-4 pb-4">¿No tienes cuenta en dePapelPintado? Regístrate</h1>     
<?php
if(isset($logmsg)){
  echo "<p class='titulo-2 text-center mt-4 pt-4 mb-4 pb-4'>".$logmsg."</p>";
}
?>

<section id="content" class="page-content card card-block col-md-6 col-12 m-auto p-4">
  <form id="login-form" method="post">
    <div>
      <input type="hidden" name="back" value="">
      <input type="hidden" name="registrar" id="registrar" value="1">
      <div class="form-group row ">
        <label class="col-md-4 form-control-label required" for="field-email">
          Dirección de correo electrónico
        </label>
        <div class="col-md-8">
          <input id="field-email" class="form-control" name="email" type="email" value="<?$this->input->post('user')?>" autocomplete="email" required="" placeholder="E-mail" /> 
        </div>
      </div>
      <div class="form-group row ">
        <label class="col-md-4 form-control-label required" for="field-password">
          Contraseña
        </label>
        <div class="col-md-8">
          <div class="input-group js-parent-focus">
            <input name="pass" id="field-password" type="password" placeholder="" class="form-control" autocomplete=""  />
            <span id="imgContrasena" data-activo=false><img src="/includes/iconos/show_hide_password_2_32.png" class="icon"></span>
            <?php
            /*
            <input id="field-password" class="form-control js-child-focus js-visible-password" name="password" title="Al menos 5 caracteres de largo" aria-label="Entrada de contraseña de al menos 5 caracteres" type="password" autocomplete="current-password" value="" pattern=".{5,}" required="">
            <span class="input-group-btn">
            <button class="btn" type="button" data-action="show-password" data-text-show="Show" data-text-hide="Esconder">Show</button>
            </span>
            */
            ?>
          </div>
        </div>
      </div>
      <div class="form-group row ">
        <label class="col-md-4 form-control-label required" for="field-password">
          Repita Contraseña
        </label>
        <div class="col-md-8">
          <div class="input-group js-parent-focus">
            <input name="pass2" id="field-password-rep" type="password" placeholder="" class="form-control" autocomplete="" />
            <span id="imgContrasenaRep" data-activo=false><img src="/includes/iconos/show_hide_password_2_32.png" class="icon"></span>
            <?php
            /*
            <input id="field-password" class="form-control js-child-focus js-visible-password" name="password" title="Al menos 5 caracteres de largo" aria-label="Entrada de contraseña de al menos 5 caracteres" type="password" autocomplete="current-password" value="" pattern=".{5,}" required="">
            <span class="input-group-btn">
            <button class="btn" type="button" data-action="show-password" data-text-show="Show" data-text-hide="Esconder">Show</button>
            </span>
            */
            ?>
          </div>
          
          <div class="aviso_legal mt-4">
            <p>
              <input type="checkbox" id="legaladviceRegistro" name="legaladvice" value="1">
              <label for="legaladviceRegistro" class="d-inline">He leído y acepto la <a href="/politica-de-privacidad" target="_blank">política de privacidad</a> </label>      
            </p>
            <p>
              <input type="checkbox" id="suscripcionRegistro" name="suscripcionRegistro" value="1">
              <label for="suscripcionRegistro" class="d-inline">Quiero recibir el boletín de noticias</label>      
            </p>
          </div>

          <div class="">
            <input class="boton-opciones" type="submit" name="registrar" value="Enviar">
          </div>
        </div>
      </div>
    </div>
  </form>
</section>