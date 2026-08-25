<?php
// Separar marcas con logo y sin logo
$con_logo = [];
$sin_logo = [];

foreach ($fab as $l) {
  $path_pos = $_SERVER['DOCUMENT_ROOT'].'/includes/images/logos/'.$l->cat_id.'.jpg';
  $path_neg = $_SERVER['DOCUMENT_ROOT'].'/includes/images/logos/'.$l->cat_id.'_negativo.jpg';
  if (file_exists($path_pos) || file_exists($path_neg)) {
    $l->logo_src = file_exists($path_neg)
      ? $includes_dir.'images/logos/'.$l->cat_id.'_negativo.jpg'
      : $includes_dir.'images/logos/'.$l->cat_id.'.jpg';
    $con_logo[] = $l;
  } else {
    $l->logo_src = '';
    $sin_logo[] = $l;
  }
}

// Todas las marcas en orden alfabético
$todas = array_merge($sin_logo, $con_logo);
usort($todas, function($a, $b) { return strcasecmp($a->cat_name, $b->cat_name); });

// Agrupar por inicial
$por_letra = [];
foreach ($todas as $l) {
  $inicial = strtoupper(mb_substr($l->cat_name, 0, 1));
  if (!preg_match('/[A-ZÑ]/u', $inicial)) $inicial = '#';
  $por_letra[$inicial][] = $l;
}
ksort($por_letra);

// SEO: nº total de marcas (redondeado, mismo criterio que la home) y selección editorial de marcas de lujo.
$total_marcas_redondeo_local = (int)(floor(count($todas) / 10) * 10);
$indice_marcas_nombre = [];
foreach ($todas as $l) { $indice_marcas_nombre[mb_strtoupper(trim($l->cat_name), 'UTF-8')] = $l; }
$nombres_marcas_lujo = ['Cole & Son','Sanderson','Designers Guild','Missoni Home','Casamance','Christian Lacroix','Elitis','Harlequin','Nobilis','Osborne & Little'];
$marcas_lujo = [];
foreach ($nombres_marcas_lujo as $nombre_lujo) {
  $clave_lujo = mb_strtoupper($nombre_lujo, 'UTF-8');
  if (isset($indice_marcas_nombre[$clave_lujo])) $marcas_lujo[] = $indice_marcas_nombre[$clave_lujo];
}
?>

<style>
/* ================= Listado de Marcas ================= */
.marcas-wrapper {
  --mk-ink: #2e2a2c;
  --mk-muted: #8a8288;
  --mk-line: #ece6e2;
  --mk-line-strong: #ddd4ce;
  --mk-accent: #bb8aa3;
  --mk-accent-deep: #9c637f;
  --mk-tile: #f6f1ee;
  --mk-tile-alt: #f1ebe9;
  padding: 0 0 70px;
}

/* ---- Hero ---- */
.marcas-hero { padding: 10px 0 26px; border-bottom: 1px solid var(--mk-line); margin-bottom: 0; }
.marcas-eyebrow {
  font-family: 'Poppins', sans-serif; font-size: 11px; letter-spacing: 3px;
  text-transform: uppercase; color: var(--mk-accent-deep); font-weight: 600; margin: 0 0 12px;
}
.marcas-wrapper h1.marcas-title {
  font-family: 'MoonCreme', Georgia, serif; font-weight: 400;
  font-size: 52px; line-height: 1; margin: 0; color: var(--mk-ink);
}
.marcas-lede {
  font-family: 'Poppins', sans-serif; font-size: 16px; color: var(--mk-muted);
  max-width: 60ch; margin: 16px 0 0;
}
@media (max-width: 575px) {
  .marcas-wrapper h1.marcas-title { font-size: 34px; }
  .marcas-lede { font-size: 15px; }
}

/* ---- Buscador + índice ---- */
.marcas-tools { padding: 20px 0 4px; border-bottom: 1px solid var(--mk-line); margin-bottom: 28px; }
.marcas-tools-row { display: flex; gap: 16px; align-items: center; flex-wrap: wrap; }
.marcas-buscador { position: relative; flex: 1 1 320px; min-width: 240px; }
.marcas-buscador input {
  width: 100%; font-family: 'Poppins', sans-serif; font-size: 16px; color: var(--mk-ink);
  background: #fff; border: 1px solid var(--mk-line-strong); border-radius: 2px;
  padding: 12px 16px; outline: none; transition: border-color 0.18s, box-shadow 0.18s;
}
.marcas-buscador input::placeholder { color: var(--mk-muted); }
.marcas-buscador input:focus {
  border-color: var(--mk-accent); box-shadow: 0 0 0 3px rgba(187,138,163,0.22);
}
.marcas-count {
  font-family: 'Poppins', sans-serif; font-size: 13px; color: var(--mk-muted); white-space: nowrap;
}
.marcas-count b { color: var(--mk-ink); font-weight: 600; }

