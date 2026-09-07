<style>
  .cuenta-login-shell { max-width: 460px; margin: 0 auto; padding: 56px 24px 96px; display: flex; flex-direction: column; align-items: center; gap: 40px; }
  .cuenta-login-shell h1.gris-34-300 { margin: 0; text-align: center; padding: 0; }
  .cuenta-login-intro { text-align: center; margin-top: -16px; }
  .cuenta-login-intro p { margin: 0; font-size: 14px; color: #727272; line-height: 1.6; }
  .cuenta-card { width: 100%; background: #fff; border: 1px solid #e8e4df; border-radius: 4px; padding: 48px 44px; box-sizing: border-box; }
  .cuenta-field { margin-bottom: 26px; }
  .cuenta-field:last-of-type { margin-bottom: 0; }
  .cuenta-field label { display: block; font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: #727272; margin-bottom: 10px; }
  .cuenta-field .input-wrap { position: relative; }
  .cuenta-input { width: 100%; padding: 14px 16px; font-size: 15px; font-family: inherit; color: #333; background: #fbfaf8; border: 1px solid #e8e4df; border-radius: 3px; outline: none; transition: border-color .15s; box-sizing: border-box; }
  .cuenta-input:focus { border-color: #a36185; }
  .cuenta-btn-submit { width: 100%; margin-top: 34px; padding: 15px; border: 2px solid #a36185; background: #a36185; color: #fff; font-size: 13px; font-weight: 500; letter-spacing: .08em; text-transform: uppercase; border-radius: 3px; cursor: pointer; transition: .2s; }
  .cuenta-btn-submit:hover { background: #333; border-color: #333; }
  .cuenta-cta-secondary { display: inline-block; text-align: center; padding: 14px 32px; border: 1px solid #e8e4df; border-radius: 3px; text-decoration: none; font-size: 13px; color: #333; transition: .2s; }
  .cuenta-cta-secondary:hover { border-color: #a36185; color: #a36185; }
  .cuenta-logmsg { width: 100%; text-align: center; font-size: 13px; color: #b5533f; background: #fbf1ef; border: 1px solid #f0d8d3; border-radius: 3px; padding: 12px 16px; box-sizing: border-box; margin-bottom: 26px; }
  .cuenta-confirm { display: flex; flex-direction: column; align-items: center; gap: 20px; text-align: center; }
  .cuenta-confirm .icon-circle { width: 56px; height: 56px; border-radius: 50%; background: #f3ece9; color: #a36185; display: flex; align-items: center; justify-content: center; font-size: 22px; }
  .cuenta-confirm p { margin: 0; font-size: 15px; color: #333; line-height: 1.7; }
  .cuenta-confirm p b { color: #333; }
  @media (max-width: 480px) {
    .cuenta-login-shell { padding: 32px 20px 64px; gap: 28px; }
    .cuenta-card { padding: 32px 24px; }
    .cuenta-input { font-size: 16px; }
  }
</style>

<div class="wrapper mi-cuenta">
  <div class="container">
    <?php if (!isset($cual)): ?>

      <div class="cuenta-login-shell">
        <div>
          <h1 class="gris-34-300">Recupera tu contraseña</h1>
          <div class="cuenta-login-intro">
            <p>Introduce tu email y te enviaremos un enlace para crear una nueva contraseña.</p>
          </div>
        </div>
        <section id="content" class="cuenta-card">
          <form id="login-form" method="post" action="/tienda/recuperar_contrasena">
            <div class="cuenta-field">
              <label for="field-email">Dirección de correo electrónico</label>
              <div class="input-wrap">
                <input id="field-email" class="cuenta-input" name="email" type="email" value="" autocomplete="email" required placeholder="tucorreo@ejemplo.com" />
              </div>
            </div>
            <button type="submit" class="cuenta-btn-submit" name="enviar" value="1">Enviar enlace</button>
          </form>
        </section>
      </div>

    <?php elseif ($cual == "enviado"): ?>

      <div class="cuenta-login-shell">
        <div class="cuenta-card cuenta-confirm">
          <span class="icon-circle"><i class="fa fa-envelope"></i></span>
          <p>Se ha enviado un email con instrucciones para restablecer la contraseña a<br><b><?php echo htmlspecialchars($mail); ?></b></p>
        </div>
      </div>

    <?php elseif ($cual == "reset"): ?>

      <div class="cuenta-login-shell">
        <div>
          <h1 class="gris-34-300">Crea tu nueva contraseña</h1>
          <div class="cuenta-login-intro">
            <p>Para la cuenta <b><?php echo htmlspecialchars($mail); ?></b></p>
          </div>
        </div>
        <section id="content" class="cuenta-card">
          <?php if ($msg != ''): ?>
            <div class="cuenta-logmsg"><?php echo $msg; ?></div>
          <?php endif; ?>
          <form id="login-form" method="post">
            <div class="cuenta-field">
              <label for="field-pass">Nueva contraseña</label>
              <div class="input-wrap">
                <input id="field-pass" class="cuenta-input" name="pass" type="password" value="" required placeholder="••••••••" />
              </div>
            </div>
            <div class="cuenta-field">
              <label for="field-pass2">Repite la contraseña</label>
              <div class="input-wrap">
                <input id="field-pass2" class="cuenta-input" name="pass2" type="password" value="" required placeholder="••••••••" />
              </div>
            </div>
            <button type="submit" class="cuenta-btn-submit" name="enviar" value="1">Guardar contraseña</button>
          </form>
        </section>
      </div>

    <?php elseif ($cual == "hecho"): ?>

      <div class="cuenta-login-shell">
        <div class="cuenta-card cuenta-confirm">
          <span class="icon-circle"><i class="fa fa-check"></i></span>
          <p>Tu contraseña se ha restablecido correctamente.</p>
          <a class="cuenta-cta-secondary" href="/tienda/mi_cuenta">Iniciar sesión</a>
        </div>
      </div>

    <?php endif; ?>
  </div>
</div>
