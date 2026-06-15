<style>
.hecho-estilo-banner {
  position: relative;
  height: 480px;
  overflow: hidden;
  display: flex;
  align-items: center;
  justify-content: center;
}
.hecho-estilo-banner-bg {
  position: absolute;
  inset: 0;
  background-image: url('/images/images home/foto banner final_8_11zon.webp');
  background-size: cover;
  background-position: center 60%;
  transform: scale(1.04);
  transition: transform 6s ease;
}
@supports not (background-image: url('/includes/images/bg-newsletter.webp')) {
  .hecho-estilo-banner-bg {
    background-image: url('/includes/images/bg-newsletter.jpg');
  }
}
.hecho-estilo-banner:hover .hecho-estilo-banner-bg {
  transform: scale(1.0);
}
.hecho-estilo-banner-overlay {
  display: none;
}
.hecho-estilo-banner-content {
  position: relative;
  z-index: 2;
  text-align: center;
  padding: 0 20px;
}
.hecho-estilo-titulo {
  font-family: 'Poppins', sans-serif;
  font-size: clamp(28px, 5vw, 52px);
  font-weight: 200;
  letter-spacing: 10px;
  text-transform: uppercase;
  color: #fff;
  margin: 0 0 12px;
  line-height: 1.2;
}
.hecho-estilo-subtitulo {
  font-family: 'Poppins', sans-serif;
  font-size: 12px;
  font-weight: 300;
  letter-spacing: 4px;
  text-transform: uppercase;
  color: rgba(255,255,255,0.8);
  margin: 0 0 36px;
}
.hecho-estilo-btns {
  display: flex;
  gap: 16px;
  justify-content: center;
  flex-wrap: wrap;
}
.hecho-estilo-btn {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 10px;
  font-weight: 400;
  letter-spacing: 4px;
  text-transform: uppercase;
  text-decoration: none;
  padding: 14px 36px;
  transition: background 0.3s, color 0.3s, border-color 0.3s;
}
.hecho-estilo-btn-outline {
  border: 1px solid rgba(255,255,255,0.85);
  color: #fff;
  background: transparent;
}
.hecho-estilo-btn-outline:hover {
  background: rgba(255,255,255,0.15);
  color: #fff;
  text-decoration: none;
}
.hecho-estilo-btn-solid {
  background: #BB8AA3;
  border: 1px solid #BB8AA3;
  color: #fff;
}
.hecho-estilo-btn-solid:hover {
  background: #b3667a;
  border-color: #b3667a;
  color: #fff;
  text-decoration: none;
}
@media (max-width: 576px) {
  .hecho-estilo-banner { height: 380px; }
  .hecho-estilo-titulo { letter-spacing: 6px; }
  .hecho-estilo-btns { flex-direction: column; align-items: center; }
}
</style>

<div class="hecho-estilo-banner" id="alta-newsletter">
  <div class="hecho-estilo-banner-bg"></div>
  <div class="hecho-estilo-banner-overlay"></div>
  <div class="hecho-estilo-banner-content">
    <p class="hecho-estilo-subtitulo">Tu hogar, tu identidad</p>
    <h3 class="hecho-estilo-titulo">Hecho a tu estilo</h3>
    <div class="hecho-estilo-btns">
      <a href="/contacto" class="hecho-estilo-btn hecho-estilo-btn-outline">Contáctanos</a>
      <a href="/tienda/mi_cuenta/nueva" class="hecho-estilo-btn hecho-estilo-btn-solid">Crear cuenta &amp; 10€ dto.</a>
    </div>
  </div>
</div>

<?php
if (isset($notificacion_modal) && $notificacion_modal=='ok'){
  $this->load->view('frontend/notificacion_modal', $this->data);
}
?>