.marcas-abc-index { display: flex; flex-wrap: wrap; gap: 4px; margin-top: 14px; }
.marcas-abc-index button {
  font-family: 'Poppins', sans-serif; font-size: 12.5px; font-weight: 600; color: var(--mk-muted);
  background: transparent; border: 1px solid var(--mk-line); border-radius: 2px;
  padding: 4px 9px; cursor: pointer; transition: all 0.15s;
}
.marcas-abc-index button:hover:not(:disabled) { border-color: var(--mk-accent); color: var(--mk-accent-deep); }
.marcas-abc-index button:disabled { opacity: 0.3; cursor: default; }
.marcas-abc-index button:focus-visible { outline: 2px solid var(--mk-accent); outline-offset: 2px; }

/* ---- Grupos por letra ---- */
.marcas-letra-head {
  font-family: 'MoonCreme', Georgia, serif; font-size: 24px; color: var(--mk-accent-deep);
  border-bottom: 1px solid var(--mk-line); padding-bottom: 8px; margin: 36px 0 16px;
  scroll-margin-top: 20px;
}
.marcas-letra-grupo:first-of-type .marcas-letra-head { margin-top: 6px; }

/* ---- Rejilla de marcas ---- */
.marcas-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 14px; }
@media (max-width: 575px) { .marcas-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; } }

.marca-card {
  display: flex; flex-direction: column; text-decoration: none; color: inherit;
  background: #fff; border: 1px solid var(--mk-line); border-radius: 2px; overflow: hidden;
  transition: transform 0.2s, box-shadow 0.2s, border-color 0.2s;
}
.marca-card:hover {
  transform: translateY(-3px); border-color: var(--mk-line-strong);
  box-shadow: 0 1px 2px rgba(46,42,44,0.04), 0 10px 30px -18px rgba(46,42,44,0.28);
  text-decoration: none;
}
.marca-card:focus-visible { outline: 2px solid var(--mk-accent); outline-offset: 2px; }

.marca-card-logo {
  height: 104px; display: flex; align-items: center; justify-content: center;
  padding: 18px; background: var(--mk-tile); border-bottom: 1px solid var(--mk-line);
}
.marca-card:nth-child(even) .marca-card-logo { background: var(--mk-tile-alt); }
.marca-card-logo img {
  max-width: 100%; max-height: 60px; object-fit: contain;
  filter: grayscale(100%); opacity: 0.68; transition: filter 0.3s, opacity 0.3s;
}
.marca-card:hover .marca-card-logo img { filter: grayscale(0%); opacity: 1; }
.marca-card-wordmark {
  font-family: 'MoonCreme', Georgia, serif; font-size: 21px; text-align: center;
  color: var(--mk-ink); opacity: 0.75; line-height: 1.1; transition: color 0.3s, opacity 0.3s;
}
.marca-card:hover .marca-card-wordmark { color: var(--mk-accent-deep); opacity: 1; }

.marca-card-meta {
  padding: 12px 14px 14px; display: flex; align-items: baseline;
  justify-content: space-between; gap: 8px;
}
.marca-card-name {
  font-family: 'Poppins', sans-serif; font-size: 13.5px; font-weight: 600; color: var(--mk-ink);
}
.marca-card-count { font-family: 'Poppins', sans-serif; font-size: 11px; color: var(--mk-muted); white-space: nowrap; }

/* ---- Sin resultados ---- */
.marcas-sin-resultados { display: none; text-align: center; padding: 60px 20px; }
.marcas-sin-resultados.show { display: block; }
.marcas-sin-resultados span {
  font-family: 'MoonCreme', Georgia, serif; font-size: 24px; color: var(--mk-ink);
  display: block; margin-bottom: 8px;
}
.marcas-sin-resultados p { font-family: 'Poppins', sans-serif; color: var(--mk-muted); margin: 0; }

/* ---- Intro SEO ---- */
.marcas-intro { max-width: 78ch; margin: 18px 0 0; }
.marcas-intro p {
  font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 1.7; color: var(--mk-muted); margin: 0 0 12px;
}

/* ---- Marcas de lujo (editorial) ---- */
.marcas-lujo { padding: 34px 0 38px; border-bottom: 1px solid var(--mk-line); margin-bottom: 8px; }
.marcas-lujo-titulo {
  font-family: 'MoonCreme', Georgia, serif; font-size: 26px; font-weight: 400; color: var(--mk-ink); margin: 0 0 6px;
}
.marcas-lujo-sub {
  font-family: 'Poppins', sans-serif; font-size: 14px; color: var(--mk-muted); max-width: 68ch; margin: 0 0 20px;
}
.marcas-lujo-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(190px, 1fr)); gap: 14px; }
@media (max-width: 575px) { .marcas-lujo-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; } }
.marca-lujo-card { position: relative; }
.marca-lujo-badge {
  position: absolute; top: 8px; right: 8px; z-index: 2;
  font-family: 'Poppins', sans-serif; font-size: 9px; font-weight: 700; letter-spacing: 0.6px; text-transform: uppercase;
  color: #fff; background: var(--mk-accent-deep); padding: 3px 7px; border-radius: 2px;
}

