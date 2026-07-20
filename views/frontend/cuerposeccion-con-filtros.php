<?php

$texto_h1='';
$texto_descripcion='';

if (isset($texto_h1_seccion)){
  $texto_h1=$texto_h1_seccion;
}
if (isset($texto__intro_seo)){
  $texto_descripcion=$texto__intro_seo;
}
if (isset($datos_coleccion)){
  $texto_h1='Colección '.$datos_coleccion->coleccion_name.' de '.$familia_producto.' '.$datos_coleccion->cat_name;
  if ($datos_coleccion->col_text_publico)
    $texto_descripcion=$datos_coleccion->col_text;
}
elseif (isset($datos_estilo[0])){
  if(trim($datos_estilo[0]->h1_estilo)!='')
    $texto_h1=str_replace('XXXX', $familia_producto, $datos_estilo[0]->h1_estilo);
  if(trim($datos_estilo[0]->descripcion_estilo)!='' && $datos_estilo[0]->descripcion_estilo_publico)
    $texto_descripcion=str_replace('XXXX', $familia_producto, $datos_estilo[0]->descripcion_estilo);
}
elseif(isset($losmas) && $losmas==1){
  if ($familia_producto=='Papel Pintado')
    $texto_h1='Selección de los Papeles Pintados más vendidos';
  elseif ($familia_producto=='Telas' || $familia_producto=='Alfombras')
    $texto_h1='Selección de las '.$familia_producto.' más vendidas';
  else
    $texto_h1='Selección de los '.$familia_producto.' más vendidos';
}
if (isset($col_text_publico))
  $texto_descripcion=$col_text;

// Fase 1 SEO: la descripcion nunca debe traer otro <h1> (solo el categ-h1) ni encabezados vacios
if (trim($texto_descripcion) != '') {
  $texto_descripcion = preg_replace('/<(\/?)h1\b/i', '<$1h2', $texto_descripcion);
  $texto_descripcion = preg_replace('/<h([1-6])[^>]*>(?:\s|\x{00A0}|&nbsp;|&#160;|<br\s*\/?>)*<\/h\1>/iu', '', $texto_descripcion);
}

?>
<!-- CSS en header.php -->

<!-- Breadcrumb fuera del categ-wrapper (fondo blanco) -->
<div class="categ-breadcrumb-bar">
  <div class="container">
    <?php $this->load->view('frontend/migas_nuevas_small', $this->data); ?>
  </div>
</div>

