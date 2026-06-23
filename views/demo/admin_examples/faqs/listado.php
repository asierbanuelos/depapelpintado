<!doctype html>
<html lang="es" class="no-js">
<head>
  <meta charset="utf-8">
  <title>Preguntas Frecuentes (FAQs)</title>
  <?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class="container">
    <div style="height:40px"></div>
    <div style="font-size:40px;font-weight:300;color:#B05380;text-align:center;border-bottom:1px solid #B05380;">PREGUNTAS FRECUENTES (FAQs)</div>
    <div style="height:20px"></div>

    <div class="sec row" style="margin-bottom:20px;">
      <div class="col six">
        <form method="get" action="/admin_library/faqs" style="display:flex;gap:10px;align-items:center;flex-wrap:wrap;">
          <select name="tipo" style="padding:6px;border:1px solid #ccc;border-radius:4px;">
            <option value="">-- Todas las páginas --</option>
            <option value="home" <?= ($filtro_tipo=='home')?'selected':'' ?>>Home</option>
            <option value="categoria" <?= ($filtro_tipo=='categoria')?'selected':'' ?>>Categorías SEO</option>
          </select>
          <?php if ($filtro_tipo=='categoria'): ?>
          <select name="page_id" style="padding:6px;border:1px solid #ccc;border-radius:4px;">
            <option value="0">-- Todas las categorías --</option>
            <?php foreach ($categorias_seo as $grupo => $items): ?>
              <optgroup label="<?= htmlspecialchars($grupo) ?>">
                <?php foreach ($items as $cat_id => $cat_name): ?>
                  <option value="<?= $cat_id ?>" <?= ($filtro_page_id==$cat_id)?'selected':'' ?>><?= htmlspecialchars($cat_name) ?></option>
                <?php endforeach; ?>
              </optgroup>
            <?php endforeach; ?>
          </select>
          <?php endif; ?>
          <button type="submit" class="button orange-button" style="padding:6px 14px;">Filtrar</button>
        </form>
      </div>
      <div class="col six" style="text-align:right;">
        <a href="/admin_library/faq_nueva" class="button orange-button" style="display:inline-block;padding:8px 18px;text-decoration:none;color:#fff;">+ Nueva pregunta</a>
      </div>
    </div>

    <?php if (empty($faqs)): ?>
      <div style="text-align:center;padding:40px;color:#999;font-size:18px;">No hay preguntas frecuentes. <a href="/admin_library/faq_nueva">Crea la primera</a>.</div>
    <?php else: ?>
    <table style="width:100%;border-collapse:collapse;font-size:14px;">
      <thead>
        <tr style="background:#B05380;color:#fff;">
          <th style="padding:10px;text-align:left;width:80px;">Página</th>
          <th style="padding:10px;text-align:left;">Pregunta</th>
          <th style="padding:10px;text-align:center;width:60px;">Orden</th>
          <th style="padding:10px;text-align:center;width:60px;">Activo</th>
          <th style="padding:10px;text-align:center;width:120px;">Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $a_cat_plana = array();
        foreach ($categorias_seo as $grupo => $items)
          foreach ($items as $cat_id => $cat_name)
            $a_cat_plana[$cat_id] = $cat_name;

        foreach ($faqs as $faq):
          $pagina_label = ($faq->page_type == 'home')
            ? '<span style="background:#5b8dd4;color:#fff;padding:2px 7px;border-radius:3px;font-size:12px;">Home</span>'
            : '<span style="background:#5ba45b;color:#fff;padding:2px 7px;border-radius:3px;font-size:12px;">Categ.</span><br><small style="color:#666;">'.htmlspecialchars(isset($a_cat_plana[$faq->page_id])?$a_cat_plana[$faq->page_id]:'ID '.$faq->page_id).'</small>';
        ?>
        <tr style="border-bottom:1px solid #eee;<?= ($faq->activo?'':'background:#fafafa;opacity:0.6;') ?>">
          <td style="padding:10px;"><?= $pagina_label ?></td>
          <td style="padding:10px;"><?= htmlspecialchars(mb_substr($faq->pregunta, 0, 120)) ?><?= (mb_strlen($faq->pregunta)>120)?'…':'' ?></td>
          <td style="padding:10px;text-align:center;"><?= (int)$faq->orden ?></td>
          <td style="padding:10px;text-align:center;"><?= $faq->activo ? '✓' : '–' ?></td>
          <td style="padding:10px;text-align:center;">
            <a href="/admin_library/faq_editar/<?= $faq->faq_id ?>" style="color:#B05380;margin-right:10px;">Editar</a>
            <a href="/admin_library/faq_eliminar/<?= $faq->faq_id ?>" style="color:#c0392b;" onclick="return confirm('¿Eliminar esta pregunta?');">Borrar</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
    <?php endif; ?>
    <div style="height:60px"></div>
  </div>
</body>
</html>
