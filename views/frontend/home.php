<?php  
$gaur=date('Y-m-d');
//~ $gaur='2021-08-28';
$hilabete_eguna=date('m-d');
//~ $hilabete_eguna='08-31';
global $horario;
if ($hilabete_eguna>='08-01' && $hilabete_eguna<='08-31'){
  $horario="Horario de verano: de lunes a viernes de 10:00h a 14:00h";
//if ($gaur <= '2022-08-26')  
//  echo "<br />Viernes 26 de agosto cerrado por festivo local \n";
}
else{
  $horario= "De lunes a jueves de 9:30h a 14:30h y de 16:30h a 18:30h \n";
  $horario.= "<br />Viernes de 9:30h a 15:00h  \n";

//De 9:30h a 14:30h y de 16:30h a 18:30h
//Viernes de 9:30h a 15:00h

}
if ($gaur <= '2022-08-26')  
  $horario= "<br />Viernes 26 de agosto cerrado por festivo local \n";
?>

<style>
/* ===== TRUST BADGES ===== */
.trust-badges {
  padding: 48px 0 40px;
  background: #fff;
  border-bottom: 1px solid #eee;
}
/* Móvil: slider infinito */
.trust-slider-wrap {
  overflow: hidden;
  padding: 24px 0;
}
.trust-slider-track {
  display: flex;
  width: max-content;
  animation: trustScroll 18s linear infinite;
}
.trust-slide-item {
  width: 72vw;
  flex-shrink: 0;
  padding: 0 16px;
  text-align: center;
}
@keyframes trustScroll {
  0%   { transform: translateX(0); }
  100% { transform: translateX(-50%); }
}
.trust-badge-item {
  text-align: center;
  padding: 0 20px;
}
.trust-badge-icon {
  font-size: 28px;
  color: #aaa;
  margin-bottom: 12px;
  display: block;
}
.trust-badge-item h4 {
  font-size: 17px;
  font-weight: 700;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  color: #333;
  margin: 0 0 6px;
}
.trust-badge-item p {
  font-size: 17px;
  color: #888;
  margin: 0;
  line-height: 1.5;
}