<div class="categ-wrapper filtros-ocultos">
  <div class="container categ-header">
    <h1 class="categ-h1"><?php echo strip_tags($texto_h1); ?></h1>
    <?php if (!empty($catalogo_intro)): ?><p class="categ-intro"><?php echo $catalogo_intro; ?></p><?php endif; ?>
  </div>

  <div class="container">
    <div class="row">

      <!-- Sidebar filtros (desktop) -->
      <div class="col-xl-2 col-lg-3 col-md-3 d-none d-md-block categ-sidebar">
        <div class="columna-filtros sticky-sidebar">
          <?php $this->load->view('frontend/cuerposeccion-filtros', $this->data); ?>
        </div>
      </div>

      <!-- Grid productos -->
      <div class="col-xl-10 col-lg-9 col-md-9 col-12 categ-grid">

        <!-- Botón filtrar -->
        <div class="text-right mb-3 d-none d-md-block">
          <button class="categ-filtrar-btn" onclick="toggleSidebarFiltros()">
            Filtrar <i class="fa fa-sliders-h"></i>
          </button>
        </div>

        <!-- Filtros móvil off-canvas -->
        <?php $this->load->view('frontend/cuerposeccion-filtros-movil', $this->data); ?>

        <!-- Barra filtrar móvil -->
        <div class="d-md-none categ-barra-movil mb-3">
          <button type="button" class="categ-filtrar-btn-movil" data-toggle="canvas" data-target="#bs-canvas-right" aria-controls="bs-canvas-right" aria-expanded="false">
            <i class="fa fa-sliders-h"></i> Filtrar
          </button>
          <?php if (isset($total_productos) && $total_productos > 0): ?>
          <span class="categ-count-movil"><?= $total_productos ?> productos</span>
          <?php endif; ?>
        </div>

        <?php if (isset($enlace_marcas) && $enlace_marcas != ''): ?>
        <div class="d-md-none mb-3">
          <div class="container">
            <div class="row">
              <div class="col-6 text-center"><a href="/<?php echo $enlace_marcas; ?>">Marcas de <?php echo $familia_producto; ?></a></div>
              <div class="col-6 text-center"><a href="/<?php echo $enlace_estilos; ?>">Estilos de <?php echo $familia_producto; ?></a></div>
            </div>
          </div>
        </div>
        <?php endif; ?>

        <?php
        if (count($all) != 0):
          if (!isset($id_coleccion)) $id_coleccion = 0;
          if (!isset($productos_outlet)) $productos_outlet = 0;
          $param_marcas = '';
          if (isset($id_marca)) $param_marcas = $id_marca;
          if (isset($_REQUEST['marca'])) $param_marcas = $_REQUEST['marca'];
        ?>
        <div class="row listado-productos mt-0">
          <input type="hidden" id="llamada_request_next"
            data-funcion="get_next_listado_filtros"
            data-id_categoria_seo="0"
            data-tipo_producto="<?php echo $categ; ?>"
            data-outlet="<?php echo $productos_outlet; ?>"
            data-coleccion="<?php echo $id_coleccion; ?>"
            data-orden="<?php echo $orden_seleccionado; ?>"
            data-estilo="<?php echo isset($_REQUEST['estilo']) ? $_REQUEST['estilo'] : ''; ?>"
            data-color="<?php echo isset($_REQUEST['color']) ? $_REQUEST['color'] : ''; ?>"
            data-marca="<?php echo $param_marcas; ?>"
          />
          <?php
          $this->data['filtro_lateral'] = true;
          $this->load->view('frontend/articulo_cards', $this->data);
          ?>
        </div>
        <?php
        $total = isset($total_productos) ? $total_productos : 0;
        $por_pagina = isset($registros_por_pagina) ? $registros_por_pagina : 42;
        $pagina = isset($pagina_actual) ? $pagina_actual : 0;
        $num_paginas = $total > 0 ? ceil($total / $por_pagina) : 1;
        if ($num_paginas > 1):
          $query_params = $_GET;
          unset($query_params['page']);
          $base_query = count($query_params) ? '?' . http_build_query($query_params) . '&page=' : '?page=';
          $url_base = strtok($_SERVER['REQUEST_URI'], '?') . $base_query;
        ?>
        <div class="col-12 categ-paginacion">
          <?php if ($pagina > 0): ?>
            <a href="<?= $url_base . ($pagina - 1) ?>" class="categ-pag-btn">&lsaquo;</a>
          <?php endif; ?>
          <?php for ($p = 0; $p < $num_paginas; $p++):
            $rango_inicio = max(0, $pagina - 3);
            $rango_fin = min($num_paginas - 1, $pagina + 3);
            if ($p < $rango_inicio && $p != 0) { if ($p == 1) echo '<span class="categ-pag-ellipsis">…</span>'; continue; }
            if ($p > $rango_fin && $p != $num_paginas - 1) { if ($p == $rango_fin + 1) echo '<span class="categ-pag-ellipsis">…</span>'; continue; }
          ?>
            <a href="<?= $url_base . $p ?>" class="categ-pag-btn <?= $p == $pagina ? 'active' : '' ?>"><?= $p + 1 ?></a>
          <?php endfor; ?>
          <?php if ($pagina < $num_paginas - 1): ?>
            <a href="<?= $url_base . ($pagina + 1) ?>" class="categ-pag-btn">&rsaquo;</a>
          <?php endif; ?>
        </div>
        <?php endif; ?>
        <?php
        else:
          $this->load->view('frontend/sinresultados', $this->data);
        endif;
        ?>

      </div><!-- /col grid -->
    </div><!-- /row -->
  </div><!-- /container -->
</div><!-- /categ-wrapper -->

