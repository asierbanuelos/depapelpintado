<!doctype html>
<html lang="es" class="no-js">
<head>
  <meta charset="utf-8">
  <title><?= (isset($faq) && $faq) ? 'Editar' : 'Nueva' ?> Pregunta FAQ</title>
  <?php $this->load->view('includes/admin_head'); ?>
  <style>
    .faq-form label { display:block; font-weight:600; margin-bottom:4px; margin-top:16px; color:#555; }
    .faq-form input[type=text], .faq-form textarea, .faq-form select { width:100%; padding:8px; border:1px solid #ccc; border-radius:4px; font-size:14px; box-sizing:border-box; }
    .faq-form textarea { min-height:140px; resize:vertical; }
    .page-selector { display:flex; gap:16px; align-items:flex-start; flex-wrap:wrap; }
  </style>
</head>
<body>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class="container" style="max-width:800px;">
    <div style="height:40px"></div>
    <div style="font-size:36px;font-weight:300;color:#B05380;border-bottom:1px solid #B05380;padding-bottom:10px;">
      <?= (isset($faq) && $faq) ? 'Editar pregunta FAQ' : 'Nueva pregunta FAQ' ?>
    </div>
    <div style="height:24px"></div>

    <?= form_open('admin_library/faq_guardar'); ?>
    <?php if (isset($faq) && $faq): ?>
      <input type="hidden" name="faq_id" value="<?= (int)$faq->faq_id ?>">
    <?php else: ?>
      <input type="hidden" name="faq_id" value="0">
    <?php endif; ?>

    <div class="faq-form">
      <label>Página donde aparece esta FAQ</label>
      <div class="page-selector">
        <div>
          <select name="page_type" id="page_type_sel" onchange="toggleCatSelect(this.value)" style="padding:8px;border:1px solid #ccc;border-radius:4px;">
            <option value="home" <?= (!isset($faq)||!$faq||$faq->page_type=='home')?'selected':'' ?>>Home</option>
            <option value="categoria" <?= (isset($faq)&&$faq&&$faq->page_type=='categoria')?'selected':'' ?>>Categoría SEO</option>
          </select>
        </div>
        <div id="cat_selector" style="<?= (isset($faq)&&$faq&&$faq->page_type=='categoria')?'':'display:none;' ?>flex:1;min-width:260px;">
          <select name="page_id" style="width:100%;padding:8px;border:1px solid #ccc;border-radius:4px;">
            <option value="0">-- Selecciona categoría --</option>
            <?php foreach ($categorias_seo as $grupo => $items): ?>
              <optgroup label="<?= htmlspecialchars($grupo) ?>">
                <?php foreach ($items as $cat_id => $cat_name): ?>
                  <option value="<?= $cat_id ?>" <?= (isset($faq)&&$faq&&$faq->page_id==$cat_id)?'selected':'' ?>><?= htmlspecialchars($cat_name) ?></option>
                <?php endforeach; ?>
              </optgroup>
            <?php endforeach; ?>
          </select>
        </div>
      </div>

      <label>Pregunta <small style="font-weight:normal;color:#999;">(aparecerá como título visible)</small></label>
      <input type="text" name="pregunta" value="<?= htmlspecialchars(isset($faq)&&$faq?$faq->pregunta:'') ?>" placeholder="¿Cuál es el plazo de entrega?" required>

      <label>Respuesta</label>
      <textarea name="respuesta" placeholder="El plazo habitual es de 3 a 5 días laborables..." required><?= htmlspecialchars(isset($faq)&&$faq?$faq->respuesta:'') ?></textarea>

      <div style="display:flex;gap:24px;margin-top:16px;align-items:center;">
        <div>
          <label style="margin-top:0;">Orden <small style="font-weight:normal;color:#999;">(menor = primero)</small></label>
          <input type="number" name="orden" value="<?= (int)(isset($faq)&&$faq?$faq->orden:0) ?>" style="width:100px;">
        </div>
        <div style="display:flex;align-items:center;gap:8px;margin-top:16px;">
          <input type="checkbox" name="activo" id="activo" value="1" <?= (!isset($faq)||!$faq||$faq->activo)?'checked':'' ?> style="width:auto;">
          <label for="activo" style="margin:0;font-weight:600;cursor:pointer;">Activo (visible en la web)</label>
        </div>
      </div>

      <div style="margin-top:28px;display:flex;gap:14px;">
        <?= form_submit('guardar', (isset($faq)&&$faq)?'Guardar cambios':'Crear FAQ', 'class="button orange-button" style="padding:10px 28px;"') ?>
        <a href="/admin_library/faqs" class="button" style="padding:10px 20px;background:#aaa;color:#fff;text-decoration:none;border-radius:4px;">Cancelar</a>
      </div>
    </div>
    <?= form_close(); ?>
    <div style="height:60px"></div>
  </div>
  <script>
  function toggleCatSelect(val){
    document.getElementById('cat_selector').style.display = (val==='categoria') ? 'block' : 'none';
    if (val!=='categoria') document.querySelector('[name=page_id]').value='0';
  }
  </script>
</body>
</html>
