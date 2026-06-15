<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Bloques</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  
  <?php $this->load->view('includes/demo_header'); ?>
  
  <div class="container">
    <?php
    echo form_open_multipart('admin_library/update_page');
    echo form_hidden("id",$pagina->id);
    echo form_hidden("tipo",$pagina->tipo);
    ?>
     <div class="row">
       <div class="col one"> &nbsp; </div><div class="col one" > &nbsp; </div>
      <div class="col ten">Editar <?=$pagina->tipo?></div>
    </div>
    <div class="row">
      <div class="col one"> &nbsp; </div>
      <div class="col one">Titulo</div>
      <div class="col ten"><?=form_input('titulo',$pagina->titulo, ' style="width:100%;" ')?></div>
    </div>
    <div class="row">
      <div class="col one"> &nbsp; </div>
      <div class="col one"><?php echo ($pagina->tipo=="Imagen") ? 'Subtítulo (overlay)' : 'Texto'; ?></div>
      <div class="col ten"><?=form_textarea('texto',$pagina->texto)?></div>
    </div>
    <?php if($pagina->tipo=="Imagen"):?>
    	 <div class="row">
      <div class="col one"> &nbsp; </div>
      <div class="col one">Zona</div>
      <div class="col ten"><?=form_input('zona',$pagina->zona, ' style="width:100%;" ')?></div>
    </div>
    <div class="row">
      <div class="col one"> &nbsp; </div>
      <div class="col one">Orden</div>
      <div class="col ten"><?=form_input('orden',$pagina->orden)?></div>
    </div>
    <div class="row">
      <div class="col one"> &nbsp; </div>
      <div class="col one">Enlace</div>
      <div class="col ten"><?=form_input('enlace',$pagina->enlace, ' style="width:100%;" ')?></div>
    </div>
    <div class="row">
      <div class="col one"> &nbsp; </div>
      <div class="col one">Imagen</div>
      <div class="col ten">
        <?php
        // Compute current image URL for preview
        if (strpos($pagina->zona, 'mosaico') !== FALSE) {
          $img_slug = urlenc($pagina->titulo);
          $img_preview = $includes_dir . 'images/home/' . $img_slug . '.jpg';
          echo form_hidden('img_clean_name', $img_slug);
        } else {
          $img_preview = $includes_dir . 'images/slider/' . $pagina->id . '.jpg';
        }
        ?>
        <div style="margin-bottom:10px;">
          <img id="img-preview" src="<?= $img_preview ?>" style="max-width:300px;max-height:150px;display:block;border:1px solid #ddd;background:#f5f5f5;" onerror="this.style.opacity=0.2">
        </div>
        <input type="file" name="imagen" accept="image/*" onchange="previewImg(this)">
        <p style="font-size:11px;color:#999;margin-top:4px;">Formatos: JPG, PNG, WEBP. Se recomienda JPG/WEBP.</p>
      </div>
    </div>
    <?php endif; ?>

     <?=form_submit("", "Guardar",'class="button orange-button twelve t-full m-full send"')?>
     <br />
  </div>
  <?php $this->load->view('includes/scripts'); ?>
  <script>
  function previewImg(input) {
    if (input.files && input.files[0]) {
      var reader = new FileReader();
      reader.onload = function(e) {
        var el = document.getElementById('img-preview');
        if (el) { el.src = e.target.result; el.style.opacity = 1; }
      };
      reader.readAsDataURL(input.files[0]);
    }
  }
  </script>
</body>
</html>