<?php if (trim($texto_descripcion) != ''): ?>
<div class="container" style="padding: 40px 15px 56px;">
  <div class="categ-desc-wrap">
    <div class="categ-desc-text" id="categ-desc-text"><?php echo $texto_descripcion; ?></div>
    <div class="categ-desc-fade" id="categ-desc-fade"></div>
    <button class="categ-desc-toggle" id="categ-desc-btn" onclick="toggleCategoriaDesc()">Ver más</button>
  </div>
</div>
<style>
.categ-desc-wrap { position: relative; }
.categ-desc-text {
  max-height: 80px;
  overflow: hidden;
  transition: max-height 0.4s ease;
}
.categ-desc-text.expanded { max-height: 2000px; }
.categ-desc-fade {
  position: absolute;
  bottom: 30px; left: 0; right: 0;
  height: 50px;
  background: linear-gradient(to bottom, transparent, #fff);
  pointer-events: none;
  transition: opacity 0.3s ease;
}
.categ-desc-text.expanded + .categ-desc-fade { opacity: 0; }
.categ-desc-toggle {
  background: none;
  border: none;
  color: #BB8AA3;
  font-size: 13px;
  font-weight: 600;
  cursor: pointer;
  padding: 6px 0 0;
  letter-spacing: 1px;
  text-transform: uppercase;
  display: block;
}
.categ-desc-toggle:hover { color: #a36185; }
</style>
<script>
function toggleCategoriaDesc() {
  var txt = document.getElementById('categ-desc-text');
  var btn = document.getElementById('categ-desc-btn');
  if (txt.classList.contains('expanded')) {
    txt.classList.remove('expanded');
    btn.textContent = 'Ver más';
  } else {
    txt.classList.add('expanded');
    btn.textContent = 'Ver menos';
  }
}
</script>
<?php endif; ?>

<?php $this->load->view('frontend/catalogo_interlinks', $this->data); ?>

<?php // newsletter_banner_footer se carga en footer.php ?>

<?php
$this->data['img_modal'] = '';
$this->load->view('frontend/articulo_modal_carrito', $this->data);
?>

<script>
  function irAFiltro(seccionId) {
    // Asegurarse de que el sidebar esté visible
    var w = document.querySelector('.categ-wrapper');
    if (w && w.classList.contains('filtros-ocultos')) {
      w.classList.remove('filtros-ocultos');
    }
    // Scroll a la sección con pequeño delay para que el sidebar aparezca primero
    setTimeout(function() {
      var el = document.getElementById(seccionId);
      if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }, 80);
  }

  function toggleSidebarFiltros() {
    var w = document.querySelector('.categ-wrapper');
    if (w) w.classList.toggle('filtros-ocultos');
  }

  function ajustarStickySidebar() {
    var header = document.querySelector('.site-header');
    var sidebar = document.querySelector('.sticky-sidebar');
    if (header && sidebar) {
      var h = header.getBoundingClientRect().height;
      sidebar.style.top = (h + 16) + 'px';
    }
  }
  ajustarStickySidebar();
  window.addEventListener('resize', ajustarStickySidebar);

  // Acordeón filtros sidebar
  document.querySelectorAll('.columna-filtros .grupo-filtro').forEach(function(header) {
    var siblings = [], next = header.nextElementSibling;
    while (next && !next.classList.contains('grupo-filtro')) {
      siblings.push(next);
      next = next.nextElementSibling;
    }
    if (!siblings.length) return;
    var body = document.createElement('div');
    body.className = 'filtro-acordeon-body';
    header.parentNode.insertBefore(body, siblings[0]);
    siblings.forEach(function(s) { body.appendChild(s); });

    // Mostrar todos los items, con scroll si hay muchos
    var uls = body.querySelectorAll('ul');
    var mainUl = uls[uls.length - 1];
    if (mainUl) {
      var items = mainUl.querySelectorAll('li');
      if (items.length > 8) {
        mainUl.style.maxHeight = '220px';
        mainUl.style.overflowY = 'auto';
        mainUl.style.paddingRight = '6px';
      }
    }

    body.style.maxHeight = '0';
    header.classList.add('filtro-cerrado');
    header.addEventListener('click', function() {
      var cerrado = header.classList.toggle('filtro-cerrado');
      body.style.maxHeight = cerrado ? '0' : body.scrollHeight + 'px';
    });
  });
</script>
