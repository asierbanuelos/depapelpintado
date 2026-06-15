<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Tipo Productos SEO</title>
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
    print_r($tipo_producto);
    print '</xmp></pre>';
    print '<pre><xmp>';
    print_r($tipo_producto_ekam);
    print '</xmp></pre>';
    print '<pre><xmp>';
    print_r($filtros_coleccion);
    print '</xmp></pre>';
    */
    switch ($tipo_producto->tipo_producto_id) {
        case 0: $categ = "Papel Pintado";
            break;
        case 1: $categ = "Fotomurales";
            break;
        case 2: $categ = "Revestimientos";
            break;
        case 3: $categ = "Telas";
            break;
        case 4: $categ = "Alfombras";
            break;
        case 5: $categ = "Herramientas";
            break;
        default: break;
    }

    echo form_open('admin_library/update_tipo_producto_seo');?>
      <div style="height: 20px"></div>
      <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">EDITAR <?php echo strtoupper($categ); ?></div>
      <div style="height: 20px"></div>

      <fieldset style='width:100%;'>
        <legend style='padding:0 5px;'> Web depapelpintado.es </legend>
        <div style="display:none"><?= form_input('tipo_producto_id',(int)$tipo_producto->tipo_producto_id,'') ?></div>
        <div class="sec row">Descripción (al menos 900 palabras):</div>
        <div class="sec row"><textarea id="descripcion_tipo_producto" name="descripcion_tipo_producto"><?php echo $tipo_producto->descripcion_tipo_producto; ?></textarea></div>
        <br />
        <br />
        <div class="">
          <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title_tipo_producto", $tipo_producto->meta_title_tipo_producto, 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description_tipo_producto", $tipo_producto->meta_description_tipo_producto, 'class="ten" style="height:50px"') ?></div>
          <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords_tipo_producto", $tipo_producto->meta_keywords_tipo_producto, 'class="ten"') ?></div>
          <?php 
          /*
          */
          ?>
        </div>
      </fieldset>


      <fieldset style='width:100%;' id='info-ekam'>
        <legend style='padding:0 5px;'> Web EKAM decoración </legend>
        <div style="display:none"><?= form_input('tipo_producto_id_ekam',(int)$tipo_producto_ekam->tipo_producto_id,'') ?></div>
        <div class="sec row">Descripción (al menos 900 palabras):</div>
        <div class="sec row"><textarea id="descripcion_tipo_producto_ekam" name="descripcion_tipo_producto_ekam"><?php echo $tipo_producto_ekam->descripcion_tipo_producto; ?></textarea></div>
        <br />
        <br />
        <div class="">
          <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title_tipo_producto_ekam", $tipo_producto_ekam->meta_title_tipo_producto, 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description_tipo_producto_ekam", $tipo_producto_ekam->meta_description_tipo_producto, 'class="ten" style="height:50px"') ?></div>
          <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords_tipo_producto_ekam", $tipo_producto_ekam->meta_keywords_tipo_producto, 'class="ten"') ?></div>
          <?php 
          /*
          */
          ?>
        </div>
      </fieldset>

      <div style="height: 20px"></div>
      <div class="sec row">
        <?php 
        echo form_submit("test", "Guardar",'class="button orange-button six t-full m-full send"');
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
    $(location).attr("href", "/admin_library/tipo_productos_seo");
  });
  </script>
</body>
</html>