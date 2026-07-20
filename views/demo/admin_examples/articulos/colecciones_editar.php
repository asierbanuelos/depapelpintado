<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Colecciones SEO</title>
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
    print_r($coleccion);
    print '</xmp></pre>';
    print '<pre><xmp>';
    print_r($coleccion_ekam);
    print '</xmp></pre>';
    print '<pre><xmp>';
    print_r($filtros_coleccion);
    print '</xmp></pre>';
    */

    echo form_open('admin_library/update_coleccion_seo');?>
      <div style="height: 20px"></div>
      <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">EDITAR COLECCIÓN</div>
      <div style="height: 20px"></div>

      <fieldset style='width:100%;'>
        <legend style='padding:0 5px;'> Datos Generales </legend>
        <div class="sec row">
          <div class="col three"><label for="col_text_publico">Desc. publicada en web:</label></div>
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
      </fieldset>

      <fieldset style='width:100%;'>
        <legend style='padding:0 5px;'> Web depapelpintado.es </legend>
        <div style="display:none"><?= form_input('coleccion_id',(int)$coleccion->coleccion_id,'') ?></div>
        <div style="display:none"><?= form_input('volver_ekam',(int)$volver_ekam,'') ?></div>
        <div class="sec row">Intro corta (1-2 frases, se muestra bajo el título del catálogo):</div>
        <div class="sec row"><textarea id="col_intro" name="col_intro" maxlength="500" style="height:60px" placeholder="Ej. Descubre la colección X de MARCA: papel pintado de estilo… (1-2 frases)"><?php echo isset($coleccion->col_intro) ? $coleccion->col_intro : ''; ?></textarea></div>
        <br />
        <div class="sec row">Descripción (al menos 900 palabras):</div>
        <div class="sec row"><textarea id="col_text" name="col_text"><?php echo $coleccion->col_text; ?></textarea></div>
        <br />
        <br />
        <div class="">
          <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title_coleccion", $coleccion->meta_titlec, 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description_coleccion", $coleccion->meta_descriptionc, 'class="ten" style="height:50px"') ?></div>
          <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords_coleccion", $coleccion->meta_keywordsc, 'class="ten"') ?></div>
        </div>
      </fieldset>


      <fieldset style='width:100%;' id='info-ekam'>
        <legend style='padding:0 5px;'> Web EKAM decoración </legend>
        <div style="display:none"><?= form_input('coleccion_id_ekam',(int)$coleccion_ekam->coleccion_id,'') ?></div>
        <div class="sec row">Descripción (al menos 900 palabras):</div>
        <div class="sec row"><textarea id="col_text_ekam" name="col_text_ekam"><?php echo $coleccion_ekam->col_text; ?></textarea></div>
        <br />
        <br />
        <div class="">
          <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title_coleccion_ekam", $coleccion_ekam->meta_titlec, 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description_coleccion_ekam", $coleccion_ekam->meta_descriptionc, 'class="ten" style="height:50px"') ?></div>
          <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords_coleccion_ekam", $coleccion_ekam->meta_keywordsc, 'class="ten"') ?></div>
        </div>
      </fieldset>

      <div style="height: 20px"></div>
      <div class="sec row">
        <?php 
        echo form_submit("test", "Guardar",'class="button orange-button six t-full m-full send"');
        if ($volver_ekam)
          echo form_button("test", "Cancelar",'class="button orange-button six t-full m-full close_ekam"');
        else
          echo form_button("test", "Cancelar",'class="button orange-button six t-full m-full close"');
        ?>
      </div>
      <br />
    <?=form_close();?>

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
    $(location).attr("href", "/admin_library/colecciones_seo");
  });
  $(".close_ekam").click(function(){
    $(location).attr("href", "/admin_library/colecciones_seo_ekam");
  });
  </script>
</body>
</html>