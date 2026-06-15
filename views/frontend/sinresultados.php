<?php
// Mensaje contextual según la categoría
$cat_nombre = isset($familia_producto) ? $familia_producto : '';
$cat_url    = '';
$cat_icono  = 'roll'; // roll | carpet | fabric | tool

if ($cat_nombre == 'Papel Pintado')    { $cat_url = '/tienda/papel_pintado';   $cat_icono = 'roll'; }
elseif ($cat_nombre == 'Murales')      { $cat_url = '/tienda/murales';         $cat_icono = 'roll'; }
elseif ($cat_nombre == 'Revestimientos'){ $cat_url = '/tienda/revestimientos'; $cat_icono = 'roll'; }
elseif ($cat_nombre == 'Telas')        { $cat_url = '/tienda/telas';           $cat_icono = 'fabric'; }
elseif ($cat_nombre == 'Alfombras')    { $cat_url = '/tienda/alfombras';       $cat_icono = 'carpet'; }
elseif ($cat_nombre == 'Herramientas') { $cat_url = '/tienda/herramientas';    $cat_icono = 'tool'; }
elseif ($cat_nombre == 'Complementos') { $cat_url = '/tienda/complementos';    $cat_icono = 'tool'; }

$es_busqueda = isset($_POST['search']) || isset($_GET['search']);

$titulo = $es_busqueda
  ? 'Sin resultados para tu búsqueda'
  : 'Próximamente' . ($cat_nombre ? ' en ' . $cat_nombre : '');

$subtitulo = $es_busqueda
  ? 'Prueba con otros términos o explora nuestras categorías'
  : 'Estamos trabajando para traerte las mejores novedades';
?>
<style>
@keyframes float-sr    { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-10px)} }
@keyframes draw-sr     { to{stroke-dashoffset:0} }
@keyframes scan-sr     { to{stroke-dashoffset:-22} }
@keyframes pulse-sr    { 0%{r:4;opacity:.7} 70%{r:9;opacity:0} 100%{r:9;opacity:0} }
@keyframes blink-dots  { 0%,80%,100%{opacity:0} 40%{opacity:1} }
@keyframes fadeup-sr   { from{opacity:0;transform:translateY(14px)} to{opacity:1;transform:translateY(0)} }

.sinres-wrap {
  padding: 56px 20px 72px;
  display: flex;
  flex-direction: column;
  align-items: center;
  text-align: center;
}
.sinres-icon {
  width: 110px;
  height: 110px;
  margin: 0 auto 32px;
  animation: float-sr 3.5s ease-in-out infinite;
}
/* SVG paths */
.sr-outline { stroke-dasharray:300; stroke-dashoffset:300; animation:draw-sr 1s ease forwards; }
.sr-outline-2{ animation-delay:.15s }
.sr-outline-3{ animation-delay:.3s }
.sr-outline-4{ animation-delay:.45s }
.sr-scan     { stroke-dasharray:11 5; animation:scan-sr .9s linear infinite; }
.sr-scan-2   { animation-delay:-.3s }
.sr-scan-3   { animation-delay:-.6s }
.sr-pulse    { animation:pulse-sr 1.9s ease-out infinite; transform-origin:79px 37px; }

/* Puntos "próximamente" */
.sinres-dots span {
  display: inline-block;
  width: 7px; height: 7px;
  background: #BB8AA3;
  border-radius: 50%;
  margin: 0 3px;
  animation: blink-dots 1.4s ease-in-out infinite;
}
.sinres-dots span:nth-child(2){ animation-delay:.2s }
.sinres-dots span:nth-child(3){ animation-delay:.4s }

.sinres-title {
  font-family: 'MoonCreme', Georgia, serif;
  font-size: clamp(22px, 3.5vw, 34px);
  font-weight: normal;
  letter-spacing: 3px;
  color: #222;
  margin: 0 0 10px;
  animation: fadeup-sr .6s ease .8s both;
}
.sinres-sub {
  font-family: 'Poppins', sans-serif;
  font-size: 13px;
  color: #999;
  font-weight: 300;
  margin: 0 0 10px;
  animation: fadeup-sr .6s ease .95s both;
}
.sinres-dots { margin: 0 0 36px; animation: fadeup-sr .6s ease 1.1s both; }

