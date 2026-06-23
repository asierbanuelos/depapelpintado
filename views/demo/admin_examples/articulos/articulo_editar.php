<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Artículos</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  <?php 
  $this->load->view('includes/demo_header'); 
  $cola = array('pared' => 'Pared', 'papel' => 'Papel', 'autoadhesivo'=>"Autoadhesivo");
  $lavab = array('0' => 'No Lavable', '1' => 'Lavable', '2'=>'Esponjable', '3'=>'SuperLavable');
  ?>
  <div class="container">
      <?php 
      /*
      print '<pre><xmp>';
      print_r($colorid);
      print '</xmp></pre>';
      echo "<br />item_id: $item_id";
      */
      echo form_open('admin_library/update_art_test');
      ?>
      <div style="height: 20px"></div>
      <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">EDITAR ARTÍCULO</div>
      <?php if (isset($_GET['saved'])): ?>
      <div style="background:#d4edda;color:#155724;border:1px solid #c3e6cb;border-radius:4px;padding:12px 20px;margin:16px 0;font-size:15px;font-weight:600;">
        ✓ Cambios guardados correctamente.
      </div>
      <?php endif; ?>
      <div style="height: 20px"></div>
      <div style="display:none"><?= form_input('item_id',$item_id,'') ?></div>
      <div class="sec row">
        <div class="col six t-six m-full">
          <div class="sec row">
            <div class="col six">GAMA:</div>
            <div class="col six">ESTILO:</div>
          </div>
          <div class="sec row">
            <?= form_multiselect('gama[]', $gama, explode(',',$colorid), 'class="col six" style="height:400px" id="select_colores" ') ?>
            <?= form_multiselect('estilo[]', $estilo, explode(',',$estiloid), 'class="col six" style="height:400px"') ?>
          </div>
          <div class="sec row">
            <div class="col six">CATEGORÍAS PARA FILTROS:</div>
          </div>
          <div class="sec row">
            <?=form_multiselect('nuevas_categorias[]',$nuevas_categorias,explode(',',$nuevacategoriaid),'class="col twelve" style="height:490px"')?>
          </div>
          <div class="sec row">Extra:<?=  form_textarea('extra',$extra,'class="col twelve" style="height:150px"')?></div>

          <div class="sec row"><div class="col six">Tiene Variantes:</div><?= form_checkbox("tiene_variantes", "1", $tiene_variantes) ?></div>
          <div class="sec row">
            <div class="col six">Variante de:</div>
            <select name="variante_de" class="col six variante_de">
              <?php
              $this->load->view('demo/admin_examples/articulos/opciones_variantes', $variantes);
              ?>
            </select>
          </div>
          <?php
          /*
          print '<pre><xmp>';
          print_r($opciones_variantes);
          print '</xmp></pre>';
          */
          ?>
          <br /> 
          <div class="sec row"><div class="col six">Tiene Relacionados:</div><?= form_checkbox("tiene_relacionados", "1", $tiene_relacionados) ?></div>
          <div class="sec row">
            <div class="col six">Relacionado con:</div>
            <select name="relacionado_con" class="col six relacionado_con">
              <?php
              $this->load->view('demo/admin_examples/articulos/opciones_relacionados');
              ?>
            </select>
          </div>
          <?php
          /*
          print '<pre><xmp>';
          print_r($relacionados);
          print '</xmp></pre>';
          */
          ?>
          <div class="sec row">
            <div class="col six">Texto relación:</div><?= form_input("texto_relacion", $texto_relacion, 'class="six"') ?>
          </div>
          <br />

          <?php
          $a_limpiezas=array("Limpieza Seco","Lavadora","A mano","No centrifugar","No Secadora","Sin Lejia","Planchar temperatura baja","Planchar temperatura media","Planchar temperatura alta","Lavar máximo 30º","Lavar máximo 40º","Lavar máximo 60º")
          ?>
          <div class="sec row catshow"><div class="col six">Limpieza:</div><?= form_multiselect("limpieza[]", $a_limpiezas, explode(' ',$limpieza), 'class="six"') ?></div>
        </div>
        <div class="col six t-six m-full">
          <div class="sec row">
            <div class="col four">Economico: <?= form_checkbox("economico", "1", $item_economico) ?></div>
            <div class="col four">Más Vendido: <?= form_checkbox("topventas", "1", $item_top) ?></div>
            <div class="col four">Portada: <?= form_checkbox("portada", "1", $portada) ?></div>
          </div>
          <div class="sec row">
            <div class="col six">Categoría:</div>
            <?=form_dropdown('cats',array("0"=>"Papel Pintado","1"=>"Foto Murales","2"=>"Revestimientos","3"=>"Telas","4"=>"Alfombras"),$item_tipo,'class="six cathid"')?>
          </div>
          <div class="sec row"><div class="col six">Fabricante:</div><?= form_dropdown('fab', $fab, $item_cat_fk, 'class="six fabr"') ?></div>
          <div class="sec row"><div class="col six">Colección:</div><?= form_dropdown('col', $col, $item_coleccion_id, 'class="six cole"') ?></div>
          <div class="sec row"><div class="col six">Modelo:</div><?= form_dropdown('mod', $mod, $item_model_id, 'class="six mod"') ?></div>
          <div class="sec row"><div class="col six">Referencia:</div><?= form_input("ref", $item_ref, 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Nombre:</div><?= form_input("name", $item_name, 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Lavable:</div><?= form_dropdown("lavable", $lavab,$item_lavable, 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Resistente al Sol:</div><?= form_checkbox("sol", "1", $item_sol) ?></div>
          <div class="sec row"><div class="col six">Vinilo:</div><?= form_checkbox("vinilo", "1", $item_vinilo) ?></div>
          <div class="sec row"><div class="col six">Encolar a:</div><?= form_dropdown('cola', $cola, $item_cola, 'class="six fabr"') ?></div>
          <div class="sec row"><div class="col six">Ancho metros:</div><?= form_input("ancho", $item_ancho, 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Largo metros:</div><?= form_input("largo", $item_largo, 'class="six"') ?></div>
          <div class="sec row">
            <div class="col six">Case metros largo (ancho):</div>
            <?= form_input("case",$item_case,'class="three"')?> 
            <?= form_input("case2",$item_case2,'class="three catshow"')?>
          </div>
          <div class="sec row"><div class="col six">Peso:</div><?= form_input("weight", "", 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Unidades:</div><?=form_dropdown('unidad',array("Rollo"=>"Rollo","m lineal"=>"Metro Lineal","m2"=>"Metro Cuadrado","Unidad"=>"Unidad"),$item_unidad,'class="six fabr"')?></div>
          <div class="sec row"><div class="col six">Precio:</div><?= form_input("precio", $item_price, 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Precio auxiliar:</div><?= form_input("precio_aux", $item_price_aux, 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Orden:</div><?= form_input("orden", $orden, 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Stock:</div><?= form_input("stock", $stock_quantity, 'class="six"') ?></div>
          <div class="sec row" style="margin-bottom:10px;">
            <div class="col six">Portada ambiente:</div>
            <?= form_checkbox("usar_alt","1",$usar_alt)?>
          </div>
          <div class="sec row">
            <div class="col six">
              Categorias ambiente:<br />(sin categoría para mostrar en todas)
            </div>
            <?= form_multiselect('usar_alt_lista[]',$a_usar_alt_lista,explode(',',$usar_alt_lista),'class="six" style="height:300px;font-size:0.9em;"')?>
          </div>
          <div class="sec row catshow catshow2"><div class="col six">Composicion:</div><?= form_input("composicion", $composicion, 'class="six"') ?></div>
          <?php
          $a_uso=array('Cortinas','Tapicerias','Stores','Cojines','Cabeceros','Visillos');
          ?>
          <div class="sec row catshow"><div class="col six">Uso Recomendado:</div><?= form_multiselect("uso[]",$a_uso ,explode(' ',$uso), 'class="six uso"') ?></div>
        </div>
        <div class="col twelve">
          <div class="sec row">
            <div class="col six">
              Imágen detalle:
              <br>Alt:<?= form_input("imgdetalt", $imgdetalt ) ?>
              <br>Title:<?= form_input("imgdettitle", $imgdettitle ) ?>
            </div>
            <div class="col six">
              Imágen ambiente:
              <br>Alt:<?= form_input("imgambalt", $imgambalt ) ?>
              <br>Title:<?= form_input("imgambtitle", $imgambtitle ) ?>
            </div>
          </div>
        </div>
      </div>
      <div class="col twelve">
        <div class="sec row"><div class="col two">Meta-Title:</div><?= form_input("meta_title", $meta_title, 'class="ten"') ?></div>
        <div class="sec row"><div class="col two">Meta-Description:</div><?= form_textarea("meta_description", $meta_description, 'class="ten"  style="height:150px"') ?></div>
        <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords", $meta_keywords, 'class="ten"') ?></div>
        <div class="sec row"><div class="col two"><label for="google_market_be">Google Market:</label></div><div class="ten"><?= form_checkbox("google_market_be", "1", $google_market_be, 'id="google_market_be"') ?></div></div>
        <br />
      </div>
      <div style="height: 20px"></div>
      <?php echo form_submit("test", "Guardar",'class="button orange-button twelve t-full m-full send"')?>
      <?php //echo form_button("test", "Cancelar",'class="button orange-button six t-full m-full close"')?>
      <br />
      <br />
      <?= form_close(); ?>
      <br />

  </div>


  <?php 
  $this->load->view('includes/scripts'); 
  ?> 
  <script type="text/javascript" src="<?=$includes_dir?>/tinymce/tinymce.min.js"></script>
  <script type="text/javascript">
  /*
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
   */
    $(".close").click(function(){
      $(location).attr("href", "/admin_library/categorias_seo");
    });
  </script>
</body>
</html>