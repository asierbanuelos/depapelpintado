<style>
  .cuenta-login-shell { max-width: 460px; margin: 0 auto; padding: 56px 24px 96px; display: flex; flex-direction: column; align-items: center; gap: 40px; }
  .cuenta-login-shell h1.gris-34-300 { margin: 0; text-align: center; padding: 0; }
  .cuenta-login-intro { text-align: center; margin-top: -16px; }
  .cuenta-login-intro p { margin: 0; font-size: 14px; color: #727272; line-height: 1.6; }
  .cuenta-card { width: 100%; background: #fff; border: 1px solid #e8e4df; border-radius: 4px; padding: 48px 44px; }
  .cuenta-field { margin-bottom: 26px; }
  .cuenta-field:last-of-type { margin-bottom: 0; }
  .cuenta-field label { display: block; font-size: 11px; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: #727272; margin-bottom: 10px; }
  .cuenta-field .input-wrap { position: relative; }
  .cuenta-input { width: 100%; padding: 14px 16px; font-size: 15px; font-family: inherit; color: #333; background: #fbfaf8; border: 1px solid #e8e4df; border-radius: 3px; outline: none; transition: border-color .15s; }
  .cuenta-input:focus { border-color: #a36185; }
  .cuenta-input[type="password"] { padding-right: 56px; }
  .cuenta-show-pass { position: absolute; right: 14px; top: 50%; transform: translateY(-50%); display: inline-flex; align-items: center; cursor: pointer; opacity: .55; transition: opacity .15s; }
  .cuenta-show-pass:hover { opacity: 1; }
  .cuenta-show-pass img { width: 19px; height: 19px; display: block; }
  .cuenta-row-end { display: flex; justify-content: flex-end; margin-top: 14px; }
  .cuenta-link-muted { font-size: 12.5px; color: #727272; text-decoration: none; border-bottom: 1px solid transparent; }
  .cuenta-link-muted:hover { color: #BB8AA3; border-bottom-color: #BB8AA3; }
  .cuenta-btn-submit { width: 100%; margin-top: 34px; padding: 15px; border: 2px solid #a36185; background: #a36185; color: #fff; font-size: 13px; font-weight: 500; letter-spacing: .08em; text-transform: uppercase; border-radius: 3px; cursor: pointer; transition: .2s; }
  .cuenta-btn-submit:hover { background: #333; border-color: #333; }
  .cuenta-divider { display: flex; align-items: center; gap: 16px; width: 100%; color: #727272; font-size: 11px; text-transform: uppercase; letter-spacing: .06em; }
  .cuenta-divider::before, .cuenta-divider::after { content: ''; flex: 1; height: 1px; background: #e8e4df; }
  .cuenta-cta-secondary { display: block; width: 100%; box-sizing: border-box; text-align: center; padding: 14px; border: 1px solid #e8e4df; border-radius: 3px; text-decoration: none; font-size: 13px; color: #333; transition: .2s; }
  .cuenta-cta-secondary:hover { border-color: #a36185; color: #a36185; }
  .cuenta-logmsg { width: 100%; text-align: center; font-size: 13px; color: #b5533f; background: #fbf1ef; border: 1px solid #f0d8d3; border-radius: 3px; padding: 12px 16px; }
  @media (max-width: 480px) {
    .cuenta-login-shell { padding: 32px 20px 64px; gap: 28px; }
    .cuenta-card { padding: 32px 24px; }
    .cuenta-input { font-size: 16px; }
  }
</style>

<div class="wrapper mi-cuenta">
  <div class="container">
    <div class="cuenta-login-shell">
      <div>
        <h1 class="gris-34-300">Accede a tu cuenta</h1>
        <div class="cuenta-login-intro">
          <p>Introduce tus datos para ver tus pedidos y gestionar tu perfil.</p>
        </div>
      </div>

      <?php if (isset($logmsg)): ?>
        <div class="cuenta-logmsg"><?php echo $logmsg; ?></div>
      <?php endif; ?>

      <section id="content" class="cuenta-card">
        <form id="login-form" method="post">
          <input type="hidden" name="back" value="">

          <div class="cuenta-field">
            <label for="field-email">Dirección de correo electrónico</label>
            <div class="input-wrap">
              <input id="field-email" class="cuenta-input" name="email" type="email" value="" autocomplete="email" required placeholder="tucorreo@ejemplo.com" />
            </div>
          </div>

          <div class="cuenta-field">
            <label for="field-password">Contraseña</label>
            <div class="input-wrap">
              <input id="field-password" class="cuenta-input" name="pass" type="password" autocomplete="current-password" placeholder="••••••••" required />
              <span id="imgContrasena" class="cuenta-show-pass" data-activo="false"><img src="/includes/iconos/show_hide_password_2_32.png" class="icon" alt="Mostrar contraseña" /></span>
            </div>
            <div class="cuenta-row-end">
              <a class="cuenta-link-muted" href="/tienda/recuperar_contrasena" rel="nofollow">¿Olvidaste tu contraseña?</a>
            </div>
          </div>

          <button type="submit" class="cuenta-btn-submit" name="identificate" value="1">Entrar</button>
        </form>
      </section>

      <div class="cuenta-divider">o si eres nuevo</div>

      <a class="cuenta-cta-secondary" href="/tienda/mi_cuenta/nueva" data-link-action="display-register-form">Crear una cuenta</a>
    </div>
  </div>
</div>