.sinres-search {
  display: flex;
  width: 100%;
  max-width: 460px;
  border: 1px solid #ccc;
  overflow: hidden;
  margin: 0 auto 44px;
  transition: border-color .2s, box-shadow .2s;
  animation: fadeup-sr .6s ease 1.1s both;
}
.sinres-search:focus-within { border-color:#333; box-shadow:0 4px 18px rgba(0,0,0,.07); }
.sinres-search input {
  flex:1; border:none; outline:none;
  padding:12px 16px;
  font-family:'Poppins',sans-serif; font-size:13px; color:#333;
}
.sinres-search button {
  background:#333; color:#fff; border:none;
  padding:12px 18px; cursor:pointer; font-size:13px;
  transition:background .2s;
}
.sinres-search button:hover { background:#BB8AA3; }

.sinres-cats { display:flex; flex-wrap:wrap; gap:8px; justify-content:center; max-width:560px; margin:0 auto; animation:fadeup-sr .6s ease 1.25s both; }
.sinres-cats-label { font-family:'Poppins',sans-serif; font-size:10px; font-weight:700; letter-spacing:3px; text-transform:uppercase; color:#ccc; margin-bottom:14px; animation:fadeup-sr .6s ease 1.25s both; }
.sinres-cats a {
  font-family:'Poppins',sans-serif; font-size:11px; font-weight:500;
  letter-spacing:1.5px; text-transform:uppercase;
  color:#555; text-decoration:none;
  border:1px solid #ddd; padding:7px 14px;
  transition:all .2s;
}
.sinres-cats a:hover { background:#333; color:#fff; border-color:#333; }
</style>

<div class="sinres-wrap">

  <?php if ($cat_icono == 'carpet'): ?>
  <!-- Icono alfombra -->
  <svg class="sinres-icon" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
    <rect class="sr-outline"   x="15" y="20" width="70" height="60" rx="3" stroke="#333" stroke-width="3.5"/>
    <rect class="sr-outline sr-outline-2" x="22" y="27" width="56" height="46" rx="2" stroke="#BB8AA3" stroke-width="2"/>
    <line class="sr-scan"   x1="25" y1="40" x2="75" y2="40" stroke="#BB8AA3" stroke-width="2" stroke-linecap="round"/>
    <line class="sr-scan sr-scan-2" x1="25" y1="50" x2="75" y2="50" stroke="#BB8AA3" stroke-width="2" stroke-linecap="round"/>
    <line class="sr-scan sr-scan-3" x1="25" y1="60" x2="75" y2="60" stroke="#BB8AA3" stroke-width="2" stroke-linecap="round"/>
    <line class="sr-outline sr-outline-3" x1="15" y1="20" x2="15" y2="80" stroke="#333" stroke-width="5" stroke-linecap="round"/>
    <line class="sr-outline sr-outline-3" x1="85" y1="20" x2="85" y2="80" stroke="#333" stroke-width="5" stroke-linecap="round"/>
  </svg>

  <?php elseif ($cat_icono == 'fabric'): ?>
  <!-- Icono tela / rollo de tela -->
  <svg class="sinres-icon" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
    <ellipse class="sr-outline" cx="50" cy="50" rx="28" ry="18" stroke="#333" stroke-width="3.5"/>
    <ellipse class="sr-outline sr-outline-2" cx="50" cy="32" rx="28" ry="18" stroke="#333" stroke-width="3.5"/>
    <line class="sr-outline sr-outline-3" x1="22" y1="32" x2="22" y2="50" stroke="#333" stroke-width="3.5"/>
    <line class="sr-outline sr-outline-3" x1="78" y1="32" x2="78" y2="50" stroke="#333" stroke-width="3.5"/>
    <line class="sr-scan"   x1="28" y1="38" x2="72" y2="38" stroke="#BB8AA3" stroke-width="1.8" stroke-linecap="round"/>
    <line class="sr-scan sr-scan-2" x1="28" y1="44" x2="72" y2="44" stroke="#BB8AA3" stroke-width="1.8" stroke-linecap="round"/>
  </svg>

  <?php else: ?>
  <!-- Icono muestrario de papel pintado (default) -->
  <svg class="sinres-icon" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
    <circle class="sr-pulse" cx="79" cy="37" r="4" stroke="#BB8AA3" stroke-width="1.5" fill="none"/>
    <line class="sr-outline sr-outline-4" x1="35" y1="70" x2="35" y2="82" stroke="#555" stroke-width="3" stroke-linecap="round"/>
    <line class="sr-outline sr-outline-4" x1="65" y1="70" x2="65" y2="82" stroke="#555" stroke-width="3" stroke-linecap="round"/>
    <line class="sr-outline sr-outline-4" x1="30" y1="82" x2="70" y2="82" stroke="#555" stroke-width="3" stroke-linecap="round"/>
    <rect  class="sr-outline"   x="18" y="30" width="64" height="40" rx="3" stroke="#333" stroke-width="3.5"/>
    <rect  class="sr-outline sr-outline-2" x="28" y="20" width="44" height="10" rx="2.5" stroke="#333" stroke-width="3"/>
    <line  class="sr-scan"    x1="28" y1="43" x2="72" y2="43" stroke="#BB8AA3" stroke-width="2" stroke-linecap="round"/>
    <line  class="sr-scan sr-scan-2" x1="28" y1="52" x2="72" y2="52" stroke="#BB8AA3" stroke-width="2" stroke-linecap="round"/>
    <line  class="sr-scan sr-scan-3" x1="28" y1="61" x2="72" y2="61" stroke="#BB8AA3" stroke-width="2" stroke-linecap="round"/>
    <circle class="sr-outline sr-outline-3" cx="79" cy="37" r="6" stroke="#333" stroke-width="3"/>
    <line   class="sr-outline sr-outline-3" x1="83.2" y1="41.2" x2="88" y2="46" stroke="#333" stroke-width="3" stroke-linecap="round"/>
  </svg>
  <?php endif; ?>

  <h2 class="sinres-title"><?= htmlspecialchars($titulo) ?></h2>
  <p class="sinres-sub"><?= htmlspecialchars($subtitulo) ?></p>

  <?php if (!$es_busqueda): ?>
  <div class="sinres-dots"><span></span><span></span><span></span></div>
  <?php endif; ?>

  <form class="sinres-search" action="/tienda/busqueda" method="post">
    <input type="text" name="search" placeholder="Busca por referencia, colección o estilo…" autocomplete="off"/>
    <button type="submit" aria-label="Buscar"><i class="fa fa-search"></i></button>
  </form>

  <p class="sinres-cats-label">Explorar categorías</p>
  <div class="sinres-cats">
    <a href="/tienda/papel_pintado">Papel Pintado</a>
    <a href="/tienda/murales">Murales</a>
    <a href="/tienda/revestimientos">Revestimientos</a>
    <a href="/tienda/telas">Telas</a>
    <a href="/tienda/alfombras">Alfombras</a>
    <a href="/tienda/marcas">Marcas</a>
  </div>

</div>
