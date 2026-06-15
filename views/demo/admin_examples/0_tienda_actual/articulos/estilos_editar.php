<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Estilos</title>
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
    print_r($estilo);
    print '</xmp></pre>';
    */
    echo form_open('admin_library/update_estilo');?>
      <div style="height: 20px"></div>
      <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">EDITAR ESTILO</div>
      <div style="height: 20px"></div>
      
      <div style="display:none"><?= form_input('estilo',$estilo->estilo_id,'') ?></div>
      <div class="sec row"><div class="col two t-six m-six">ESTILO:</div><?=  form_input("name",$estilo->estilo_name,'class="ten t-six m-six"')?></div>
      
      <div class="sec row"><div class="col two"><label for="principal">Principal:</label></div><div class="ten"><?= form_checkbox("principal", "1", $estilo->principal, 'id="principal"') ?></div></div>
      <div class="sec row"><div class="col two"><label for="activo">Activo:</label></div><div class="ten"><?= form_checkbox("activo", "1", $estilo->activo, 'id="activo"') ?></div></div>

      <div class="sec row"><div class="col two t-six m-six">Categorias:</div>
        <div class="ten t-six m-six">
          <?= form_multiselect('cats[]', array("Papel Pintado"=>"Papel Pintado","Foto Murales"=>"Foto Murales","Revestimientos"=>"Revestimientos","Telas"=>"Telas","Alfombras"=>"Alfombras"), explode(',', $estilo->cats)) ?>
        </div>
      </div>

      <div class="sec row">Los textos h1 y h2 se generarán por defecto, completar si lo que se quiere es un texto específico:</div>
      <br />
      <div class="sec row"><div class="col two">Texto H1:</div><?= form_input("h1_estilo", $estilo->h1_estilo, 'class="ten"') ?></div>
      <div class="sec row"><div class="col two">Texto H2:</div><?= form_input("h2_estilo", $estilo->h2_estilo, 'class="ten"') ?></div>
      <br />
      <div class="sec row">Descripción (al menos 900 palabras):</div>
      <div class="sec row"><textarea id="descripcion_estilo" name="descripcion_estilo"><?php echo $estilo->descripcion_estilo; ?></textarea></div>
      <br />
      <div class="sec row">
        <div class="col two"><label for="descripcion_estilo_publico">Desc. publicada en web:</label></div>
        <div class="ten"><?= form_checkbox("descripcion_estilo_publico", "1", $estilo->descripcion_estilo_publico, 'id="descripcion_estilo_publico"') ?></div></div>
      <br />
      <div class="">
        <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title_estilo", $estilo->meta_title_estilo, 'class="ten"') ?></div>
        <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description_estilo", $estilo->meta_description_estilo, 'class="ten" style="height:50px"') ?></div>
        <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords_estilo", $estilo->meta_keywords_estilo, 'class="ten"') ?></div>
      </div>
      <div style="height: 20px"></div>
      <div class="sec row">
        <?php echo form_submit("test", "Guardar",'class="button orange-button six t-full m-full send"')?>
        <?echo form_button("test", "Cancelar",'class="button orange-button six t-full m-full close"')?>
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
    $(location).attr("href", "/admin_library/estilos");
  });
  </script>
</body>
</html>