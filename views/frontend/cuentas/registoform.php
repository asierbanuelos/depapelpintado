<? if($user->user_id==1){?>
<h1>Registrate</h1>
<form method="post">
  <input name="email" placeholder="Email" value="<?$this->input->post('user')?>"/>
  <input name="pass" type="password" placeholder="Contraseña"/>
  <input name="pass" type="password" placeholder="Repita Contraseña"/>
  <button type="submit" name="registrar" value="resitro">Aceptar</button>
</form>
<?}?>