
  <h1 class="fuentecorporativa magenta-secundario">Accede a tu cuenta</h1>
<form method="post">
  <input name="email" type="text" placeholder="Email" value="<?$this->input->post('user')?>"/>
  <input name="pass" type="password" placeholder="Contraseña"/>
  <button type="submit" name="identificate" value="login">Acceder</button>
</form>
