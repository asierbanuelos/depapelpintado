<!doctype html>
<html lang="es" class="no-js">
<head>
  <meta charset="utf-8">
  <title>Preguntas Frecuentes — Admin</title>
  <?php $this->load->view('includes/admin_head'); ?>
  <style>
    .faq-tabs { display:flex; gap:6px; margin-bottom:24px; border-bottom:2px solid #e0d6d2; padding-bottom:0; }
    .faq-tab { padding:10px 22px; border:none; background:none; cursor:pointer; font-size:14px; font-weight:600; color:#888; border-bottom:3px solid transparent; margin-bottom:-2px; transition:color .2s; }
    .faq-tab.active, .faq-tab:hover { color:#B05380; border-bottom-color:#B05380; }
    .faq-panel { display:none; }
    .faq-panel.active { display:block; }
    .faq-cat-group { margin-bottom:32px; }
    .faq-cat-title { font-size:13px; font-weight:700; text-transform:uppercase; letter-spacing:.08em; color:#B05380; margin-bottom:10px; padding:6px 10px; background:#fdf5f9; border-left:3px solid #B05380; border-radius:0 4px 4px 0; }
    .faq-table { width:100%; border-collapse:collapse; font-size:14px; }
    .faq-table th { padding:9px 12px; background:#f5f0ed; color:#555; font-weight:600; text-align:left; border-bottom:2px solid #e0d6d2; }
    .faq-table td { padding:11px 12px; border-bottom:1px solid #f0ece9; vertical-align:middle; }
    .faq-table tr:hover td { background:#fdf9f7; }
    .faq-inactive td { opacity:.5; }
    .faq-badge-activo { background:#27ae60; color:#fff; padding:2px 8px; border-radius:10px; font-size:11px; }
    .faq-badge-inactivo { background:#bbb; color:#fff; padding:2px 8px; border-radius:10px; font-size:11px; }
    .btn-edit { color:#B05380; font-weight:600; text-decoration:none; font-size:13px; }
    .btn-edit:hover { text-decoration:underline; }
    .btn-del { color:#c0392b; font-size:13px; font-weight:600; background:none; border:none; cursor:pointer; padding:0; }
    .btn-del:hover { text-decoration:underline; }
    .empty-note { text-align:center; padding:32px; color:#bbb; font-size:15px; }
    .faq-nueva-btn { display:inline-block; padding:9px 20px; background:#B05380; color:#fff; border-radius:5px; text-decoration:none; font-size:14px; font-weight:600; }
    .faq-nueva-btn:hover { background:#8f3a63; color:#fff; }
    .cat-filter { margin-bottom:18px; }
    .cat-filter select { padding:7px 12px; border:1px solid #ccc; border-radius:5px; font-size:14px; min-width:260px; }
  </style>
</head>
<body>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class="container" style="max-width:960px;">
    <div style="height:40px"></div>
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;">
      <div style="font-size:36px;font-weight:300;color:#B05380;">Preguntas frecuentes (FAQs)</div>
      <a href="/admin_library/faq_nueva" class="faq-nueva-btn">+ Nueva pregunta</a>
    </div>

    <?php
    // Aplanar categorías SEO en un array simple id=>nombre
    $a_cat_plana = array();
    foreach ($categorias_seo as $grupo => $items)
      foreach ($items as $cat_id => $cat_name)
        $a_cat_plana[$cat_id] = $cat_name;

    // Separar FAQs por tipo
    $faqs_home = array();
    $faqs_cat  = array(); // page_id => [faq, ...]
    $faqs_tipo = array(); // tipo_producto: page_id => [faq, ...]
    $faqs_marca = array(); // marca: page_id => [faq, ...]
    foreach ($faqs as $faq) {
      if ($faq->page_type === 'home') {
        $faqs_home[] = $faq;
      } elseif ($faq->page_type === 'tipo_producto') {
        $faqs_tipo[$faq->page_id][] = $faq;
      } elseif ($faq->page_type === 'marca') {
        $faqs_marca[$faq->page_id][] = $faq;
      } else {
        $faqs_cat[$faq->page_id][] = $faq;
      }
    }
    // Determinar pestaña activa
    $tab_activo = 'home';
    if ($filtro_tipo === 'categoria') $tab_activo = 'categorias';
    elseif ($filtro_tipo === 'tipo_producto') $tab_activo = 'principales';
    elseif ($filtro_tipo === 'marca') $tab_activo = 'marcas';
    ?>

    <div class="faq-tabs">
      <button class="faq-tab <?= $tab_activo==='home'?'active':'' ?>" id="btn-home" onclick="switchTab('home',this)">
        Home <?php if(count($faqs_home)): ?><span style="background:#B05380;color:#fff;border-radius:10px;padding:1px 7px;font-size:11px;margin-left:4px;"><?= count($faqs_home) ?></span><?php endif; ?>
      </button>
      <button class="faq-tab <?= $tab_activo==='categorias'?'active':'' ?>" id="btn-categorias" onclick="switchTab('categorias',this)">
        Categorías SEO <?php if(count($faqs_cat)): ?><span style="background:#B05380;color:#fff;border-radius:10px;padding:1px 7px;font-size:11px;margin-left:4px;"><?= array_sum(array_map('count',$faqs_cat)) ?></span><?php endif; ?>
      </button>
      <button class="faq-tab <?= $tab_activo==='principales'?'active':'' ?>" id="btn-principales" onclick="switchTab('principales',this)">
        Categorías principales <?php if(count($faqs_tipo)): ?><span style="background:#B05380;color:#fff;border-radius:10px;padding:1px 7px;font-size:11px;margin-left:4px;"><?= array_sum(array_map('count',$faqs_tipo)) ?></span><?php endif; ?>
      </button>
      <button class="faq-tab <?= $tab_activo==='marcas'?'active':'' ?>" id="btn-marcas" onclick="switchTab('marcas',this)">
        Marcas <?php if(count($faqs_marca)): ?><span style="background:#B05380;color:#fff;border-radius:10px;padding:1px 7px;font-size:11px;margin-left:4px;"><?= array_sum(array_map('count',$faqs_marca)) ?></span><?php endif; ?>
      </button>
    </div>

    <!-- Panel HOME -->
    <div class="faq-panel <?= $tab_activo==='home'?'active':'' ?>" id="tab-home">
      <?php if (empty($faqs_home)): ?>
        <div class="empty-note">No hay preguntas para la Home. <a href="/admin_library/faq_nueva" style="color:#B05380;">Crea la primera</a>.</div>
      <?php else: ?>
      <table class="faq-table">
        <thead>
          <tr>
            <th style="width:50px;">Orden</th>
            <th>Pregunta</th>
            <th style="width:80px;text-align:center;">Estado</th>
            <th style="width:110px;text-align:center;">Acciones</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($faqs_home as $faq): ?>
          <tr class="<?= $faq->activo?'':'faq-inactive' ?>">
            <td style="text-align:center;color:#aaa;"><?= (int)$faq->orden ?></td>
            <td><?= htmlspecialchars(mb_substr($faq->pregunta,0,110)) ?><?= mb_strlen($faq->pregunta)>110?'…':'' ?></td>
            <td style="text-align:center;"><?= $faq->activo?'<span class="faq-badge-activo">Activo</span>':'<span class="faq-badge-inactivo">Inactivo</span>' ?></td>
            <td style="text-align:center;">
              <a href="/admin_library/faq_editar/<?= $faq->faq_id ?>" class="btn-edit">Editar</a>
              &nbsp;
              <button class="btn-del" onclick="if(confirm('¿Eliminar esta pregunta?')) window.location='/admin_library/faq_eliminar/<?= $faq->faq_id ?>';">Borrar</button>
            </td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
      <?php endif; ?>
    </div>

    <!-- Panel CATEGORÍAS -->
    <div class="faq-panel <?= $tab_activo==='categorias'?'active':'' ?>" id="tab-categorias">
      <?php
      // Selector de categoría para filtrar
      $cat_filtro = $filtro_page_id;
      ?>
      <div class="cat-filter">
        <label style="font-size:13px;font-weight:600;color:#666;display:block;margin-bottom:6px;">Ver FAQs de la categoría:</label>
        <select onchange="var v=this.value;window.location='/admin_library/faqs?tipo=categoria'+(v>0?'&page_id='+v:'');">
          <option value="0">— Todas las categorías —</option>
          <?php foreach ($categorias_seo as $grupo => $items): ?>
            <optgroup label="<?= htmlspecialchars($grupo) ?>">
              <?php foreach ($items as $cat_id => $cat_name): ?>
                <option value="<?= $cat_id ?>" <?= ($cat_filtro==$cat_id)?'selected':'' ?>><?= htmlspecialchars($cat_name) ?></option>
              <?php endforeach; ?>
            </optgroup>
          <?php endforeach; ?>
        </select>
        <?php if ($cat_filtro > 0): ?>
          <a href="/admin_library/faq_nueva?tipo=categoria&page_id=<?= $cat_filtro ?>" class="faq-nueva-btn" style="margin-left:12px;font-size:13px;padding:7px 16px;">+ Añadir a esta categoría</a>
        <?php endif; ?>
      </div>

      <?php
      $cats_a_mostrar = ($cat_filtro > 0 && isset($faqs_cat[$cat_filtro]))
        ? [$cat_filtro => $faqs_cat[$cat_filtro]]
        : $faqs_cat;
      ?>

      <?php if (empty($cats_a_mostrar)): ?>
        <div class="empty-note">No hay preguntas para esta categoría. <a href="/admin_library/faq_nueva" style="color:#B05380;">Crea la primera</a>.</div>
      <?php else: ?>
        <?php foreach ($cats_a_mostrar as $pid => $pfaqs): ?>
        <div class="faq-cat-group">
          <div class="faq-cat-title">
            <?= htmlspecialchars(isset($a_cat_plana[$pid]) ? $a_cat_plana[$pid] : 'Categoría ID '.$pid) ?>
            <a href="/admin_library/faq_nueva?tipo=categoria&page_id=<?= $pid ?>" style="float:right;font-size:12px;color:#B05380;font-weight:600;">+ añadir</a>
          </div>
          <table class="faq-table">
            <thead>
              <tr>
                <th style="width:50px;">Orden</th>
                <th>Pregunta</th>
                <th style="width:80px;text-align:center;">Estado</th>
                <th style="width:110px;text-align:center;">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pfaqs as $faq): ?>
              <tr class="<?= $faq->activo?'':'faq-inactive' ?>">
                <td style="text-align:center;color:#aaa;"><?= (int)$faq->orden ?></td>
                <td><?= htmlspecialchars(mb_substr($faq->pregunta,0,110)) ?><?= mb_strlen($faq->pregunta)>110?'…':'' ?></td>
                <td style="text-align:center;"><?= $faq->activo?'<span class="faq-badge-activo">Activo</span>':'<span class="faq-badge-inactivo">Inactivo</span>' ?></td>
                <td style="text-align:center;">
                  <a href="/admin_library/faq_editar/<?= $faq->faq_id ?>" class="btn-edit">Editar</a>
                  &nbsp;
                  <button class="btn-del" onclick="if(confirm('¿Eliminar esta pregunta?')) window.location='/admin_library/faq_eliminar/<?= $faq->faq_id ?>';">Borrar</button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div><!-- /panel categorías -->

    <!-- Panel CATEGORÍAS PRINCIPALES -->
    <div class="faq-panel <?= $tab_activo==='principales'?'active':'' ?>" id="tab-principales">
      <div class="cat-filter">
        <a href="/admin_library/faq_nueva?tipo=tipo_producto" class="faq-nueva-btn" style="font-size:13px;padding:7px 16px;">+ Añadir pregunta a una categoría principal</a>
      </div>
      <?php if (empty($faqs_tipo)): ?>
        <div class="empty-note">No hay preguntas para las categorías principales. <a href="/admin_library/faq_nueva?tipo=tipo_producto" style="color:#B05380;">Crea la primera</a>.</div>
      <?php else: ?>
        <?php foreach ($faqs_tipo as $pid => $pfaqs): ?>
        <div class="faq-cat-group">
          <div class="faq-cat-title">
            <?= htmlspecialchars(isset($tipos_producto[$pid]) ? $tipos_producto[$pid] : 'Categoría '.$pid) ?>
            <a href="/admin_library/faq_nueva?tipo=tipo_producto&page_id=<?= $pid ?>" style="float:right;font-size:12px;color:#B05380;font-weight:600;">+ añadir</a>
          </div>
          <table class="faq-table">
            <thead>
              <tr>
                <th style="width:50px;">Orden</th>
                <th>Pregunta</th>
                <th style="width:80px;text-align:center;">Estado</th>
                <th style="width:110px;text-align:center;">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pfaqs as $faq): ?>
              <tr class="<?= $faq->activo?'':'faq-inactive' ?>">
                <td style="text-align:center;color:#aaa;"><?= (int)$faq->orden ?></td>
                <td><?= htmlspecialchars(mb_substr($faq->pregunta,0,110)) ?><?= mb_strlen($faq->pregunta)>110?'…':'' ?></td>
                <td style="text-align:center;"><?= $faq->activo?'<span class="faq-badge-activo">Activo</span>':'<span class="faq-badge-inactivo">Inactivo</span>' ?></td>
                <td style="text-align:center;">
                  <a href="/admin_library/faq_editar/<?= $faq->faq_id ?>" class="btn-edit">Editar</a>
                  &nbsp;
                  <button class="btn-del" onclick="if(confirm('¿Eliminar esta pregunta?')) window.location='/admin_library/faq_eliminar/<?= $faq->faq_id ?>';">Borrar</button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div><!-- /panel principales -->

    <!-- Panel MARCAS -->
    <div class="faq-panel <?= $tab_activo==='marcas'?'active':'' ?>" id="tab-marcas">
      <div class="cat-filter">
        <label style="font-size:13px;font-weight:600;color:#666;display:block;margin-bottom:6px;">Ver / añadir FAQs de una marca:</label>
        <select onchange="var v=this.value;window.location='/admin_library/faq_nueva?tipo=marca'+(v!==''?'&page_id='+v:'');">
          <option value="">— Elige marca para añadir —</option>
          <?php foreach (($marcas ?? array()) as $mid => $mname): ?>
            <option value="<?= $mid ?>"><?= htmlspecialchars($mname) ?></option>
          <?php endforeach; ?>
        </select>
        <a href="/admin_library/faq_nueva?tipo=marca&page_id=0" class="faq-nueva-btn" style="margin-left:12px;font-size:13px;padding:7px 16px;">+ Añadir genérica (todas)</a>
      </div>
      <p style="font-size:13px;color:#888;margin:0 0 18px;background:#fdf5f9;padding:10px 14px;border-radius:6px;">
        Las <b>Genéricas</b> aparecen en <b>todas</b> las marcas (usa <b>{marca}</b> y se sustituye por el nombre). Si una marca tiene FAQs propias, esas <b>sustituyen</b> a las genéricas en esa marca.
      </p>
      <?php if (empty($faqs_marca)): ?>
        <div class="empty-note">No hay preguntas de marca todavía. <a href="/admin_library/faq_nueva?tipo=marca&page_id=0" style="color:#B05380;">Crea la primera genérica</a>.</div>
      <?php else: ?>
        <?php
        // genericas (0) primero
        uksort($faqs_marca, function($a,$b){ return ($a==0?-1:($b==0?1:strcmp((string)$a,(string)$b))); });
        foreach ($faqs_marca as $pid => $pfaqs): ?>
        <div class="faq-cat-group">
          <div class="faq-cat-title">
            <?= htmlspecialchars(isset($marcas[$pid]) ? $marcas[$pid] : 'Marca ID '.$pid) ?>
            <a href="/admin_library/faq_nueva?tipo=marca&page_id=<?= $pid ?>" style="float:right;font-size:12px;color:#B05380;font-weight:600;">+ añadir</a>
          </div>
          <table class="faq-table">
            <thead>
              <tr>
                <th style="width:50px;">Orden</th>
                <th>Pregunta</th>
                <th style="width:80px;text-align:center;">Estado</th>
                <th style="width:110px;text-align:center;">Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pfaqs as $faq): ?>
              <tr class="<?= $faq->activo?'':'faq-inactive' ?>">
                <td style="text-align:center;color:#aaa;"><?= (int)$faq->orden ?></td>
                <td><?= htmlspecialchars(mb_substr($faq->pregunta,0,110)) ?><?= mb_strlen($faq->pregunta)>110?'…':'' ?></td>
                <td style="text-align:center;"><?= $faq->activo?'<span class="faq-badge-activo">Activo</span>':'<span class="faq-badge-inactivo">Inactivo</span>' ?></td>
                <td style="text-align:center;">
                  <a href="/admin_library/faq_editar/<?= $faq->faq_id ?>" class="btn-edit">Editar</a>
                  &nbsp;
                  <button class="btn-del" onclick="if(confirm('¿Eliminar esta pregunta?')) window.location='/admin_library/faq_eliminar/<?= $faq->faq_id ?>';">Borrar</button>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php endforeach; ?>
      <?php endif; ?>
    </div><!-- /panel marcas -->

    <div style="height:60px"></div>
  </div>
  <script>
  function switchTab(tab, btn) {
    document.querySelectorAll('.faq-tab').forEach(function(t){ t.classList.remove('active'); });
    document.querySelectorAll('.faq-panel').forEach(function(p){ p.classList.remove('active'); });
    document.getElementById('tab-'+tab).classList.add('active');
    btn.classList.add('active');
  }
  </script>
</body>
</html>
