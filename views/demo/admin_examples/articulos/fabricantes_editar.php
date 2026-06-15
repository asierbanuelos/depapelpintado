<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Fabricantes SEO</title>
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
    print_r($categoria_ekam);
    print '</xmp></pre>';
    */

    echo form_open('admin_library/update_fabricante_seo');?>
      <div style="height: 20px"></div>
      <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">EDITAR INFO SEO FABRICANTE</div>
      <div style="height: 20px"></div>

      <fieldset style='width:100%;'>
        <legend style='padding:0 5px;'> Web depapelpintado.es </legend>
        <div style="display:none"><?= form_input('cat_id',(int)$categoria->cat_id,'') ?></div>
        <div style="display:none"><?= form_input('volver_ekam',(int)$volver_ekam,'') ?></div>
        <div class="sec row">Descripción (al menos 900 palabras):</div>
        <div class="sec row"><textarea id="cat_text" name="cat_text"><?php echo $categoria->cat_text; ?></textarea></div>
        <br />
        <br />
        <div class="">
          <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title_categoria", $categoria->meta_titlef, 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description_categoria", $categoria->meta_descriptionf, 'class="ten" style="height:50px"') ?></div>
          <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords_categoria", $categoria->meta_keywordsf, 'class="ten"') ?></div>
        </div>
      </fieldset>


      <fieldset style='width:100%;' id='info-ekam'>
        <legend style='padding:0 5px;'> Web EKAM decoración </legend>
        <div style="display:none"><?= form_input('cat_id_ekam',(int)$categoria_ekam->cat_id,'') ?></div>
        <div class="sec row">Descripción (al menos 900 palabras):</div>
        <div class="sec row"><textarea id="cat_text_ekam" name="cat_text_ekam"><?php echo $categoria_ekam->cat_text; ?></textarea></div>
        <br />
        <br />
        <div class="">
          <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title_categoria_ekam", $categoria_ekam->meta_titlef, 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description_categoria_ekam", $categoria_ekam->meta_descriptionf, 'class="ten" style="height:50px"') ?></div>
          <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords_categoria_ekam", $categoria_ekam->meta_keywordsf, 'class="ten"') ?></div>
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
    $(location).attr("href", "/admin_library/fabricantes_seo");
  });
  $(".close_ekam").click(function(){
    $(location).attr("href", "/admin_library/fabricantes_seo_ekam");
  });
  </script>
</body>
</html>