/* ---- Cierre SEO + FAQ ---- */
.marcas-cierre { padding: 46px 0 8px; max-width: 78ch; }
.marcas-cierre h2 {
  font-family: 'MoonCreme', Georgia, serif; font-size: 24px; font-weight: 400; color: var(--mk-ink); margin: 0 0 14px;
}
.marcas-cierre p {
  font-family: 'Poppins', sans-serif; font-size: 15px; line-height: 1.7; color: var(--mk-muted); margin: 0 0 14px;
}
.marcas-faq { padding: 10px 0 50px; max-width: 78ch; }
.marcas-faq h2 {
  font-family: 'MoonCreme', Georgia, serif; font-size: 24px; font-weight: 400; color: var(--mk-ink); margin: 0 0 18px;
}
.marcas-faq-item { border-top: 1px solid var(--mk-line); padding: 18px 0; }
.marcas-faq-item h3 {
  font-family: 'Poppins', sans-serif; font-size: 15.5px; font-weight: 600; color: var(--mk-ink); margin: 0 0 8px;
}
.marcas-faq-item p {
  font-family: 'Poppins', sans-serif; font-size: 14.5px; line-height: 1.65; color: var(--mk-muted); margin: 0;
}
</style>

<div class="categ-breadcrumb-bar">
  <div class="container">
    <?php $this->load->view('frontend/migas_nuevas_small', $this->data); ?>
  </div>
