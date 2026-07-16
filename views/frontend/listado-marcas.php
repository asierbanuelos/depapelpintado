<?php
// Separar marcas con logo y sin logo
$con_logo = [];
$sin_logo = [];

foreach ($fab as $l) {
  $path_pos = $_SERVER['DOCUMENT_ROOT'].'/includes/images/logos/'.$l->cat_id.'.jpg';
  $path_neg = $_SERVER['DOCUMENT_ROOT'].'/includes/images/logos/'.$l->cat_id.'_negativo.jpg';
  if (file_exists($path_pos) || file_exists($path_neg)) {
    $con_logo[] = $l;
  } else {
    $sin_logo[] = $l;
  }
}

// Todas las marcas en orden alfabético (sin logo primero, luego con logo)
$todas = array_merge($sin_logo, $con_logo);
usort($todas, function($a, $b) { return strcasecmp($a->cat_name, $b->cat_name); });

// Agrupar por inicial
$por_letra = [];
foreach ($todas as $l) {
  $inicial = strtoupper(mb_substr($l->cat_name, 0, 1));
  $por_letra[$inicial][] = $l;
}
ksort($por_letra);
?>

<style>
.marcas-wrapper { padding: 40px 0 60px; }
.marcas-wrapper .columna-filtros ul li a { font-size: 17px; }
.marcas-section-title {
  font-family: 'Poppins', sans-serif;
  font-size: 10px;
  font-weight: 700;
  letter-spacing: 3px;
  text-transform: uppercase;
  color: #999;
  border-bottom: 1px solid #e8e4df;
  padding-bottom: 10px;
  margin-bottom: 28px;
  margin-top: 0;
}

