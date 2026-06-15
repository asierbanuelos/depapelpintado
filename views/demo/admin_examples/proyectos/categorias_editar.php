<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Categorías Proyectos</title>
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
    echo form_open('admin_library/update_categoria_proyecto');?>
      <div style="height: 20px"></div>
      <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">EDITAR CATEGORÍA</div>
      <div style="height: 20px"></div>

        <input type='hidden' name='idproyecto_categoria' id='idproyecto_categoria' value='<?php echo (int)$categoria->idproyecto_categoria;?>' />
        <div class="sec row"><div class="col two t-six m-six">Nombre:</div><?=  form_input("proyecto_categoria_name",$categoria->proyecto_categoria_name,'class="ten t-six m-six"')?></div>
        <div class="sec row">
          <div class="col two t-six m-six">&nbsp;</div>
          <div class="ten t-six m-six">* Poner entre &lt;span&gt;&lt;/span&gt; el texto que queramos que se vea en negrita</div>
        </div>

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
        <div class="sec row"><div class="col two">Texto H2:</div><?= form_input("h2_categoria", $categoria->h2_categoria, 'class="ten"') ?></div>
        <br />
        <div class="sec row">Descripción (al menos 900 palabras):</div>
        <div class="sec row"><textarea id="descripcion_categoria" name="descripcion_categoria"><?php echo $categoria->descripcion_categoria; ?></textarea></div>
        <br />
        <div class="sec row">
          <div class="col two"><label for="categoria_publico">Filtro público en web:</label></div>
          <div class="ten"><?= form_checkbox("categoria_publico", "1", $categoria->categoria_publico, 'id="categoria_publico"') ?></div>
        </div>
        <br />
        <div class="">
          <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title_categoria", $categoria->meta_title_categoria, 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description_categoria", $categoria->meta_description_categoria, 'class="ten" style="height:50px"') ?></div>
          <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords_categoria", $categoria->meta_keywords_categoria, 'class="ten"') ?></div>
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
    $(location).attr("href", "/admin_library/categorias_proyectos");
  });
  </script>
</body>
</html>