/* ===== CATEGORÍAS GRID ===== */
.categorias-home {
  display: flex;
  flex-wrap: wrap;
  border-top: 1px solid #ddd;
}
.categoria-tile {
  flex: 0 0 25%;
  min-width: 0;
  position: relative;
  overflow: hidden;
  background: #FCF9F4;
  border-left: 1px solid #ddd;
  border-bottom: 1px solid #ddd;
}
.categoria-tile:nth-child(4n+1) { border-left: none; }
/* Fila de 3 */
.categoria-tile.tile-bottom { flex: 0 0 33.333%; }
.categoria-tile.tile-bottom:first-of-type,
.categorias-home .tile-bottom:nth-child(4n+1) { border-left: 1px solid #ddd; }
.categorias-home .tile-bottom:first-child { border-left: none; }
@media (max-width: 767px) {
  .categoria-tile { flex: 0 0 50%; }
  .categoria-tile:nth-child(odd) { border-left: none; }
  .categoria-tile:nth-child(even) { border-left: 1px solid #ddd; }
  /* Bottom tiles: 2 primeros al 50%, último al 100% */
  .categoria-tile.tile-bottom { flex: 0 0 50%; }
  .categoria-tile.tile-bottom:last-child { flex: 0 0 100%; border-left: none !important; }
  /* Texto más grande en móvil */
  .categoria-tile-label a { font-size: 16px; }
}
.categoria-tile a {
  display: block;
  text-decoration: none;
}
.categoria-tile-img-wrap {
  overflow: hidden;
}
.categoria-tile-img {
  width: 100%;
  aspect-ratio: 3 / 4;
  object-fit: cover;
  display: block;
  transition: transform 0.7s cubic-bezier(.25,.46,.45,.94);
}
.categoria-tile:hover .categoria-tile-img {
  transform: scale(1.08);
}
.categoria-tile-img-wrap::after {
  content: '';
  position: absolute;
  inset: 0;
  background: rgba(0,0,0,0);
  transition: background 0.4s ease;
  pointer-events: none;
}
.categoria-tile:hover .categoria-tile-img-wrap::after {
  background: rgba(0,0,0,0.18);
}
/* Label overlay en la parte superior de la imagen */
.categoria-tile-label {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  padding: 20px 12px 50px;
  background: linear-gradient(to bottom, rgba(0,0,0,0.5) 0%, transparent 100%);
  text-align: center;
  pointer-events: none;
}
.categoria-tile-label a {
  pointer-events: auto;
  font-size: clamp(13px, 1.5vw, 22px);
  font-weight: normal;
  letter-spacing: 4px;
  text-transform: uppercase;
  color: #fff !important;
  text-shadow: 0 1px 4px rgba(0,0,0,0.4);
  font-family: 'MoonCreme', Georgia, serif;
  text-decoration: none !important;
  transition: opacity 0.3s ease;
  border-bottom: none !important;
  display: block;
}
.categoria-tile:hover .categoria-tile-label a { opacity: 0.85; }

/* ===== POPUP REGISTRO HOME ===== */
.home-popup-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.55);
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  z-index: 9999;
  opacity: 0;
  visibility: hidden;
  transition: opacity 0.3s ease, visibility 0.3s ease;
}
.home-popup-overlay.is-visible {
  opacity: 1;
  visibility: visible;
}
.home-popup {
  position: relative;
  width: 100%;
  max-width: 860px;
  background: #fff;
  border-radius: 20px;
  overflow: hidden;
  box-shadow: 0 20px 60px rgba(0, 0, 0, 0.28);
}
.home-popup-close {
  position: absolute;
  top: 14px;
  right: 14px;
  width: 38px;
  height: 38px;
  border: 0;
  border-radius: 50%;
  background: rgba(255, 255, 255, 0.92);
  color: #333;
  font-size: 24px;
  line-height: 1;
  cursor: pointer;
  z-index: 2;
}
.home-popup-content {
  display: flex;
  min-height: 420px;
}
.home-popup-image,
.home-popup-copy {
  width: 50%;
}
.home-popup-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  display: block;
}
.home-popup-copy {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 42px 34px;
  text-align: center;
}
.home-popup-eyebrow {
  display: block;
  margin-bottom: 12px;
  font-size: 12px;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #a07d54;
}
.home-popup-copy h2 {
  font-size: clamp(30px, 4vw, 48px);
  line-height: 1;
  margin: 0 0 18px;
  color: #333;
  font-family: 'MoonCreme', Georgia, serif;
}
.home-popup-copy p {
  margin: 0 0 24px;
  font-size: 18px;
  line-height: 1.5;
  color: #555;
}
.home-popup-actions {
  display: flex;
  justify-content: center;
  gap: 12px;
  flex-wrap: wrap;
}
.home-popup-btn {
  display: inline-block;
  padding: 14px 24px;
  border-radius: 999px;
  text-decoration: none;
  font-size: 12px;
  letter-spacing: 2px;
  text-transform: uppercase;
  transition: all 0.2s ease;
}
.home-popup-btn-primary {
  background: #333;
  color: #fff;
}
.home-popup-btn-primary:hover {
  background: #000;
  color: #fff;
}
.home-popup-btn-secondary {
  background: transparent;
  color: #333;
  border: 1px solid #d7d7d7;
}
.home-popup-btn-secondary:hover {
  border-color: #333;
  color: #333;
}
@media (max-width: 767px) {
  .home-popup {
    max-width: 360px;
    background: #1f1a17;
  }
  .home-popup::before {
    content: '';
    position: absolute;
    inset: 0;
    background-image: linear-gradient(rgba(20,16,14,0.78), rgba(20,16,14,0.92)), url('/images/images home/papel pitnafo_1_11zon.webp');
    background-size: cover;
    background-position: center;
    z-index: 0;
  }
  .home-popup-content {
    position: relative;
    z-index: 1;
    min-height: auto;
  }
  .home-popup-image {
    display: none;
  }
  .home-popup-copy {
    width: 100%;
    padding: 28px 22px 30px;
    min-height: 360px;
    background: transparent;
  }
  .home-popup-eyebrow {
    color: #d7b691;
  }
  .home-popup-copy h2,
  .home-popup-copy p {
    color: #fff;
  }
  .home-popup-copy h2 {
    margin-bottom: 14px;
  }
  .home-popup-copy p {
    font-size: 16px;
    margin-bottom: 20px;
  }
  .home-popup-actions {
    gap: 10px;
  }
  .home-popup-btn {
    width: 100%;
    text-align: center;
  }
  .home-popup-btn-primary {
    background: #d7b691;
    color: #1f1a17;
  }
  .home-popup-btn-primary:hover {
    background: #e5c7a6;
    color: #1f1a17;
  }
  .home-popup-btn-secondary {
    color: #fff;
    border-color: rgba(255,255,255,0.35);
  }
  .home-popup-btn-secondary:hover {
    color: #fff;
    border-color: #fff;
  }
  .home-popup-close {
    background: rgba(255, 255, 255, 0.18);
    color: #fff;
  }
}
</style>

