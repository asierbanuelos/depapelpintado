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

?>
<!-- CSS en header.php -->

<!-- Bloque blanco: breadcrumb -->
<div class="categ-breadcrumb-bar">
  <div class="container">
    <?php $this->load->view('frontend/migas_nuevas_small', $this->data); ?>
  </div>
</div>

<div class="categ-header">
  <div class="container">
    <h1 class="categ-h1"><?php echo strip_tags($texto_h1); ?></h1>
  </div>
</div>

<!-- Bloque blanco: filtros + catálogo -->
<div class="categ-wrapper">
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

        <?php
        if (count($all) != 0):
          if (!isset($productos_outlet)) $productos_outlet = 0;
        ?>
        <div class="row listado-productos mt-0">
          <input type="hidden" id="llamada_request_next"
            data-funcion="get_next_categoria_seo_filtros"
            data-id_categoria_seo="<?php echo $categoria_seo->nueva_categoria_id; ?>"
            data-tipo_producto="<?php echo $categ; ?>"
            data-outlet="<?php echo $productos_outlet; ?>"
            data-orden="<?php echo $orden_seleccionado; ?>"
            data-estilo="<?php echo isset($_REQUEST['estilo']) ? $_REQUEST['estilo'] : ''; ?>"
            data-color="<?php echo isset($_REQUEST['color']) ? $_REQUEST['color'] : ''; ?>"
            data-marca="<?php echo isset($_REQUEST['marca']) ? $_REQUEST['marca'] : ''; ?>"
            data-calidad="<?php echo isset($_REQUEST['calidad']) ? $_REQUEST['calidad'] : ''; ?>"
            data-limpieza="<?php echo isset($_REQUEST['limpieza']) ? $_REQUEST['limpieza'] : ''; ?>"
          />
          <?php
          $this->data['filtro_lateral'] = true;
          $this->load->view('frontend/articulo_cards', $this->data);
          ?>
        </div>
        <?php
        // Paginación
        $total = isset($total_productos) ? $total_productos : 0;
        $por_pagina = isset($registros_por_pagina) ? $registros_por_pagina : 42;
        $pagina = isset($pagina_actual) ? $pagina_actual : 0;
        $num_paginas = $total > 0 ? ceil($total / $por_pagina) : 1;
        if ($num_paginas > 1):
          // Construir base URL sin el param page
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
  <div class="categ-desc expanded"><?php echo $texto_descripcion; ?></div>
</div>
<?php endif; ?>

<?php if (!empty($faqs)): ?>
<div class="units-row faq-section" style="background:#f9f9f9;padding:40px 0;">
  <div class="unit-centered unit-80">
    <h2 style="font-size:26px;font-weight:400;color:#333;text-align:center;margin-bottom:28px;">Preguntas frecuentes</h2>
    <div class="faq-list" itemscope itemtype="https://schema.org/FAQPage">
      <?php foreach ($faqs as $faq): ?>
      <div class="faq-item" itemprop="mainEntity" itemscope itemtype="https://schema.org/Question" style="border-bottom:1px solid #e0e0e0;">
        <button class="faq-question" onclick="this.classList.toggle('open');var a=this.nextElementSibling;a.style.display=(a.style.display==='block')?'none':'block';" itemprop="name" style="width:100%;text-align:left;background:none;border:none;padding:16px 40px 16px 0;font-size:16px;font-weight:600;color:#333;cursor:pointer;position:relative;line-height:1.4;">
          <?= htmlspecialchars($faq->pregunta) ?>
          <span style="position:absolute;right:0;top:50%;transform:translateY(-50%);font-size:22px;color:#B05380;line-height:1;">+</span>
        </button>
        <div itemprop="acceptedAnswer" itemscope itemtype="https://schema.org/Answer" style="display:none;padding:0 0 16px 0;color:#555;font-size:15px;line-height:1.7;">
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

<?php // newsletter_banner_footer se carga en footer.php ?>

<?php
$this->data['img_modal'] = '';
$this->load->view('frontend/articulo_modal_carrito', $this->data);
?>

<script>
  function irAFiltro(seccionId) {
    var w = document.querySelector('.categ-wrapper');
    if (w && w.classList.contains('filtros-ocultos')) {
      w.classList.remove('filtros-ocultos');
    }
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

    // Limitar a 3 items visibles (excepto Tonalidades que muestra todas)
    var nombre = (header.querySelector('span') || header).textContent.trim().toLowerCase();
    var esTonalidades = nombre.indexOf('tonalidad') !== -1;
    if (!esTonalidades) {
      var uls = body.querySelectorAll('ul');
      var mainUl = uls[uls.length - 1];
      if (mainUl) {
        var items = mainUl.querySelectorAll('li');
        var maxVisible = 3;
        if (items.length > maxVisible) {
          mainUl.style.maxHeight = '220px';
          mainUl.style.overflowY = 'auto';
          mainUl.style.paddingRight = '6px';
          var verTodosBtn = document.createElement('div');
          verTodosBtn.className = 'filtro-ver-todos';
          verTodosBtn.innerHTML = '<a href="#">Ver todas las ' + nombre + ' ›</a>';
          body.appendChild(verTodosBtn);
          verTodosBtn.style.display = 'none';
          verTodosBtn.querySelector('a').addEventListener('click', function(e) {
            e.preventDefault();
            for (var i = maxVisible; i < items.length; i++) items[i].style.display = '';
            mainUl.style.maxHeight = 'none';
            verTodosBtn.style.display = 'none';
            setTimeout(function() { body.style.maxHeight = body.scrollHeight + 'px'; }, 0);
          });
        }
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
