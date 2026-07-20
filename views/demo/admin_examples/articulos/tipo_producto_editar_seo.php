<?php
$nombres_tipo = array(0=>'Papel Pintado',1=>'Murales',2=>'Revestimientos',3=>'Telas',4=>'Alfombras',5=>'Herramientas',6=>'Complementos');
$nom = isset($nombres_tipo[(int)$tipo_producto->tipo_producto_id]) ? $nombres_tipo[(int)$tipo_producto->tipo_producto_id] : ('Tipo '.$tipo_producto->tipo_producto_id);
?>
<!doctype html>
<html lang="es" class="no-js">
<head>
	<meta charset="utf-8">
	<title>Textos SEO — Categoría</title>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class="container">
    <?php echo form_open('admin_library/update_tipo_producto_seo'); ?>
      <div style="height:20px"></div>
      <div style="font-size:34px;font-weight:300;color:#B05380;text-align:center;border-bottom:1px solid #B05380;">Textos SEO — <?php echo htmlspecialchars($nom); ?></div>
      <div style="height:10px"></div>
      <p><a href="/admin_library/tipos_producto_seo" style="color:#B05380;">&larr; Volver al listado de categorías</a></p>

      <input type="hidden" name="tipo_producto_id" value="<?php echo (int)$tipo_producto->tipo_producto_id; ?>">

      <fieldset style="width:100%;">
        <legend style="padding:0 5px;"> Web depapelpintado.es </legend>

        <div class="sec row"><strong>Intro corta</strong> (1-2 frases, se muestra bajo el título del catálogo):</div>
        <div class="sec row"><textarea id="intro_tipo_producto" name="intro_tipo_producto" maxlength="500" style="width:100%;height:70px;" placeholder="Ej. Encuentra el papel pintado ideal para tu pared: más de 1000 muestrarios… (1-2 frases)"><?php echo htmlspecialchars($tipo_producto->intro_tipo_producto); ?></textarea></div>

        <div class="sec row" style="margin-top:14px;"><strong>Descripción larga</strong> (aparece debajo del catálogo; al menos ~900 palabras para SEO):</div>
        <div class="sec row"><textarea id="descripcion_tipo_producto" name="descripcion_tipo_producto" style="width:100%;height:320px;"><?php echo htmlspecialchars($tipo_producto->descripcion_tipo_producto); ?></textarea></div>

        <div class="sec row" style="margin-top:14px;"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title_tipo_producto", $tipo_producto->meta_title_tipo_producto, 'class="ten" style="width:100%"') ?></div>
        <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description_tipo_producto", $tipo_producto->meta_description_tipo_producto, 'class="ten" style="width:100%;height:50px"') ?></div>
        <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords_tipo_producto", $tipo_producto->meta_keywords_tipo_producto, 'class="ten" style="width:100%"') ?></div>
      </fieldset>

      <div style="height:20px"></div>
      <div style="text-align:center"><?= form_submit('guardar','Guardar','style="font-size:18px;padding:11px 45px;background:#B05380;color:#fff;border:none;cursor:pointer;border-radius:4px;"') ?></div>
      <div style="height:50px"></div>
    <?php echo form_close(); ?>
  </div>
</body>
</html>
