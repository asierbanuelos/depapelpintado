<form method="post">
  <input name="email" type="text" placeholder="Email" value="<?$this->input->post('user')?>"/>
  <input name="pass" type="password" placeholder="Contraseña"/>
  <section class="form-fields mt-4">
    <div class=''>
      <div class="col-md-6 m-auto text-center">
        <div class="form-group row">
          <div class="col-md-12">
            <input name="email" type="text" placeholder="Email" value="<?$this->input->post('user')?>"/>
          </div>
        </div>
      </div>
      <div class="col-md-6 m-auto text-center">
        <div class="form-group row">
          <div class="col-md-12">
            <input name="pass" type="password" placeholder="Contraseña"/>
          </div>
        </div>
      </div>
    </div>
    <div class=''>
      <div class="col-12 text-center">
        <input class="boton-opciones" type="submit" name="submitMessage" value="Enviar">
        <button type="submit" name="identificate" value="login">Acceder</button>
      </div>
    </div>
  </section>
</form>

