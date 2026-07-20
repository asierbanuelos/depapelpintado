<!doctype html>
<html lang="es" class="no-js">
<head>
	<meta charset="utf-8">
	<title>Textos SEO — Colección</title>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class="container">
    <?php echo form_open('admin_library/update_coleccion_seo'); ?>
      <div style="height:20px"></div>
      <div style="font-size:34px;font-weight:300;color:#B05380;text-align:center;border-bottom:1px solid #B05380;">Textos SEO — <?php echo htmlspecialchars($coleccion->coleccion_name); ?></div>
      <div style="height:10px"></div>
      <p><a href="/admin_library/colecciones_seo" style="color:#B05380;">&larr; Volver al listado de colecciones</a></p>

      <input type="hidden" name="col" value="<?php echo (int)$coleccion->coleccion_id; ?>">

      <fieldset style="width:100%;">
        <legend style="padding:0 5px;"> Web depapelpintado.es </legend>

        <div class="sec row">
          <div class="col three"><label for="col_text_publico">Descripción publicada en web:</label></div>
          <div class="nine"><?= form_checkbox("col_text_publico", "1", $coleccion->col_text_publico, 'id="col_text_publico"') ?></div>
        </div>
        <div class="sec row">
          <div class="col three"><label for="greca_misma_coleccion_be">Greca misma colección:</label></div>
          <div class="nine"><?= form_checkbox("greca_misma_coleccion_be", "1", $coleccion->greca_misma_coleccion_be, 'id="greca_misma_coleccion_be"') ?></div>
        </div>
        <div class="sec row">
          <div class="col three"><label for="xml_META_be">Incluir para promos en META:</label></div>
          <div class="nine"><?= form_checkbox("xml_META_be", "1", $coleccion->xml_META_be, 'id="xml_META_be"') ?></div>
        </div>

        <div class="sec row" style="margin-top:14px;"><strong>Intro corta</strong> (1-2 frases, se muestra bajo el título del catálogo):</div>
        <div class="sec row"><textarea id="col_intro" name="col_intro" maxlength="500" style="width:100%;height:70px;" placeholder="Ej. Descubre la colección X de MARCA: papel pintado de estilo… (1-2 frases)"><?php echo htmlspecialchars($coleccion->col_intro); ?></textarea></div>

        <div class="sec row" style="margin-top:14px;"><strong>Descripción larga</strong> (aparece debajo del catálogo; al menos ~900 palabras para SEO):</div>
        <div class="sec row"><textarea id="col_text" name="col_text" style="width:100%;height:280px;"><?php echo htmlspecialchars($coleccion->col_text); ?></textarea></div>

        <div class="sec row" style="margin-top:14px;"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title", $coleccion->meta_titlec, 'class="ten" style="width:100%"') ?></div>
        <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description", $coleccion->meta_descriptionc, 'class="ten" style="width:100%;height:50px"') ?></div>
        <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords", $coleccion->meta_keywordsc, 'class="ten" style="width:100%"') ?></div>
      </fieldset>

      <div style="height:20px"></div>
      <div style="text-align:center"><?= form_submit('guardar','Guardar','style="font-size:18px;padding:11px 45px;background:#B05380;color:#fff;border:none;cursor:pointer;border-radius:4px;"') ?></div>
      <div style="height:50px"></div>
    <?php echo form_close(); ?>
  </div>
</body>
</html>