</div>
<div class="wrapper marcas-wrapper">
  <div class="container">

    <!-- Hero -->
    <header class="marcas-hero">
      <p class="marcas-eyebrow">De Papel Pintado</p>
      <h1 class="marcas-title"><?php echo $texto_h1_seccion; ?></h1>
      <p class="marcas-lede">Explora nuestras +<?= $total_marcas_redondeo_local ?> marcas de papel pintado, murales, telas y revestimientos: desde firmas de lujo con reconocimiento internacional hasta propuestas más actuales. Busca por nombre o navega con el índice alfabético.</p>
      <div class="marcas-intro">
        <p>En De Papel Pintado trabajamos directamente con los fabricantes originales, sin intermediarios que recorten catálogo ni calidad: cada marca de papel pintado que ves aquí mantiene sus colecciones completas y sus acabados tal y como salen de fábrica.</p>
        <p>Si ya sabes qué marca buscas, usa el buscador o el índice alfabético de más abajo. Si todavía estás decidiendo, en la siguiente sección destacamos las marcas de papel pintado de lujo con más recorrido en diseño de interiores — un buen punto de partida para un proyecto con personalidad.</p>
      </div>
    </header>

    <?php if (!empty($marcas_lujo)): ?>
    <!-- Marcas de lujo (editorial) -->
    <section class="marcas-lujo">
      <h2 class="marcas-lujo-titulo">Marcas de papel pintado de lujo</h2>
      <p class="marcas-lujo-sub">Firmas de referencia en diseño de interiores, con colecciones que llevan décadas marcando tendencia en papel pintado de alta gama.</p>
      <div class="marcas-lujo-grid">
        <?php foreach ($marcas_lujo as $l): ?>
          <a class="marca-card marca-lujo-card" href="<?= '/marcas/'.urlenc($l->cat_name) ?>" title="<?= htmlspecialchars($l->cat_name) ?>">
            <span class="marca-lujo-badge">Lujo</span>
            <div class="marca-card-logo">
              <?php if ($l->logo_src != ''): ?>
                <img src="<?= $l->logo_src ?>" alt="<?= htmlspecialchars($l->cat_name) ?>" loading="lazy">
              <?php else: ?>
                <span class="marca-card-wordmark"><?= htmlspecialchars($l->cat_name) ?></span>
              <?php endif; ?>
            </div>
            <div class="marca-card-meta">
              <span class="marca-card-name"><?= htmlspecialchars($l->cat_name) ?></span>
              <?php if (isset($l->n_productos) && (int)$l->n_productos > 0): ?>
                <span class="marca-card-count"><?= number_format((int)$l->n_productos, 0, ',', '.') ?></span>
              <?php endif; ?>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </section>
    <?php endif; ?>

    <!-- Índice A-Z -->
    <div class="marcas-tools">
      <nav class="marcas-abc-index" id="marcas-abc" aria-label="Índice alfabético"></nav>
    </div>

    <!-- Marcas -->
    <?php foreach ($por_letra as $letra => $marcas_letra): ?>
      <div class="marcas-letra-grupo" data-grupo-letra>
        <div class="marcas-letra-head" id="marca-letra-<?= htmlspecialchars($letra) ?>"><?= htmlspecialchars($letra === '#' ? '0-9' : $letra) ?></div>
        <div class="marcas-grid">
          <?php foreach ($marcas_letra as $l): ?>
            <a class="marca-card" data-nombre="<?= htmlspecialchars(mb_strtolower($l->cat_name)) ?>" href="<?= '/marcas/'.urlenc($l->cat_name) ?>" title="<?= htmlspecialchars($l->cat_name) ?>">
              <div class="marca-card-logo">
                <?php if ($l->logo_src != ''): ?>
                  <img src="<?= $l->logo_src ?>" alt="<?= htmlspecialchars($l->cat_name) ?>" loading="lazy">
                <?php else: ?>
                  <span class="marca-card-wordmark"><?= htmlspecialchars($l->cat_name) ?></span>
                <?php endif; ?>
              </div>
              <div class="marca-card-meta">
                <span class="marca-card-name"><?= htmlspecialchars($l->cat_name) ?></span>
                <?php if (isset($l->n_productos) && (int)$l->n_productos > 0): ?>
                  <span class="marca-card-count"><?= number_format((int)$l->n_productos, 0, ',', '.') ?></span>
                <?php endif; ?>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endforeach; ?>

    <!-- Cierre SEO -->
    <section class="marcas-cierre">
      <h2>¿Por qué comprar tu papel pintado por marca?</h2>
      <p>Elegir por marca de papel pintado, y no solo por diseño, es la forma más fiable de acertar con la calidad del material: cada fabricante trabaja con un soporte propio (vinilo, no tejido o tejido natural) y un proceso de impresión distinto, lo que determina la durabilidad, el comportamiento ante la humedad y la facilidad de colocación del papel.</p>
      <p>Ya sea una marca de papel pintado de lujo con ediciones limitadas o una firma especializada en papel lavable para zonas de alto tránsito, en De Papel Pintado encuentras el catálogo completo y actualizado de cada fabricante.</p>
    </section>

    <!-- FAQ -->
    <section class="marcas-faq" itemscope itemtype="https://schema.org/FAQPage">
      <h2>Preguntas frecuentes sobre marcas de papel pintado</h2>
      <div class="marcas-faq-item" itemprop="mainEntity" itemscope itemtype="https://schema.org/Question">
        <h3 itemprop="name">¿Cuántas marcas de papel pintado hay disponibles?</h3>
        <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer">
          <p itemprop="text">Actualmente trabajamos con más de <?= $total_marcas_redondeo_local ?> marcas de papel pintado, murales, telas y revestimientos, entre fabricantes españoles y firmas internacionales de referencia.</p>
        </div>
      </div>
      <div class="marcas-faq-item" itemprop="mainEntity" itemscope itemtype="https://schema.org/Question">
        <h3 itemprop="name">¿Cuáles son las mejores marcas de papel pintado de lujo?</h3>
        <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer">
          <p itemprop="text">Entre las marcas de papel pintado de lujo más reconocidas están Cole &amp; Son, Sanderson, Designers Guild, Missoni Home, Casamance y Christian Lacroix, todas ellas con colecciones originales disponibles en nuestro catálogo.</p>
        </div>
      </div>
      <div class="marcas-faq-item" itemprop="mainEntity" itemscope itemtype="https://schema.org/Question">
        <h3 itemprop="name">¿Cómo elijo la marca de papel pintado adecuada para mi proyecto?</h3>
        <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer">
          <p itemprop="text">Depende del acabado que busques y del estilo: las firmas de lujo suelen ofrecer diseños más atrevidos y ediciones limitadas, mientras que otras marcas se especializan en papel pintado lavable o resistente para zonas de alto tránsito como pasillos o cocinas.</p>
        </div>
      </div>
    </section>

  </div>
</div>

<script>
(function(){
  var abcEl = document.getElementById('marcas-abc');
  if (!abcEl) return;
  var grupos = [].slice.call(document.querySelectorAll('[data-grupo-letra]'));
  var letrasConMarcas = {};
  grupos.forEach(function(g){
    var head = g.querySelector('.marcas-letra-head');
    if (head) letrasConMarcas[head.textContent.trim()] = head.id;
  });
  'ABCDEFGHIJKLMNOPQRSTUVWXYZ'.split('').concat(['0-9']).forEach(function(L){
    var b = document.createElement('button');
    b.type = 'button';
    b.textContent = L;
    var id = letrasConMarcas[L];
    b.disabled = !id;
    if (id) b.addEventListener('click', function(){
      var el = document.getElementById(id);
      if (el) el.scrollIntoView({behavior:'smooth', block:'start'});
    });
    abcEl.appendChild(b);
  });
})();
</script>
