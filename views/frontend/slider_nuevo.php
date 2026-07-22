<style>
.hero-static {
  position: relative;
  width: 100%;
  height: calc(100vh - 36px);
  min-height: 520px;
  overflow: hidden;
}
.hero-static img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  display: block;
}
.hero-static-overlay {
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0.28);
  z-index: 1;
}
.hero-static-content {
  position: absolute;
  inset: 0;
  z-index: 2;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  text-align: center;
  padding: 0 24px;
}
.hero-static-badge {
  font-family: 'Poppins', sans-serif;
  font-size: 10px;
  font-weight: 400;
  letter-spacing: 5px;
  text-transform: uppercase;
  color: rgba(255,255,255,0.85);
  margin-bottom: 20px;
}
.hero-static-h1 {
  font-family: 'MoonCreme', Georgia, serif;
  font-size: clamp(48px, 8vw, 110px);
  font-weight: normal;
  letter-spacing: 6px;
  line-height: 1.05;
  color: #fff;
  margin: 0 0 20px;
  text-shadow: 0 2px 20px rgba(0,0,0,0.2);
}
.hero-static-sub {
  font-family: 'Poppins', sans-serif;
  font-size: 13px;
  font-weight: 300;
  letter-spacing: 3px;
  color: rgba(255,255,255,0.88);
  margin: 0 0 36px;
  text-transform: uppercase;
}
.hero-static-btn {
  display: inline-block;
  font-family: 'Poppins', sans-serif;
  font-size: 10px;
  font-weight: 400;
  letter-spacing: 4px;
  text-transform: uppercase;
  color: #fff;
  border: 1px solid rgba(255,255,255,0.8);
  padding: 12px 36px;
  text-decoration: none;
  transition: background 0.25s, color 0.25s;
}
.hero-static-btn:hover {
  background: #fff;
  color: #333;
  text-decoration: none;
}
@media (max-width: 767px) {
  .hero-static { height: 70vh; min-height: 380px; }
  .hero-static-h1 { font-size: clamp(36px, 12vw, 72px); letter-spacing: 3px; }
}
</style>

<style>
.hero-static-badge,
.hero-static-h1,
.hero-static-sub,
.hero-static-btn {
  opacity: 0;
  transform: translateY(10px);
}
.hero-static-badge { animation: heroFadeUp 1.8s cubic-bezier(.16,1,.3,1) 0.3s forwards; }
.hero-static-h1    { animation: heroFadeUp 2.2s cubic-bezier(.16,1,.3,1) 0.7s forwards; }
.hero-static-sub   { animation: heroFadeUp 2s   cubic-bezier(.16,1,.3,1) 1.2s forwards; }
.hero-static-btn   { animation: heroFadeUp 1.8s cubic-bezier(.16,1,.3,1) 1.7s forwards; }

@keyframes heroFadeUp {
  to { opacity: 1; transform: translateY(0); }
}
</style>

<?php
// Prioridad: banner2.* subido desde admin; si no existe, usar imagen de BD
$_banner_src  = '';
$_banner_alt  = 'De Papel Pintado';
$_banner_badge = 'Bienvenidos a';
$_banner_h1   = 'De Papel Pintado';
$_banner_sub  = 'Tu tienda de papel pintado online';
$_banner_url  = '/papel-pintado';
$_banner_btn  = 'Descubrir';
$_root = $_SERVER['DOCUMENT_ROOT'];
foreach (['webp','jpg','jpeg','png'] as $_bext) {
  if (file_exists($_root . '/images/banner2.' . $_bext)) {
    $_banner_src = '/images/banner2.' . $_bext . '?' . filemtime($_root . '/images/banner2.' . $_bext);
    break;
  }
}
$_banner2_exists = !empty($_banner_src);
if (!$_banner2_exists && !empty($images)) {
  $img = $images[0];
  $webp_path = $_SERVER['DOCUMENT_ROOT'] . '/includes/images/slider/' . $img->id . '.webp';
  $jpg_path  = $_SERVER['DOCUMENT_ROOT'] . '/includes/images/slider/' . $img->id . '.jpg';
  if (file_exists($webp_path))     $_banner_src = '/includes/images/slider/' . $img->id . '.webp';
  elseif (file_exists($jpg_path))  $_banner_src = '/includes/images/slider/' . $img->id . '.jpg';
  if (!empty($img->titulo) && $img->titulo !== 'NUEVA') $_banner_h1 = htmlspecialchars($img->titulo);
  if (!empty($img->texto))  $_banner_sub = htmlspecialchars($img->texto);
  if (!empty($img->enlace)) $_banner_url = htmlspecialchars($img->enlace);
}
?>
<div class="hero-static">
  <picture>
    <source srcset="<?= $_banner_src ?>" type="image/webp">
    <img src="<?= $_banner_src ?>" alt="<?= $_banner_alt ?>">
  </picture>
  <div class="hero-static-overlay"></div>
  <div class="hero-static-content">
    <p class="hero-static-badge"><?= $_banner_badge ?></p>
    <div class="hero-static-h1"><?= $_banner_h1 ?></div>
    <h1 class="hero-static-sub"><?= $_banner_sub ?></h1>
    <a href="<?= $_banner_url ?>" class="hero-static-btn"><?= $_banner_btn ?></a>
  </div>
</div>