<div class="wrapper">
  <div class="home">

    <div class="home-popup-overlay" id="homeRegisterPopup" aria-hidden="true">
      <div class="home-popup" role="dialog" aria-modal="true" aria-labelledby="homeRegisterPopupTitle">
        <button type="button" class="home-popup-close" data-popup-close aria-label="Cerrar popup">&times;</button>
        <div class="home-popup-content">
          <div class="home-popup-image">
            <img src="/images/images home/papel pitnafo_1_11zon.webp" alt="Registro de dePapelPintado" loading="eager">
          </div>
          <div class="home-popup-copy">
            <div>
              <span class="home-popup-eyebrow">Inicio</span>
              <h2 id="homeRegisterPopupTitle">Regístrate</h2>
              <p>¿No tienes cuenta en dePapelPintado? Regístrate y consigue 10 euros de descuento.</p>
              <div class="home-popup-actions">
                <a class="home-popup-btn home-popup-btn-primary" href="/tienda/mi_cuenta/nueva">Regístrate</a>
                <a class="home-popup-btn home-popup-btn-secondary" href="#" data-popup-close>Ahora no</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- ===== TRUST BADGES ===== -->
    <div class="trust-badges">
      <!-- Desktop: grid normal -->
      <div class="container d-none d-md-block">
        <div class="row">
          <div class="col-md-3 trust-badge-item">
            <span class="trust-badge-icon"><i class="fas fa-exchange-alt"></i></span>
            <h4>Cambios y devoluciones</h4>
            <p>¡Hacemos cambios y devoluciones en cualquier compra sin problema!</p>
          </div>
          <div class="col-md-3 trust-badge-item">
            <span class="trust-badge-icon"><i class="far fa-user"></i></span>
            <h4>Atención personal</h4>
            <p>Te ayudamos a elegir, por teléfono, email, WhatsApp o videollamada.</p>
          </div>
          <div class="col-md-3 trust-badge-item">
            <span class="trust-badge-icon"><i class="far fa-heart"></i></span>
            <h4>Envíos gratis</h4>
            <p>Por compras superiores de 50€</p>
          </div>
          <div class="col-md-3 trust-badge-item">
            <span class="trust-badge-icon"><i class="far fa-paper-plane"></i></span>
            <h4>Envíos a Europa</h4>
            <p>¡Llegamos a todos los rincones! (Si estás en otro país igual escríbenos)</p>
          </div>
        </div>
      </div>
      <!-- Móvil: slider infinito -->
      <div class="trust-slider-wrap d-md-none">
        <div class="trust-slider-track">
          <?php for ($ti = 0; $ti < 2; $ti++): ?>
          <div class="trust-badge-item trust-slide-item">
            <span class="trust-badge-icon"><i class="fas fa-exchange-alt"></i></span>
            <h4>Cambios y devoluciones</h4>
            <p>¡Hacemos cambios y devoluciones en cualquier compra sin problema!</p>
          </div>
          <div class="trust-badge-item trust-slide-item">
            <span class="trust-badge-icon"><i class="far fa-user"></i></span>
            <h4>Atención personal</h4>
            <p>Te ayudamos a elegir, por teléfono, email, WhatsApp o videollamada.</p>
          </div>
          <div class="trust-badge-item trust-slide-item">
            <span class="trust-badge-icon"><i class="far fa-heart"></i></span>
            <h4>Envíos gratis</h4>
            <p>Por compras superiores de 50€</p>
          </div>
          <div class="trust-badge-item trust-slide-item">
            <span class="trust-badge-icon"><i class="far fa-paper-plane"></i></span>
            <h4>Envíos a Europa</h4>
            <p>¡Llegamos a todos los rincones!</p>
          </div>
          <?php endfor; ?>
        </div>
      </div>
    </div>

    <!-- ===== 4 TILES PRINCIPALES ===== -->
    <?php
    // Mapeo de imágenes por categoría
    $img_map = [
      'papel pintado'        => '/images/images home/papel pitnafo_1_11zon.webp',
      'fotomurales'          => '/images/images home/murales_10_11zon.webp',
      'murales'              => '/images/images home/murales_10_11zon.webp',
      'revestimientos'       => '/images/images home/revestimiento_2_11zon.webp',
      'telas'                => '/images/images home/ultimo_3_11zon.webp',
      'alfombras a medida'   => null,
      'alfombras-a-medida'   => null,
      'alfombras vinilic'    => '/images/images home/alformas viniladas_5_11zon.webp',
      'alfombras vinilicas'  => '/images/images home/alformas viniladas_5_11zon.webp',
      'alfombras vinílicas'  => '/images/images home/alformas viniladas_5_11zon.webp',
      'alfombras'            => '/images/images home/alfomas_4_11zon.webp',
      'complementos'         => '/images/images home/complementos.webp',
    ];
    function get_categ_img($titulo, $img_map) {
      $key  = mb_strtolower(trim($titulo));
      $slug = urlenc($titulo);
      $root = $_SERVER['DOCUMENT_ROOT'];
      // Buscar imagen subida desde admin (cualquier formato)
      foreach (['webp','jpg','jpeg','png'] as $ext) {
        $f = $root . '/images/home-categories/' . $slug . '.' . $ext;
        if (file_exists($f))
          return '/images/home-categories/' . $slug . '.' . $ext . '?' . filemtime($f);
      }
      // Fallback al mapa hardcodeado original
      foreach ($img_map as $k => $v) {
        if (strpos($key, $k) !== false) return $v;
      }
      return null;
    }

    // Orden deseado: papel pintado, alfombras, murales, revestimientos arriba; telas y resto abajo
    $orden_top  = ['papel pintado','alfombras','fotomurales','murales','revestimientos'];
    $mosaico_arr = (array)$mosaico;
    $mosaico_principal = [];
    $mosaico_resto = [];
    // Colocar en orden correcto
    foreach ($orden_top as $cat) {
      foreach ($mosaico_arr as $el) {
        if (mb_strtolower(trim($el->titulo)) === $cat && count($mosaico_principal) < 4) {
          $mosaico_principal[] = $el;
          break;
        }
      }
    }
    // El resto
    foreach ($mosaico_arr as $el) {
      if (!in_array($el, $mosaico_principal)) $mosaico_resto[] = $el;
    }
    $label_map = ['FOTOMURALES' => 'MURALES'];
    ?>
    <?php
    $cats_secundarias = [
      ['titulo' => 'TELAS',              'enlace' => '/telas',        'slug' => 'telas'],
      ['titulo' => 'ALFOMBRAS A MEDIDA', 'enlace' => '/alfombras-a-medida',  'slug' => 'alfombras-a-medida'],
      ['titulo' => 'COMPLEMENTOS',       'enlace' => '/complementos', 'slug' => 'complementos'],
    ];
    foreach ($cats_secundarias as &$cs) {
      foreach ($mosaico_resto as $el) {
        if (mb_strtolower(trim($el->titulo)) === mb_strtolower($cs['slug'])) {
          if (!empty($el->enlace)) $cs['enlace'] = $el->enlace;
          break;
        }
      }
    }
    unset($cs);
    ?>
    <div class="categorias-home">
      <?php foreach ($mosaico_principal as $i => $el):
        $title = ucwords(mb_strtolower($el->titulo));
        $img_src = get_categ_img($el->titulo, $img_map);
        $img_fallback = '/includes/images/home/' . urlenc($el->titulo) . '.jpg';
        $titulo_display = isset($label_map[strtoupper($el->titulo)]) ? $label_map[strtoupper($el->titulo)] : $el->titulo;
      ?>
      <div class="categoria-tile">
        <a href="<?= $el->enlace ?>" title="<?= $title ?>">
          <div class="categoria-tile-img-wrap">
            <?php if ($img_src): ?>
              <img class="categoria-tile-img" src="<?= htmlspecialchars($img_src) ?>" alt="<?= $title ?>" loading="<?= $i === 0 ? 'eager' : 'lazy' ?>">
            <?php else: ?>
              <img class="categoria-tile-img" src="<?= $img_fallback ?>" alt="<?= $title ?>" loading="lazy">
            <?php endif; ?>
          </div>
        </a>
        <div class="categoria-tile-label">
          <a href="<?= $el->enlace ?>"><h3 style="font-size:inherit;font-weight:inherit;letter-spacing:inherit;text-transform:inherit;color:inherit;margin:0;"><?= $titulo_display ?></h3></a>
        </div>
      </div>
      <?php endforeach; ?>
      <?php foreach ($cats_secundarias as $cs):
        $img_src_cs = get_categ_img($cs['slug'], $img_map);
        $img_fallback_cs = '/includes/images/home/' . urlenc($cs['slug']) . '.jpg';
      ?>
      <div class="categoria-tile tile-bottom">
        <a href="<?= $cs['enlace'] ?>" title="<?= htmlspecialchars($cs['titulo']) ?>">
          <div class="categoria-tile-img-wrap">
            <?php if ($img_src_cs): ?>
              <img class="categoria-tile-img" src="<?= htmlspecialchars($img_src_cs) ?>" alt="<?= htmlspecialchars($cs['titulo']) ?>" loading="lazy">
            <?php else: ?>
              <img class="categoria-tile-img" src="<?= $img_fallback_cs ?>" alt="<?= htmlspecialchars($cs['titulo']) ?>" loading="lazy" onerror="this.style.opacity=0.1">
            <?php endif; ?>
          </div>
        </a>
        <div class="categoria-tile-label">
          <a href="<?= $cs['enlace'] ?>"><h3 style="font-size:inherit;font-weight:inherit;letter-spacing:inherit;text-transform:inherit;color:inherit;margin:0;"><?= $cs['titulo'] ?></h3></a>
        </div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- ===== PRODUCTOS DESTACADOS ===== -->
    <?php if (!empty($novedades)): ?>
    <style>
    .productos-home {
      padding: 56px 0 48px;
      background: #fff;
    }
    .productos-home-titulo {
      text-align: center;
      font-size: 11px;
      font-weight: 300;
      letter-spacing: 5px;
      text-transform: uppercase;
      color: #555;
      margin-bottom: 40px;
      font-family: 'Poppins', sans-serif;
    }
    .producto-card {
      margin-bottom: 32px;
    }
    .producto-card-img-wrap {
      position: relative;
      overflow: hidden;
      background: #FCF9F4;
      margin-bottom: 12px;
    }
    .producto-card-img {
      width: 100%;
      aspect-ratio: 3 / 4;
      object-fit: cover;
      display: block;
      transition: transform 0.5s ease;
    }
    .producto-card:hover .producto-card-img { transform: scale(1.04); }
    .badge-novedad, .badge-descuento {
      position: absolute;
      top: 10px;
      right: 10px;
      font-size: 10px;
      font-weight: 600;
      letter-spacing: 1px;
      text-transform: uppercase;
      padding: 4px 8px;
      z-index: 2;
    }
    .badge-novedad { background: #fff; color: #333; }
    .badge-descuento { background: #333; color: #fff; }
    .producto-card-info { text-align: left; }
    .producto-card-ref {
      font-size: 17px;
      font-weight: 400;
      letter-spacing: 0.5px;
      text-transform: uppercase;
      color: #333;
      margin: 0 0 4px;
      line-height: 1.3;
    }
    .producto-card-ref a { color: inherit; text-decoration: none; }
    .producto-card-ref a:hover { color: #BB8AA3; }
    .producto-card-precio {
      font-size: 12px;
      color: #555;
      margin: 0 0 8px;
    }
    .producto-card-precio .precio-tachado {
      text-decoration: line-through;
      color: #aaa;
      margin-right: 4px;
    }
    .producto-card-precio .precio-oferta {
      color: #c0392b;
      font-weight: 600;
    }
    .producto-card-precio .precio-actual {
      color: #333;
    }
    .swatches {
      display: flex;
      gap: 4px;
      flex-wrap: wrap;
    }
    .swatch {
      width: 14px;
      height: 14px;
      border-radius: 50%;
      border: 1px solid rgba(0,0,0,0.12);
      display: inline-block;
      flex-shrink: 0;
    }
    .productos-home-ver-todos {
      text-align: center;
      padding-top: 16px;
    }
    .productos-home-ver-todos a {
      font-size: 11px;
      font-weight: 300;
      letter-spacing: 4px;
      text-transform: uppercase;
      color: #333;
      text-decoration: none;
      border-bottom: 1px solid #333;
      padding-bottom: 2px;
      font-family: 'Poppins', sans-serif;
      transition: color 0.2s, border-color 0.2s;
    }
    .productos-home-ver-todos a:hover { color: #BB8AA3; border-color: #BB8AA3; }
    </style>

    <?php
    // Mapa tonalidad → color CSS
    $tonalidad_css = [
      1 => '#c8c8c8', // Blanco/Negro
      2 => '#c9a87c', // Crudo/Marrón
      3 => '#f0c040', // Amarillos
      4 => '#7a9fc4', // Azules/Morados
      5 => '#d98090', // Rosas/Rojos
      6 => '#7cb87a', // Verdes
      7 => 'linear-gradient(135deg,#e55,#55e,#5e5)', // Multicolor
      8 => '#b8b0a8', // Metalizados
    ];
    $tipo_label = [0=>'Papel Pintado',1=>'Mural',2=>'Revestimiento',3=>'Tela',4=>'Alfombra',5=>'Herramienta'];
    $tipo_url   = [0=>'papel-pintado',1=>'murales',2=>'revestimientos',3=>'telas',4=>'alfombras'];
    ?>

    <div class="productos-home">
      <div class="container">
        <p class="productos-home-titulo">Selección</p>
        <div class="row">
          <?php foreach ($novedades as $k):
            $pre = isset($tipo_label[$k['item_tipo']]) ? $tipo_label[$k['item_tipo']] : '';
            $url = '';
            if ($k['item_tipo'] != 5 && isset($tipo_url[$k['item_tipo']]))
              $url = '/tienda/articulo/'.urlenc($k['cat_name']).'/'.urlenc($k['coleccion_name']).'/id/'.$k['item_id'];
            else
              $url = '/tienda/articulo/herramientas/'.urlenc(strtolower(preg_replace('/[^A-Za-z0-9\-]/',' ',$k['item_name']))).'/id/'.$k['item_id'];

            $img = '/includes/'.str_replace('../', '', $k['img']).'med.jpg';
            $img_hover = '';
            if (!empty($k['imgamb']) && $k['imgamb'] != $k['img'])
              $img_hover = '/includes/'.str_replace('../', '', $k['imgamb']).'med.jpg';
            elseif (!empty($k['img']))
              $img_hover = '';

            $precio_original = $k['item_price'];
            $precio_final    = $k['item_price'];
            if (!empty($k['item_price_aux']) && $k['item_price_aux'] > 0 && $k['item_price_aux'] < $precio_original)
              $precio_final = $k['item_price_aux'];
            $tiene_descuento = ($precio_final < $precio_original);
            $pct_dto = $tiene_descuento ? round((1 - $precio_final/$precio_original)*100) : 0;

            // Swatches
            $tonalidades = array_filter(array_unique(explode(',', (string)$k['tonalidades'])));
          ?>
          <div class="col-6 col-md-3 producto-card">
            <div class="producto-card-img-wrap">
              <?php if ($tiene_descuento): ?>
                <span class="badge-descuento"><?= $pct_dto ?>% OFF</span>
              <?php endif; ?>
              <a href="<?= $url ?>">
                <picture>
                  <source srcset="<?= str_replace('.jpg','.webp',$img) ?>" type="image/webp">
                  <img class="producto-card-img<?= $img_hover ? ' has-hover-img' : '' ?>"
                       src="<?= $img ?>"
                       alt="<?= htmlspecialchars($k['meta_title']) ?>"
                       loading="lazy"
                       <?= $img_hover ? 'data-hover="'.htmlspecialchars($img_hover).'" data-src-original="'.htmlspecialchars($img).'"' : '' ?>>
                </picture>
              </a>
            </div>
            <div class="producto-card-info">
              <p class="producto-card-ref"><a href="<?= $url ?>"><?= $pre ?> <?= htmlspecialchars($k['item_ref']) ?></a></p>
              <p class="producto-card-precio">
                <?php if ($tiene_descuento): ?>
                  <span class="precio-tachado"><?= number_format($precio_original,2,',','.') ?> €</span>
                  <span class="precio-oferta"><?= number_format($precio_final,2,',','.') ?> €</span>
                <?php else: ?>
                  <span class="precio-actual"><?= number_format($precio_final,2,',','.') ?> €</span>
                <?php endif; ?>
              </p>
              <?php if (!empty($tonalidades)): ?>
              <div class="swatches">
                <?php foreach (array_slice($tonalidades, 0, 5) as $tid):
                  $tid = (int)$tid;
                  if (!isset($tonalidad_css[$tid])) continue;
                  $bg = $tonalidad_css[$tid];
                  $is_gradient = strpos($bg, 'gradient') !== false;
                  $style = $is_gradient ? "background:$bg;" : "background-color:$bg;";
                ?>
                  <span class="swatch" style="<?= $style ?>"></span>
                <?php endforeach; ?>
              </div>
              <?php endif; ?>
            </div>
          </div>
          <?php endforeach; ?>
        </div>
        <div class="productos-home-ver-todos">
          <a href="/papel-pintado">Ver todos los productos</a>
        </div>
      </div>
    </div>
    <script>
    (function() {
      function initHoverHome() {
        document.querySelectorAll('.productos-home img.has-hover-img').forEach(function(img) {
          var hoverSrc = img.getAttribute('data-hover');
          var origSrc  = img.getAttribute('data-src-original');
          if (!hoverSrc) return;
          img.addEventListener('mouseenter', function() { img.src = hoverSrc; });
          img.addEventListener('mouseleave', function() { img.src = origSrc; });
        });
      }
      if (document.readyState === 'loading')
        document.addEventListener('DOMContentLoaded', initHoverHome);
      else
        initHoverHome();
    })();
    </script>
    <?php endif; ?>

    <!-- ===== USO O ESTANCIA ===== -->
    <?php if (!empty($estancias_home)): ?>
    <style>
    .estancias-home {
      padding: 56px 0 60px;
      background: #FCF9F4;
    }
    .estancias-home-header {
      margin-bottom: 32px;
      padding: 0 15px;
    }
    .estancias-home-titulo {
      font-size: clamp(24px, 3vw, 40px);
      font-weight: normal;
      letter-spacing: 5px;
      text-transform: uppercase;
      color: #727272;
      margin: 0;
      font-family: 'MoonCreme', Georgia, serif;
    }
    .estancia-tile {
      margin-bottom: 8px;
    }
    .estancia-tile-img-wrap {
      overflow: hidden;
      margin-bottom: 10px;
    }
    .estancia-tile-img {
      width: 100%;
      aspect-ratio: 1 / 1;
      object-fit: cover;
      display: block;
      transition: transform 0.5s ease;
    }
    .estancia-tile:hover .estancia-tile-img { transform: scale(1.04); }
    .estancia-tile-label {
      font-size: clamp(14px, 1.5vw, 20px);
      font-weight: normal;
      letter-spacing: 3px;
      text-transform: uppercase;
      color: #727272;
      text-align: center;
      font-family: 'MoonCreme', Georgia, serif;
    }
    .estancia-tile-label a { color: inherit; text-decoration: none; }
    .estancia-tile-label a:hover { color: #BB8AA3; }
    </style>

    <div class="estancias-home">
      <div class="container">
        <div class="estancias-home-header">
          <h2 class="estancias-home-titulo">Papel Pintado</h2>
        </div>
        <div class="row">
          <?php
          $estancia_img_map = [
            'dormitorio' => '/images/images home/dormitorios_7_11zon.webp',
            'cocina'     => '/images/images home/la dos de papel_9_11zon.webp',
            'pasillo'    => '/images/images home/murales2_11_11zon.webp',
          ];
        foreach ($estancias_home as $est):
            // Buscar override por nombre de estancia
            $img = null;
            $nombre_lower = mb_strtolower($est['nueva_categoria_name']);
            foreach ($estancia_img_map as $key => $path) {
              if (strpos($nombre_lower, $key) !== false) { $img = $path; break; }
            }
            if (!$img) {
              // 1) categoria_img desde la BD
              if (!empty($est['categoria_img'])) {
                $img = '/includes/' . str_replace('../', '', $est['categoria_img']);
              } else {
                // 2) imagen estándar en categorias-productos/{id}-{slug}.jpg
                $slug_file = $est['nueva_categoria_id'] . '-' . $est['nueva_categoria_name_url'] . '.jpg';
                $cat_server = FCPATH . 'includes/images/categorias-productos/' . $slug_file;
                if (file_exists($cat_server)) {
                  $img = '/includes/images/categorias-productos/' . $slug_file;
                } elseif (!empty($est['product_img'])) {
                  $img = '/includes/' . str_replace('../', '', $est['product_img']) . 'med.jpg';
                } else {
                  $img = '/includes/images/blank.png';
                }
              }
            }
            // Label: quitar prefijo "Papel pintado para "
            $label = preg_replace('/^papel pintado para /i', '', $est['nueva_categoria_name']);
            $url = '/' . $est['nueva_categoria_name_url'];
          ?>
          <div class="col-6 col-md-3 estancia-tile">
            <a href="<?= $url ?>">
              <div class="estancia-tile-img-wrap">
                <img class="estancia-tile-img" src="<?= $img ?>" alt="<?= htmlspecialchars($est['nueva_categoria_name']) ?>" loading="lazy">
              </div>
            </a>
            <p class="estancia-tile-label"><a href="<?= $url ?>"><?= htmlspecialchars($label) ?></a></p>
          </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endif; ?>

  </div>
</div>

<?php if (!empty($faqs)): ?>
<style>
.faq-home-section { background: #f9f6f4; padding: 56px 0 64px; }
.faq-home-section h2 { font-size: 26px; font-weight: 400; color: #333; text-align: center; margin: 0 0 36px; letter-spacing: .02em; }
.faq-home-list { max-width: 760px; margin: 0 auto; }
.faq-home-item { background: #fff; border-radius: 8px; margin-bottom: 10px; box-shadow: 0 1px 4px rgba(0,0,0,.07); overflow: hidden; }
.faq-home-btn { display: flex; justify-content: space-between; align-items: center; width: 100%; background: none; border: none; padding: 20px 22px; font-size: 15px; font-weight: 600; color: #333; cursor: pointer; text-align: left; gap: 16px; line-height: 1.45; }
.faq-home-btn:hover { color: #B05380; }
.faq-home-icon { flex-shrink: 0; font-size: 22px; color: #B05380; font-weight: 300; transition: transform .25s; line-height: 1; }
.faq-home-btn.open .faq-home-icon { transform: rotate(45deg); }
.faq-home-body { display: none; padding: 0 22px 20px; font-size: 14px; color: #555; line-height: 1.75; border-top: 1px solid #f0ece9; }
</style>
<div class="faq-home-section">
  <div class="container">
    <h2>Preguntas frecuentes</h2>
    <div class="faq-home-list" itemscope itemtype="https://schema.org/FAQPage">
      <?php foreach ($faqs as $faq): ?>
      <div class="faq-home-item" itemprop="mainEntity" itemscope itemtype="https://schema.org/Question">
        <button class="faq-home-btn" itemprop="name" onclick="var b=this.nextElementSibling;b.style.display=b.style.display==='block'?'none':'block';this.classList.toggle('open');">
          <span><?= htmlspecialchars($faq->pregunta) ?></span>
          <span class="faq-home-icon">+</span>
        </button>
        <div class="faq-home-body" itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer">
          <span itemprop="text"><?= nl2br(htmlspecialchars($faq->respuesta)) ?></span>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</div>
<script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "FAQPage",
  "mainEntity": [
    <?php foreach ($faqs as $i => $faq): ?>
    <?= $i > 0 ? ',' : '' ?>
    {
      "@type": "Question",
      "name": <?= json_encode($faq->pregunta, JSON_UNESCAPED_UNICODE) ?>,
      "acceptedAnswer": {
        "@type": "Answer",
        "text": <?= json_encode($faq->respuesta, JSON_UNESCAPED_UNICODE) ?>
      }
    }
    <?php endforeach; ?>
  ]
}
</script>
<?php endif; ?>

<script>
(function() {
  var popup = document.getElementById('homeRegisterPopup');
  if (!popup) return;

  var popupTimer;

  function openPopup() {
    popup.classList.add('is-visible');
    popup.setAttribute('aria-hidden', 'false');
    document.body.style.overflow = 'hidden';
  }

  function closePopup() {
    popup.classList.remove('is-visible');
    popup.setAttribute('aria-hidden', 'true');
    document.body.style.overflow = '';
  }

  function initHomePopup() {
    popupTimer = window.setTimeout(openPopup, 3000);

    popup.addEventListener('click', function(event) {
      if (event.target === popup || event.target.hasAttribute('data-popup-close')) {
        closePopup();
      }
    });

    document.addEventListener('keydown', function(event) {
      if (event.key === 'Escape') {
        closePopup();
      }
    });
  }

  if (document.readyState === 'loading')
    document.addEventListener('DOMContentLoaded', initHomePopup);
  else
    initHomePopup();
})();
</script>

<script>
(function() {
  if (!('IntersectionObserver' in window)) return;

  var groups = [
    { sel: '.trust-badge-item',       anim: 'fade-up',    stagger: 60,  dur: 2200 },
    { sel: '.categoria-tile',         anim: 'fade-up',    stagger: 50,  dur: 2400 },
    { sel: '.productos-home-titulo',  anim: 'fade-up',    stagger: 0,   dur: 2200 },
    { sel: '.producto-card',          anim: 'fade-up',    stagger: 40,  dur: 2000 },
    { sel: '.banner-duo-item',        anim: 'fade-sides', stagger: 100, dur: 2300 },
    { sel: '.estancias-home-titulo',  anim: 'fade-up',    stagger: 0,   dur: 2200 },
    { sel: '.estancia-tile',          anim: 'fade-up',    stagger: 50,  dur: 2000 },
  ];

  var inits = {
    'fade-up':    { opacity:'0.2', transform:'translateY(8px)' },
    'fade-in':    { opacity:'0.2', transform:'' },
    'fade-left':  { opacity:'0.2', transform:'translateX(-8px)' },
    'fade-right': { opacity:'0.2', transform:'translateX(8px)' },
  };

  groups.forEach(function(g) {
    var els = document.querySelectorAll(g.sel);
    if (!els.length) return;

    // Aplicar estado inicial (oculto)
    els.forEach(function(el, i) {
      var anim = g.anim === 'fade-sides' ? (i % 2 === 0 ? 'fade-left' : 'fade-right') : g.anim;
      var s = inits[anim];
      el.style.opacity = s.opacity;
      if (s.transform) el.style.transform = s.transform;
      el.style.willChange = 'opacity, transform';
    });

    var obs = new IntersectionObserver(function(entries) {
      entries.forEach(function(entry) {
        if (!entry.isIntersecting) return;
        var el = entry.target;
        var i = Array.prototype.indexOf.call(els, el);
        setTimeout(function() {
          el.style.transition = 'opacity ' + g.dur + 'ms cubic-bezier(.16,1,.3,1), transform ' + g.dur + 'ms cubic-bezier(.16,1,.3,1)';
          el.style.opacity = '1';
          el.style.transform = 'none';
        }, i * g.stagger);
        obs.unobserve(el);
      });
    }, { threshold: 0.08, rootMargin: '0px 0px -20px 0px' });

    els.forEach(function(el) { obs.observe(el); });
  });
})();
</script>
<!--
<li class="subcategory-block">
  <div class="preficha subcategory-image">
    <a href="papel-pintado-abstracto" title="Papel pintado abstracto">
      <img class="img-fluid" src="/includes/images/categorias-productos/47-papel-pintado-abstracto.jpgth.jpg" alt="Papel pintado abstracto" title="Papel pintado abstracto">
    </a>
  </div>
  <div class="subcategory-meta">
    <h3>
      <a href="papel-pintado-abstracto" title="Papel pintado abstracto">
        Papel pintado abstracto                      </a>
    </h3>
    <div class="subcategory-description"></div>
  </div>
</li>
-->             

<?php
/*

<div class="units-row units-padding">
 <div class="unit-centered unit-80 cuerpocentral blancobg sombra">
 
 <div class="units-row end">

<div class="unit-100">

 <hr>
 </div>
   </div>
  <div class="units-row end">
    <div class="unit-40">
      <div class="bloqueshome text-centered">
        <h3><?=anchor("outlet",'Outlet');?></h3>
        <p>  
          <?=anchor("outlet",'<img src="'.$includes_dir.'images/outlet-papelpintado.png" alt="Outlet" title="Outlet" />');?>
        </p>
      </div>
      <ul class="listahome">

        <?php if(false){?>
         <li>Muestras gratis <span class="small"><?=anchor("informacion_muestras_papel_pintado",'Información');?></span></li>
         <li>Portes gratis</li>
        <?php }?>
      </ul>
    </div>
  </div>
  
<!--html plano  -->
<hr>
<ul class="blocks-3 bloqueshome text-centered">
  <li class="promos">
    <h3><?=anchor("marcas",'Marcas');?></h3>
    <p>  
      <?=anchor("marcas",'<img src="'.$includes_dir.'images/img-marcas-inicio.jpg"  alt="Marcas"  alt="Marcas" title="Todas las marcas" />');?>
    </p>
  </li>
  <li class="promos"> 
    <h3><?=anchor("contacto",'Atencion al Cliente');?></h3>
    <p>
      <?=anchor("contacto",'<img src="'.$includes_dir.'images/atencion-al-cliente.jpg"  alt="Llámanos al tlf - 94 405 66 16 . Horario: de 9:30h a 15:00h"  title="Atención al cliente" />');?>
    </p>
  </li>
  <li class="promos"> 
    <h3><?=anchor("ayuda_papel_pintado",'Te ayudamos');?></h3>
    <p> 
      <?=anchor("ayuda_papel_pintado",'<img src="'.$includes_dir.'images/img-ayudamos-inicio.jpg"  alt="Te ayudamos" alt="Te ayudamos" title="Te ayudamos" />');?>
    </p>
  </li>
</ul>
<!--fin html plano  -->
</div>
</div>


*/
?>