/* ---- Índice de letras ---- */
.marcas-abc-index {
  display: flex;
  flex-wrap: wrap;
  gap: 5px;
  margin-bottom: 28px;
}
.marcas-abc-index a {
  font-family: 'Poppins', sans-serif;
  font-size: 17px;
  font-weight: 600;
  color: #444;
  text-decoration: none;
  border: 1px solid #ddd;
  padding: 3px 8px;
  transition: all 0.2s;
}
.marcas-abc-index a:hover { background: #333; color: #fff; border-color: #333; }

/* ---- Grupos por letra ---- */
.marcas-letra-grupo { margin-bottom: 24px; }
.marcas-letra-head {
  font-family: 'MoonCreme', Georgia, serif;
  font-size: 20px;
  color: #BB8AA3;
  border-bottom: 1px solid #f0eae6;
  padding-bottom: 3px;
  margin-bottom: 8px;
}
.marcas-lista-letra {
  display: flex;
  flex-wrap: wrap;
  list-style: none;
  padding: 0;
  margin: 0;
}
.marcas-lista-letra li { width: 25%; padding: 3px 6px 3px 0; }
@media (max-width: 991px) { .marcas-lista-letra li { width: 33.33%; } }
@media (max-width: 575px) { .marcas-lista-letra li { width: 50%; } }
.marcas-lista-letra a {
  font-family: 'Poppins', sans-serif;
  font-size: 17px;
  color: #444;
  text-decoration: none;
}
.marcas-lista-letra a:hover { color: #BB8AA3; }

/* ---- Grid logos ---- */
.marcas-logos-grid {
  display: flex;
  flex-wrap: wrap;
}
.marca-logo-item {
  width: 16.666%;
  padding: 14px 10px;
  display: flex;
  align-items: center;
  justify-content: center;
  border: 1px solid #f0eae6;
  margin: -1px 0 0 -1px;
  transition: background 0.2s;
}
.marca-logo-item:hover { background: #faf8f6; }
.marca-logo-item a { display: flex; align-items: center; justify-content: center; }
.marca-logo-item img {
  max-width: 100%;
  max-height: 55px;
  object-fit: contain;
  filter: grayscale(100%);
  opacity: 0.65;
  transition: filter 0.3s, opacity 0.3s;
}
.marca-logo-item:hover img { filter: grayscale(0%); opacity: 1; }
@media (max-width: 991px) { .marca-logo-item { width: 25%; } }
@media (max-width: 575px) { .marca-logo-item { width: 33.33%; } }

/* ---- Buscador de marca ---- */
.marcas-buscador { position: relative; max-width: 420px; }
.marcas-buscador input {
  width: 100%; font-family: 'Poppins', sans-serif; font-size: 16px;
  padding: 11px 16px; border: 1px solid #ddd4ce; border-radius: 3px;
  outline: none; color: #444; transition: border-color 0.2s, box-shadow 0.2s;
}
.marcas-buscador input:focus { border-color: #BB8AA3; box-shadow: 0 0 0 3px rgba(187,138,163,0.18); }
.marcas-buscador-count { display: block; margin-top: 6px; font-size: 13px; color: #999; font-family: 'Poppins', sans-serif; }
.marcas-sin-resultados { display: none; color: #999; font-family: 'Poppins', sans-serif; padding: 20px 0; }
.marcas-sin-resultados.show { display: block; }
</style>

<div class="wrapper marcas-wrapper">
  <h1 class="titulo-1-grande pt-2 pb-4 text-center"><?php echo $texto_h1_seccion; ?></h1>
  <div class="container">
    <?php $this->load->view('frontend/migas_nuevas_small', $this->data); ?>

    <div class="row">
      <!-- Contenido a ancho completo (sin filtro por tipo; buscador de marca en vivo) -->
      <div class="col-12">

        <!-- Buscador de marca -->
        <div class="marcas-buscador mb-4">
          <input type="search" id="buscar-marca" autocomplete="off" placeholder="Busca tu marca&hellip;" aria-label="Buscar marca">
          <span class="marcas-buscador-count" id="buscar-marca-count"></span>
        </div>
        <p class="marcas-sin-resultados" id="marcas-sin-resultados">No hemos encontrado ninguna marca con ese nombre.</p>

        <!-- GRUPO 1: TODAS las marcas en orden alfabético -->
        <p class="marcas-section-title">Marcas destacadas</p>

        <div class="marcas-abc-index">
          <?php foreach (array_keys($por_letra) as $letra): ?>
            <a href="#marca-letra-<?= htmlspecialchars($letra) ?>"><?= htmlspecialchars($letra) ?></a>
          <?php endforeach; ?>
        </div>

        <?php foreach ($por_letra as $letra => $marcas_letra): ?>
          <div class="marcas-letra-grupo" id="marca-letra-<?= htmlspecialchars($letra) ?>" data-grupo-letra>
            <div class="marcas-letra-head"><?= htmlspecialchars($letra) ?></div>
            <ul class="marcas-lista-letra">
              <?php foreach ($marcas_letra as $l): ?>
                <li class="marca-item" data-nombre="<?= htmlspecialchars(mb_strtolower($l->cat_name)) ?>"><a href="<?= '/marcas/'.urlenc($l->cat_name) ?>"><?= htmlspecialchars($l->cat_name) ?></a></li>
              <?php endforeach; ?>
            </ul>
          </div>
        <?php endforeach; ?>

        <?php if (!empty($con_logo)): ?>
        <!-- GRUPO 2: marcas CON logo -->
        <p class="marcas-section-title mt-5">Todas las marcas</p>
        <div class="marcas-logos-grid">
          <?php foreach ($con_logo as $l):
            $path_neg = $_SERVER['DOCUMENT_ROOT'].'/includes/images/logos/'.$l->cat_id.'_negativo.jpg';
            $src = file_exists($path_neg)
              ? $includes_dir.'images/logos/'.$l->cat_id.'_negativo.jpg'
              : $includes_dir.'images/logos/'.$l->cat_id.'.jpg';
          ?>
            <div class="marca-logo-item" data-nombre="<?= htmlspecialchars(mb_strtolower($l->cat_name)) ?>">
              <a href="<?= '/marcas/'.urlenc($l->cat_name) ?>" title="<?= htmlspecialchars($l->cat_name) ?>">
                <img src="<?= $src ?>" alt="<?= htmlspecialchars($l->cat_name) ?>" loading="lazy">
              </a>
            </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>

      </div>
    </div>
  </div>
</div>

<script>
(function(){
  var input = document.getElementById('buscar-marca');
  if (!input) return;
  var norm = function(s){ return (s||'').toLowerCase().normalize('NFD').replace(/[̀-ͯ]/g,''); };
  var items  = [].slice.call(document.querySelectorAll('.marca-item'));
  var logos  = [].slice.call(document.querySelectorAll('.marca-logo-item'));
  var grupos = [].slice.call(document.querySelectorAll('[data-grupo-letra]'));
  var abc       = document.querySelector('.marcas-abc-index');
  var logosGrid = document.querySelector('.marcas-logos-grid');
  var logosTit  = logosGrid ? logosGrid.previousElementSibling : null;
  var countEl = document.getElementById('buscar-marca-count');
  var noRes   = document.getElementById('marcas-sin-resultados');
  function filtrar(){
    var t = norm(input.value.trim());
    var vis = 0, logosVis = 0;
    items.forEach(function(li){
      var m = !t || norm(li.getAttribute('data-nombre')).indexOf(t) >= 0;
      li.style.display = m ? '' : 'none'; if (m) vis++;
    });
    logos.forEach(function(d){
      var m = !t || norm(d.getAttribute('data-nombre')).indexOf(t) >= 0;
      d.style.display = m ? '' : 'none'; if (m) logosVis++;
    });
    grupos.forEach(function(g){
      var lis = [].slice.call(g.querySelectorAll('.marca-item'));
      var any = lis.some(function(li){ return li.style.display !== 'none'; });
      g.style.display = any ? '' : 'none';
    });
    if (abc)       abc.style.display       = t ? 'none' : '';
    if (logosGrid) logosGrid.style.display = logosVis ? '' : 'none';
    if (logosTit)  logosTit.style.display  = logosVis ? '' : 'none';
    if (countEl)   countEl.textContent = t ? (vis + ' marca' + (vis === 1 ? '' : 's')) : '';
    if (noRes)     noRes.className = 'marcas-sin-resultados' + ((t && vis === 0) ? ' show' : '');
  }
  input.addEventListener('input', filtrar);
})();
</script>
