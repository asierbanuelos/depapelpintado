<div class="wrapper mi-cuenta">
  <div class="container">
    <h1 class="gris-34-300 text-center mb-4 pb-4">Accede a tu cuenta</h1>     
    <?php
    if(isset($logmsg)){
      echo '<hr>';
      echo '<div class="no-account text-center">';
      echo $logmsg;
      echo '</div>';
    }
    ?>
    <section id="content" class="page-content card card-block col-md-6 col-12 m-auto p-4">
      <form id="login-form" method="post">
        <div>
          <input type="hidden" name="back" value="">
          <div class="form-group row ">
            <label class="col-md-4 form-control-label required" for="field-email">
              Dirección de correo electrónico
            </label>
            <div class="col-md-8">
              <input id="field-email" class="form-control" name="email" type="email" value="" autocomplete="email" required="" placeholder="E-mail" /> 
            </div>
          </div>
          <div class="form-group row ">
            <label class="col-md-4 form-control-label required" for="field-password">
              Contraseña
            </label>
            <div class="col-md-8">
              <div class="input-group js-parent-focus">
                <input name="pass" id="field-password" type="password" placeholder="Contraseña" class="form-control" />
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
              <div class="">
                <input class="boton-opciones" type="submit" name="identificate" value="Enviar">
              </div>
              <?php
              /*
              <div class="forgot-password">
                <a href="https://presta.depapelpintado.es/recuperar-contraseña" rel="nofollow">¿Olvidaste tu contraseña?</a>
              </div>
              */
              ?>
            </div>
          </div>
        </div>
      </form>
      <?php
      //$this->load->view('frontend/cuentas/loginform', $this->data);
      //$this->load->view('frontend/cuentas/registroform', $this->data);
      ?>
      <hr>
      <div class="no-account text-center">
        <a href="/tienda/mi_cuenta/nueva" data-link-action="display-register-form">¿No tienes cuenta? Crea una aquí</a>
      </div>
    </section>


  </div>
</div>




