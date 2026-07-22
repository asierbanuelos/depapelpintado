<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Categorías SEO</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class="container">
    <?php
    /*
    print '<pre><xmp>';
    print_r($categoria);
    print '</xmp></pre>';
    print '<pre><xmp>';
    print_r($filtros_categoria);
    print '</xmp></pre>';
    */
    echo form_open('admin_library/update_categoria_seo');?>
      <div style="height: 20px"></div>
      <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">EDITAR CATEGORÍA</div>
      <div style="height: 20px"></div>
      <fieldset style='width:100%;'>
        <legend style='padding:0 5px;'> Datos Generales </legend>
        <div style="display:none"><?= form_input('nueva_categoria_id',(int)$categoria->nueva_categoria_id,'') ?></div>
        <div class="sec row"><div class="col two t-six m-six">Nombre:</div><?=  form_input("nueva_categoria_name",$categoria->nueva_categoria_name,'class="ten t-six m-six"')?></div>
        <div class="sec row">
          <div class="col two t-six m-six">&nbsp;</div>
          <div class="ten t-six m-six">* Poner entre &lt;span&gt;&lt;/span&gt; el texto que queramos que se vea en negrita</div>
        </div>

        <div class="sec row"><div class="col two t-six m-six">Tipo producto:</div>
          <div class="ten t-six m-six">
            <?php
              echo form_dropdown('tipo_producto', array("0"=>"Papel Pintado","1"=>"Foto Murales","2"=>"Revestimientos","3"=>"Telas","4"=>"Alfombras","5"=>"Herramientas","6"=>"Complementos"), $categoria->tipo_producto);
            ?>
          </div>
        </div>

        <div class="sec row"><div class="col two t-six m-six">Filtro categoría:</div>
          <div class="ten t-six m-six">
            <?php
              echo form_dropdown('idnueva_categoria_familia', $filtros_categoria, $categoria->idnueva_categoria_familia);
            ?>
          </div>
        </div>
      </fieldset>

      <fieldset style='width:100%;'>
        <legend style='padding:0 5px;'> Web depapelpintado.es </legend>

        <div class="sec row">
          <div class="col two t-six m-six">Nombre filtro:</div><?=  form_input("nombre_filtro",$categoria->nombre_filtro,'class="ten t-six m-six"')?>
        </div>
        <?php 
        /*
        <div class="sec row">Los textos h1 y h2 se generarán por defecto, completar si lo que se quiere es un texto específico:</div>
        <br />
        <div class="sec row"><div class="col two">Texto H2:</div><?= form_input("h2_categoria", $categoria->h2_categoria, 'class="ten"') ?></div>
        */
        ?>
        <div class="sec row"><div class="col two">Texto H1:</div><?= form_input("h1_categoria", $categoria->h1_categoria, 'class="ten"') ?></div>
        <br />
        <?php if (!empty($url_web)): ?>
        <div class="sec row" style="margin-bottom:10px;"><a href="<?= $url_web ?>" target="_blank" style="display:inline-block;background:#B05380;color:#fff;text-decoration:none;padding:6px 16px;border-radius:4px;">Ver en la web &rarr;</a></div>
        <?php endif; ?>
        <div class="sec row" style="margin-top:6px;"><strong>Intro corta</strong> (1-2 frases, se muestra bajo el título del catálogo):</div>
        <div class="sec row"><textarea name="intro_categoria" maxlength="500" style="width:100%;height:70px;" placeholder="Ej. Descubre el papel pintado para… (1-2 frases)"><?php echo htmlspecialchars(isset($categoria->intro_categoria) ? $categoria->intro_categoria : ''); ?></textarea></div>
        <br />
        <div class="sec row">Descripción (al menos 900 palabras):</div>
        <div class="sec row"><textarea id="descripcion_categoria" name="descripcion_categoria"><?php echo $categoria->descripcion_categoria; ?></textarea></div>
        <br />
        <div class="sec row">
          <div class="col two"><label for="nueva_categoria_activo">Activa:</label></div>
          <div class="ten"><?= form_checkbox("nueva_categoria_activo", "1", $categoria->nueva_categoria_activo, 'id="nueva_categoria_activo"') ?></div>
        </div>
        <div class="sec row">
          <div class="col two"><label for="categoria_publico">Filtro publico en web:</label></div>
          <div class="ten"><?= form_checkbox("categoria_publico", "1", $categoria->categoria_publico, 'id="categoria_publico"') ?></div>
        </div>
        <br />
        <div class="">
          <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title_categoria", $categoria->meta_title_categoria, 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description_categoria", $categoria->meta_description_categoria, 'class="ten" style="height:50px"') ?></div>
          <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords_categoria", $categoria->meta_keywords_categoria, 'class="ten"') ?></div>
        </div>
      </fieldset>


      <fieldset style='width:100%;' id='info-ekam'>
        <legend style='padding:0 5px;'> Web EKAM decoracioón </legend>
        <div style="display:none"><?= form_input('nueva_categoria_id_ekam',(int)$categoria_ekam->nueva_categoria_id,'') ?></div>
        <div class="sec row">
          <div class="col two t-six m-six">Nombre filtro:</div><?=  form_input("nombre_filtro_ekam",$categoria_ekam->nombre_filtro,'class="ten t-six m-six"')?>
        </div>
        <?php 
        /*
        <div class="sec row">Los textos h1 y h2 se generarán por defecto, completar si lo que se quiere es un texto específico:</div>
        <br />
        <div class="sec row"><div class="col two">Texto H2:</div><?= form_input("h2_categoria_ekam", $categoria_ekam->h2_categoria, 'class="ten"') ?></div>
        */
        ?>
        <div class="sec row"><div class="col two">Texto H1:</div><?= form_input("h1_categoria_ekam", $categoria_ekam->h1_categoria, 'class="ten"') ?></div>
        <br />
        <div class="sec row">Descripción (al menos 900 palabras):</div>
        <div class="sec row"><textarea id="descripcion_categoria_ekam" name="descripcion_categoria_ekam"><?php echo $categoria_ekam->descripcion_categoria; ?></textarea></div>
        <br />
        <div class="sec row">
          <div class="col two"><label for="nueva_categoria_activo_ekam">Activa:</label></div>
          <div class="ten"><?= form_checkbox("nueva_categoria_activo_ekam", "1", $categoria_ekam->nueva_categoria_activo, 'id="nueva_categoria_activo_ekam"') ?></div>
        </div>
        <div class="sec row">
          <div class="col two"><label for="categoria_publico_ekam">Filtro publico en web:</label></div>
          <div class="ten"><?= form_checkbox("categoria_publico_ekam", "1", $categoria_ekam->categoria_publico, 'id="categoria_publico_ekam"') ?></div>
        </div>
        <br />
        <div class="">
          <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title_categoria_ekam", $categoria_ekam->meta_title_categoria, 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description_categoria_ekam", $categoria_ekam->meta_description_categoria, 'class="ten" style="height:50px"') ?></div>
          <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords_categoria_ekam", $categoria_ekam->meta_keywords_categoria, 'class="ten"') ?></div>
        </div>
      </fieldset>

      <div style="height: 20px"></div>
      <div class="sec row">
        <?php echo form_submit("test", "Guardar",'class="button orange-button six t-full m-full send"')?>
        <?echo form_button("test", "Cancelar",'class="button orange-button six t-full m-full close"')?>
      </div>
      <br />
    <?=form_close();?>

    <!-- Foto de portada -->
    <fieldset style='width:100%;margin-top:20px;'>
      <legend style='padding:0 5px;'>Foto de portada</legend>
      <div style="padding:16px;">
        <?php
        $cat_img_src = '';
        $cat_img_path = FCPATH . 'includes/images/categorias-productos/' . $categoria->nueva_categoria_id . '-' . $categoria->nueva_categoria_name_url . '.webp';
        $cat_img_path_jpg = FCPATH . 'includes/images/categorias-productos/' . $categoria->nueva_categoria_id . '-' . $categoria->nueva_categoria_name_url . '.jpg';
        if (file_exists($cat_img_path))     $cat_img_src = '/includes/images/categorias-productos/' . $categoria->nueva_categoria_id . '-' . $categoria->nueva_categoria_name_url . '.webp?' . filemtime($cat_img_path);
        elseif (file_exists($cat_img_path_jpg)) $cat_img_src = '/includes/images/categorias-productos/' . $categoria->nueva_categoria_id . '-' . $categoria->nueva_categoria_name_url . '.jpg?' . filemtime($cat_img_path_jpg);
        elseif (!empty($categoria->categoria_img)) $cat_img_src = '/includes/' . str_replace('../includes/', '', $categoria->categoria_img);
        ?>
        <?php if ($cat_img_src): ?>
          <img src="<?= htmlspecialchars($cat_img_src) ?>" id="categ-img-preview" style="max-width:300px;max-height:200px;object-fit:cover;display:block;margin-bottom:12px;border:1px solid #ddd;">
        <?php else: ?>
          <p style="color:#aaa;font-size:13px;">No hay imagen de portada aún.</p>
        <?php endif; ?>
        <?= form_open_multipart('admin_library/upload_categoria_seo_img/' . $categoria->nueva_categoria_id) ?>
          <input type="file" name="imagen" accept="image/*" onchange="document.getElementById('categ-img-preview') && (document.getElementById('categ-img-preview').src = URL.createObjectURL(this.files[0]))" style="font-size:13px;">
          <p style="color:#888;font-size:12px;margin:6px 0;">Formatos admitidos: JPG, PNG, WEBP &mdash; Se genera automáticamente copia en WEBP.</p>
          <input type="submit" value="Subir imagen" class="button orange-button" style="margin-top:6px;">
        <?= form_close() ?>
      </div>
    </fieldset>

  <?php $this->load->view('includes/scripts'); ?> 
  <script type="text/javascript" src="<?=$includes_dir?>/tinymce/tinymce.min.js"></script>
  <script type="text/javascript">
  tinymce.init({
    convert_urls: false,entity_encoding : "raw",
      selector: "textarea",
      language: "es",
        plugins: [
          "advlist autolink lists link image charmap print preview hr anchor pagebreak",
          "searchreplace wordcount visualblocks visualchars code fullscreen",
          "insertdatetime media nonbreaking save table contextmenu directionality",
          "emoticons template paste textcolor imgsurfer"
      ],
      toolbar1: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | imgsurfer",
      toolbar2: "print preview media | forecolor backcolor emoticons",
      image_advtab: true,
      templates: [
          {title: 'Test template 1', content: 'Test 1'},
          {title: 'Test template 2', content: 'Test 2'}
      ]
   });
  $(".close").click(function(){
    $(location).attr("href", "/admin_library/categorias_seo");
  });
  </script>
</body>
</html>