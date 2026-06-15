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
      <?= form_open('admin_library/noimg');
   $fab[0]='';
   $col[0]='';
   $nuevas_categorias_aux[0]='';
   $nuevas_categorias_buscador=array_merge($nuevas_categorias_aux, $nuevas_categorias);
   $gama[0]='';
   $estilo[0]='';
   $categ=array("-1"=>"SIN FILTRAR","0"=>"PAPEL PINTADO","1"=>"FOTOMURALES","2"=>"REVESTIMIENTOS","3"=>"TELAS","4"=>"ALFOMBRAS");
    ?>
      	<div style="height: 20px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">ZONA SIN IMAGENES</div>
    <div style="height: 40px"></div>
      <div class="col six t-six m-full">
    
        <div class="sec row"><div class="col six">Fabricante:</div><?= form_dropdown('fab', $fab, $curfab, 'class="six fabr"') ?></div>
        <div class="sec row"><div class="col six">Colección:</div><?= form_dropdown('col', $col, $curcol, 'class="six cole"') ?></div>
        <div class="sec row"><div class="col six">Categoria SEO:</div><?= form_dropdown('categoria_seo', $nuevas_categorias_buscador, $cur_cat_seo, 'class="six cat_seo"') ?></div>
        <div class="sec row"><div class="col six">Gama:</div><?= form_dropdown('gama', $gama, $curgama, 'class="six cole"') ?></div>
        <div class="sec row"><div class="col six">Estilo:</div><?= form_dropdown('estilo', $estilo, $curestilo, 'class="six cole"') ?></div>
        <div class="sec row"><div class="col six">Categoria:</div><?= form_dropdown('categ', $categ, $curcateg, 'class="six cole"') ?></div>
        <div class="sec row"><div class="col six">Referencia:</div><?= form_input("referencia", $curreferencia, 'class="six"') ?></div>
        <div class="sec row"><div class="col six">Precio:</div><?= form_input("precio", $curprecio, 'class="six"') ?></div>
        <div class="sec row">
          <div class="col six">
            &nbsp;
          </div>
          <div class="col six">
            <p>MOSTRAR SOLO PUBLICADOS  <?= form_checkbox("publico_be", "1", $publico_be) ?></p>
            <p>VINILO <?= form_checkbox("vinilo_be", "1", $vinilo_be) ?></p>
          </div>
        </div>
        <div class="sec row">
          <div class="col six">
          ORDEN <select name="order">
            <option value="item_id" <?=($curorder=="item_id")?'selected="selected"':'';?>>Introducción</option>
            <option value="item_ref" <?=($curorder=="item_ref")?'selected="selected"':'';?>>Referencia</option>
            <option value="coleccion_name" <?=($curorder=="coleccion_name")?'selected="selected"':'';?>>Coleccion</option>
            <option value="cat_name" <?=($curorder=="cat_name")?'selected="selected"':'';?>>Fabricante</option>
          </select></div>
          <div class="col six">
      	  <?php
      	  /*
                MOSTRAR INACTIVOS  <input type="checkbox" name="item_activo" value="1"/>
                */
      	  ?>
      	  MOSTRAR INACTIVOS  <?= form_checkbox("item_activo", "1") ?>
          </div>
        </div>
      </div>
      <?php
      echo form_submit("test", "Filtrar", 'class="button orange-button twelve m-full send"'); 
      //echo form_button("test", "Limpiar filtros", 'class="button orange-button twelve m-full limpiar-filtros"');
      ?>
      <a class="button orange-button twelve m-full" href='/admin_library/noimg?limpiar=1' style='margin-top:10px;font-weight:400;font-size: 20px;' >Limpiar filtros</a>
      <?php
      echo form_close(); 
      ?>
    </div>
      
  </div>
  	
  <div id="editform" style="position:fixed;top:0;width:100%;height:100%;z-index: 100;background-color:rgba(0,0,0,0.6);padding:20px;display:none;">
    <div class="container" style="background-color:#eee;padding-bottom: 10px;border-radius: 10px;">
      <?= form_open('admin_library/update_art'); ?>
      <div class="sec row">
        <div class="col six t-six m-full">
          <div class="sec row">
            <div class="col six">GAMA:</div>
            <div class="col six">ESTILO:</div>
          </div>
          <div class="sec row">
            <?= form_multiselect('gama[]', $gama, '', 'class="col six" style="height:400px" id="select_colores" ') ?>
            <?= form_multiselect('estilo[]', $estilo, '', 'class="col six" style="height:400px"') ?>
          </div>
          <div class="sec row">
            <div class="col six">CATEGORÍAS PARA FILTROS:</div>
          </div>
          <div class="sec row">
            <?=form_multiselect('nuevas_categorias[]',$nuevas_categorias,'','class="col twelve" style="height:490px"')?>
          </div>
          <div class="sec row">Extra:<?=  form_textarea('extra','','class="col twelve" style="height:150px"')?></div>

          <div class="sec row"><div class="col six">Tiene Variantes:</div><?= form_checkbox("tiene_variantes", "1") ?></div>
          <div class="sec row">
            <div class="col six">Variante de:</div>
            <select name="variante_de" class="col six variante_de">
              <option value="0">No es variante</option>
            </select>
          </div>

          <br /> 
          <div class="sec row"><div class="col six">Tiene Relacionados:</div><?= form_checkbox("tiene_relacionados", "1") ?></div>
          <div class="sec row">
            <div class="col six">Relacionado con:</div>
            <select name="relacionado_con" class="col six relacionado_con">
              <option value="0">No está relacionado</option>
            </select>
          </div>
          <div class="sec row">
            <div class="col six">Texto relación:</div><?= form_input("texto_relacion", "", 'class="six"') ?>
          </div>
          <br />

           <?$limpieza=array("Limpieza Seco","Lavadora","A mano","No centrifugar","No Secadora","Sin Lejia","Planchar temperatura baja","Planchar temperatura media","Planchar temperatura alta","Lavar máximo 30º","Lavar máximo 40º","Lavar máximo 60º")?>
    <div class="sec row catshow"><div class="col six">Limpieza:</div><?= form_multiselect("limpieza[]", $limpieza, 'class="six"') ?></div>
        </div>
        <div class="col six t-six m-full">
          <?= form_hidden('item_id') ?>
          <?= form_hidden('var_de') ?>
          <?= form_hidden('rel_con') ?>
          <div class="sec row"><div class="col four">Economico: <?= form_checkbox("economico", "1") ?></div><div class="col four">Más Vendido: <?= form_checkbox("topventas", "1") ?></div><div class="col four">Portada: <?= form_checkbox("portada", "1") ?></div></div>
          <div class="sec row"><div class="col six">Categoría:</div><?=form_dropdown('cats',array("0"=>"Papel Pintado","1"=>"Foto Murales","2"=>"Revestimientos","3"=>"Telas","4"=>"Alfombras","5"=>"Herramientas","6"=>"Complementos"),'','class="six cathid"')?></div>
          <div class="sec row"><div class="col six">Fabricante:</div><?= form_dropdown('fab', $fab, '', 'class="six fabr"') ?></div>
          <div class="sec row"><div class="col six">Colección:</div><?= form_dropdown('col', $col, '', 'class="six cole"') ?></div>
          <div class="sec row"><div class="col six">Modelo:</div><?= form_dropdown('mod', $mod, '', 'class="six mod"') ?></div>
          <div class="sec row"><div class="col six">Referencia:</div><?= form_input("ref", "", 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Nombre:</div><?= form_input("name", "", 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Lavable:</div><?= form_dropdown("lavable", $lavab,'', 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Resistente al Sol:</div><?= form_checkbox("sol", "1") ?></div>
          <div class="sec row"><div class="col six">Vinilo:</div><?= form_checkbox("vinilo", "1") ?></div>
          <div class="sec row"><div class="col six">Encolar a:</div><?= form_dropdown('cola', $cola, '', 'class="six fabr"') ?></div>
          <div class="sec row"><div class="col six">Ancho metros:</div><?= form_input("ancho", "", 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Largo metros:</div><?= form_input("largo", "", 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Case metros largo (ancho):</div><?= form_input("case","",'class="three"')?> <?= form_input("case2","",'class="three catshow"')?></div>
          <div class="sec row"><div class="col six">Peso:</div><?= form_input("weight", "", 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Unidades:</div><?=form_dropdown('unidad',array("Rollo"=>"Rollo","m lineal"=>"Metro Lineal","m2"=>"Metro Cuadrado","Unidad"=>"Unidad"),'','class="six fabr"')?></div>
          <div class="sec row"><div class="col six">Precio:</div><?= form_input("precio", "", 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Orden:</div><?= form_input("orden", "", 'class="six"') ?></div>
          <div class="sec row"><div class="col six">Stock:</div><?= form_input("stock", "", 'class="six"') ?></div>
          <div class="sec row" style="margin-bottom:10px;"><div class="col six">Portada ambiente:</div><?= form_checkbox("usar_alt","", 'class="six"')?></div>
          <div class="sec row">
            <div class="col six">
              Categorias ambiente:<br />(sin categoría para mostrar en todas)
            </div>
            <?= form_multiselect('usar_alt_lista[]',$usar_alt_lista,'','class="six" style="height:300px;font-size:0.9em;"')?>
          </div>
          <div class="sec row catshow catshow2"><div class="col six">Composicion:</div><?= form_input("composicion", "", 'class="six"') ?></div>
    <?$uso=array('Cortinas','Tapicerias','Stores','Cojines','Cabeceros','Visillos');?>
          <div class="sec row catshow"><div class="col six">Uso Recomendado:</div><?= form_multiselect("uso[]",$uso ,'', 'class="six uso"') ?></div>
        </div>
          <div class="col twelve">
          <div class="sec row"><div class="col six">Imágen detalle:<br>Alt:<?= form_input("imgdetalt", "" ) ?><br>Title:<?= form_input("imgdettitle", "" ) ?></div><div class="col six">Imágen ambiente:<br>Alt:<?= form_input("imgambalt", "" ) ?><br>Title:<?= form_input("imgambtitle", "" ) ?></div></div>
         </div></div>
        <div class="col twelve">
          <div class="sec row"><div class="col two">Meta-Title:</div><?= form_input("meta_title", "", 'class="ten"') ?></div>
          <div class="sec row"><div class="col two">Meta-Description:</div><?= form_textarea("meta_description", "", 'class="ten"  style="height:150px"') ?></div>
          <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords", "", 'class="ten"') ?></div>
          <div class="sec row"><div class="col two"><label for="google_market_be">Google Market:</label></div><div class="ten"><?= form_checkbox("google_market_be", "1", "0", 'id="google_market_be"') ?></div></div>
          <br />
        </div>
      <?= form_button("test", "Guardar", 'class="button orange-button six m-full sendupdate"') ?>
      <?= form_button("test", "Cerrar", 'class="button orange-button six m-full closeform"') ?>
      <?= form_close(); ?>
    </div>
  </div>
  
<div id="edit_masivo_form" style="position:fixed;top:0;width:100%;height:100%;z-index: 100;background-color:rgba(0,0,0,0.6);padding:20px;display:none;">
	<div class="container" style="background-color:#eee;padding-bottom: 10px;border-radius: 10px;padding:20px;">
		<?
    if (isset($_GET['test'])){
      echo  form_open('admin_library/update_art_masivo_test');
    }
    else{
      echo  form_open('admin_library/update_art_masivo');
    }
    ?>
			<?= form_hidden('fab', $curfab) ?>
			<?= form_hidden('col', $curcol) ?>
			<?= form_hidden('gama', $curgama) ?>
			<?= form_hidden('estilo', $curestilo) ?>
			<?= form_hidden('categ', $curcateg) ?>
			<?= form_hidden('referencia', $curreferencia) ?>
			<?= form_hidden('precio', $curprecio) ?>
			<?= form_hidden('order', $curorder) ?>
			<div class="sec row"><div class="col six">Ancho metros:</div><?= form_input("ancho", "", 'class="six"') ?></div>
			<?php
			/*
			<div class="sec row"><div class="col six">Largo metros:</div><?= form_input("largo", "", 'class="six"') ?></div>
			*/
			?>
			<div class="sec row"><div class="col six">Precio:</div><?= form_input("precio", "", 'class="six"') ?></div>
      <div class="sec row"><div class="col six">Precio auxiliar:</div><?= form_input("precio_aux","", 'class="six"') ?></div>
			<?= form_button("test", "Guardar", 'class="button orange-button six m-full sendupdate_masivo"') ?>
			<?= form_button("test", "Cerrar", 'class="button orange-button six m-full closeform_masivo"') ?>
		<?= form_close(); ?>
	</div>
</div>
	
  <div class="container list">
  	<div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">LISTADO ARTÍCULOS</div>
    <div style="height: 40px"></div>
    <?=$count?> Resultados.
	<span class="edit btn" id="seleccionar_todos">Seleccionar<br />todos</span>
	<span class="edit btn" id="desmarcar_todos" style='display:none'>Quitar<br />todos</span>
	<span class="edit btn" id="editar_seleccionados">Editar<br />Selección</span>
	<div class="cuadro_resultados">
		<?
		$this->load->view('demo/admin_examples/articulos/cuadro_resultados');
		// $this->load->view('demo/paginador'); 
		?>
	</div>
  </div>
  <?php $this->load->view('includes/scripts'); ?> 
  <script>
    function addline(d) {
      var l = (d.item_lavable == 1) ? "L" : "l";
      var s = (d.item_sol == 1) ? "S" : "s";
      var v = (d.item_vinilo == 1) ? "V" : "v";
      var text = '<div class="sec row"><div class="col one t-two m-three"><span style="background-color: #000;display:block;width:74px;height:74px"></span></div><div class="col two t-three m-three">' +
              d.item_name + '<br/>' + d.cat_name + '<br/>' + d.coleccion_name + '<br/>' + d.modelo_name + '<br/></div><div class="col two t-three m-three">Ancho: ' + d.item_ancho + '<br/>Largo: ' + d.item_largo + '<br/>Case: ' + d.item_case + '<br/>' +
              l + ' - ' + s + ' - ' + v + '</div><div class="col two t-three m-three"><b>Precio: ' +
              d.item_price + '</b><br/></div></div>';
      $('.list').prepend(text);

    }
    $(document).ready(function() {
      $(".fabr").change(function(e) {
        if ($(this).val() > -1) {
          var t=$(this);
          $.ajax({
            url: "<?= site_url('admin_library/get_col_select') ?>",
            type: 'POST',
            data: t.closest('form').serialize(),
            success: function(data) {
              $('#editform .cole').html(data);
              $('#editform .mod').html("");
              $.ajax({
                url: "<?= site_url('admin_library/con_variantes') ?>",
                type: 'POST',
                data: t.closest('form').serialize(),
                success: function(data) {
                  $('.variante_de').html(data);
                }
              });
              $.ajax({
                url: "<?= site_url('admin_library/con_relacionados') ?>",
                type: 'POST',
                data: t.closest('form').serialize(),
                success: function(data) {
                  $('.relacionado_con').html(data);
                }
              });
            }
          })
          
        }
      });
      $(".cole").change(function(e) {
        if ($(this).val() > 0) {
          var t=$(this);
          $.ajax({
            url: "<?= site_url('admin_library/get_mod_select') ?>",
            type: 'POST',
            data: t.closest('form').serialize(),
            success: function(data) {
              $('#editform .mod').html(data);
              $.ajax({
                url: "<?= site_url('admin_library/con_variantes') ?>",
                type: 'POST',
                data: t.closest('form').serialize(),
                success: function(data) {
                  $('.variante_de').html(data);
                }
              });
              $.ajax({
                url: "<?= site_url('admin_library/con_relacionados') ?>",
                type: 'POST',
                data: t.closest('form').serialize(),
                success: function(data) {
                  $('.relacionado_con').html(data);
                }
              });
            }
          })
        }
      });
      $('.row').on('click','.del', function(e) {
        if(confirm("¿Estas seguro de querer borrar el registro?")){
          var t = $(this).attr('id');
          var p = $(this).parent().parent();
          $.ajax({
            url: "<?= site_url('admin_library/del') ?>",
            type: 'POST',
            data: '&t=items&n=item&i=' + t,
            success: function(data) {
              p.slideUp();
            }
          });
        }
      });
      var p;
      $('.row').on('click','.publicar',function(e){
    var t=$(this).attr('id');
     var pub=$(this).html();
    if(pub=="Publicar")pub="1";
    else pub="0";
    var p=$(this);
      $.ajax({
        url:"<?=site_url('admin_library/publica_item')?>",
        type:'POST',
        data:'&activar='+pub+'&i='+t,
        success:function(data){
          if(data=="0"){p.html("Publicar");p.attr('data-publico',data);}
          else if(data=="1"){p.html("Ocultar");p.attr('data-publico',data);}
        }
      });
    });
    $(".cathid").change(function(e){
     $(".catshow").hide();
     if($(this).val()==3){
        $(".catshow").show();
      }
      if($(this).val()==4){
        $(".catshow2").show();
      }
    });
	$('.row').on('click','.edit', function(e) {
		var t = $(this).attr('id');
		p = $(this).parent().parent();
		$.ajax({
			dataType: "json",
			url: "<?= site_url('admin_library/get_item') ?>",
			type: 'POST',
			data: 'i=' + t,
			success: function(data) {
				$("#editform").show();
				var d = data[0];
        //alert(d);
				var col = d['colorid'].split(', ');
				var uso = d['uso'].split(' ');

				$(".catshow").hide();
				if(d['item_tipo']==3){
					$(".catshow").show();
				}
				if(d['item_tipo']==4){
					$(".catshow2").show();
				}
				if ($("#editform .fabr").val() !== d['item_cat_fk']) {
					$("#editform .fabr").find('option[value="' + d['item_cat_fk'] + '"]').attr("selected", true);
					$("#editform .fabr").change();
					setTimeout(function() {
						if ($("#editform .cole").val() != d['item_coleccion_id']) {
							$("#editform .cole").find('option[value="' + d['item_coleccion_id'] + '"]').attr("selected", true);
							$("#editform .cole").change();
							setTimeout(function() {
								$("#editform .mod").find('option[value="' + d['item_model_id'] + '"]').attr("selected", true);
							}, 1000);
						}
						else {
							$("#editform .mod").find('option[value="' + d['item_model_id'] + '"]').attr("selected", true);
						}
					}, 1000);
				}
				else if ($("#editform .cole").val() != d['item_coleccion_id']) {
					$("#editform .cole").find('option[value="' + d['item_coleccion_id'] + '"]').attr("selected", true);
					$("#editform .cole").change();
					setTimeout(function() {
						$("#editform .mod").find('option[value="' + d['item_model_id'] + '"]').attr("selected", true);
					}, 1000);
				}
				else {
					$("#editform .mod").find('option[value="' + d['item_model_id'] + '"]').attr("selected", true);
				}

				if ($("#editform .variante_de").val() != d['variante_de']) {
					$("#editform .variante_de").find('option[value="' + d['variante_de'] + '"]').attr("selected", true);
					$("#editform .variante_de").change();
				}

        if ($("#editform .relacionado_con").val() != d['relacionado_con']) {
          $("#editform .relacionado_con").find('option[value="' + d['relacionado_con'] + '"]').attr("selected", true);
          $("#editform .relacionado_con").change();
        }

				//$("#editform select[name='gama[]']").val(0);
        $('#select_colores').val('');
				col.forEach(function(e) {
          $('#select_colores option[value="'+e+'"]').prop("selected", true);
					//$("#editform select[name='gama[]']").find('option[value="' + e + '"]').attr("selected", true);
				});

				var est = d['estiloid'].split(', ');
        //$("#editform select[name='estilo[]']").val(0);
				$("#editform select[name='estilo[]']").val('');
				est.forEach(function(e) {
          $("#editform select[name='estilo[]']").find('option[value="' + e + '"]').prop("selected", true);
					//$("#editform select[name='estilo[]']").find('option[value="' + e + '"]').attr("selected", true);
				});

        var nuevas_cat = d['nuevacategoriaid'].split(', ');
        $("#editform select[name='nuevas_categorias[]']").val(0);
        nuevas_cat.forEach(function(e) {
          //$("#editform select[name='nuevas_categorias[]']").find('option[value="' + e + '"]').attr("selected", true);
          $("#editform select[name='nuevas_categorias[]']").find('option[value="' + e + '"]').prop("selected", true);
        });

        var usar_alt_lis = d['usar_alt_lista'].split(',');
        $("#editform select[name='usar_alt_lista[]']").val(0);
        usar_alt_lis.forEach(function(e) {
          //$("#editform select[name='usar_alt_lista[]']").find('option[value="' + e + '"]').attr("selected", true);
          $("#editform select[name='usar_alt_lista[]']").find('option[value="' + e + '"]').prop("selected", true);
        });
        /*
        */
				var limp = d['limpieza'].split(' ');
				$("#editform select[name='limpieza[]']").val("");
				limp.forEach(function(e) {
          //$("#editform select[name='limpieza[]']").find('option[value="' + e + '"]').attr("selected", true);
					$("#editform select[name='limpieza[]']").find('option[value="' + e + '"]').prop("selected", true);
				});
				var uso = d['uso'].split(' ');
				$("#editform select[name='uso[]']").val("");
				uso.forEach(function(e) {
          //$("#editform select[name='uso[]']").find('option[value="' + e + '"]').attr("selected", true);
					$("#editform select[name='uso[]']").find('option[value="' + e + '"]').prop("selected", true);
				});
				$("#editform input[name='item_id']").val(d['item_id']);
				$("#editform input[name='ref']").val(d['item_ref']);
				$("#editform input[name='name']").val(d['item_name']);
				// $("#editform input[name='lavable']").prop('checked', (d['item_lavable'] == 1) ? true : false);
				$("#editform input[name='sol']").prop('checked', (d['item_sol'] == 1) ? true : false);
				$("#editform input[name='vinilo']").prop('checked', (d['item_vinilo'] == 1) ? true : false);
				$("#editform input[name='usar_alt']").prop('checked', (d['usar_alt'] == 1) ? true : false);
				$("#editform input[name='economico']").prop('checked', (d['item_economico'] == 1) ? true : false);
				$("#editform input[name='topventas']").prop('checked', (d['item_top'] == 1) ? true : false);
				$("#editform input[name='portada']").prop('checked', (d['portada'] == 1) ? true : false);
				$("#editform input[name='tiene_variantes']").prop('checked', (d['tiene_variantes'] == 1) ? true : false);
        $("#editform input[name='google_market_be']").prop('checked', (d['google_market_be'] == 1) ? true : false);
        $("#editform input[name='tiene_relacionados']").prop('checked', (d['tiene_relacionados'] == 1) ? true : false);
        $("#editform input[name='texto_relacion']").val(d['texto_relacion']);
				$("#editform select[name='cola']").val(d['item_cola']);
				$("#editform select[name='cats']").val(d['item_tipo']);
				$("#editform select[name='unidad']").val(d['item_unidad']);
				$("#editform select[name='lavable']").val(d['item_lavable']);
				$("#editform input[name='ancho']").val(d['item_ancho']);
				$("#editform input[name='var_de']").val(d['variante_de']);
        $("#editform input[name='rel_con']").val(d['relacionado_con']);
				$("#editform input[name='largo']").val(d['item_largo']);
				$("#editform input[name='case']").val(d['item_case']);
				$("#editform input[name='case2']").val(d['item_case2']);
				$("#editform input[name='precio']").val(d['item_price']);
				$("#editform input[name='extra']").val(d['extra']);
				$("#editform input[name='orden']").val(d['orden']);
				$("#editform input[name='meta_title']").val(d['meta_title']);
				$("#editform input[name='meta_description']").val(d['meta_description']);
				$("#editform input[name='meta_keywords']").val(d['meta_keywords']);
				$("#editform input[name='stock']").val(d['stock_quantity']);
				$("#editform input[name='composicion']").val(d['composicion']);
				var nextra=(d['extra']).replace("\n","\r");
				$("#editform textarea[name='extra']").val(nextra);

        var nmeta_description=(d['meta_description']).replace("\n","\r");
        $("#editform textarea[name='meta_description']").val(nmeta_description);
				
        //  $("#editform>div").html(data);
				$("#editform input[name='imgdetalt']").val(d['imgdetalt']);
				$("#editform input[name='imgdettitle']").val(d['imgdettitle']);
				$("#editform input[name='imgambalt']").val(d['imgambalt']);
				$("#editform input[name='imgambtitle']").val(d['imgambtitle']);
			}
		});
	});
	$(".sendupdate").on('click', function(e) {
		e.preventDefault();
		var parent_form = $(this).closest('form');
		var submit_url = parent_form.attr('action');
		var $form_inputs = parent_form.find(':input');
		var form_data = {};
		$form_inputs.each(function(){
			form_data[this.name] = $(this).val();
		});
		$.ajax({
			url: submit_url,
			type: 'POST',
			data: parent_form.serialize(),
			success: function(data){
				p.html(data);
				$(".closeform").click();
			}
		});
	});
	// $(".fabr").change();
	$(".closeform").click(function(e) {
		$("#editform").hide();
	});
  /*
  $(".limpiar-filtros").click(function(e) {
    alert('limpia filtros');
  });
	*/
	$("#seleccionar_todos").on('click', function(e) {
		$(".seleccion_items").prop('checked', true);
		$(this).hide();
		$("#desmarcar_todos").show();
	});
	$("#desmarcar_todos").on('click', function(e) {
		$(".seleccion_items").prop('checked', false);
		$(this).hide();
		$("#seleccionar_todos").show();
	});
	$("#editar_seleccionados").on('click', function(e) {
    //alert($('#editform .cole').val());
		$("#edit_masivo_form").show();
	});
	$(".sendupdate_masivo").on('click', function(e) {
		e.preventDefault();
		var parent_form = $(this).closest('form');
		var submit_url = parent_form.attr('action');
		var $form_inputs = parent_form.find(':input');
		var form_data = {};
		$form_inputs.each(function(){
			form_data[this.name] = $(this).val();
		});
		
		var a_seleccionados = new Array();
		$(".seleccion_items:checked").each(function (){
			//~ valores inteiros usa-se parseInt
			a_seleccionados.push(parseInt($(this).val()));
			//~ string
			//~ checkeds.push( $(this).val());
		});
		form_data['id_seleccionados'] =a_seleccionados;

		$.ajax({
			url: submit_url,
			type: 'POST',
			data: form_data,
			success: function(data){
				p = $('.cuadro_resultados');
				p.html(data);
				$(".closeform_masivo").click();
			}
		});
	});
	$(".closeform_masivo").click(function(e) {
		$("#edit_masivo_form").hide();
	});

});

  </script>
  <script>
    function sendFileToServer(formData, status, ref, spanObj, fileObj)
    {
      var uploadURL = "<?= $includes_dir ?>grid/up000uy.php";
      var jqXHR = $.ajax({
        xhr: function() {
          var xhrobj = $.ajaxSettings.xhr();
          if (xhrobj.upload) {
            xhrobj.upload.addEventListener('progress', function(event) {
              var percent = 0;
              var position = event.loaded || event.position;
              var total = event.total;
              if (event.lengthComputable) {
                percent = Math.ceil(position / total * 100);
              }
              status.setProgress(percent);
            }, false);
          }
          return xhrobj;
        },
        url: uploadURL,
        type: "POST",
        contentType: false,
        processData: false,
        cache: false,
        data: formData,
        dataType: 'json',
        success: function(data) {
          status.setProgress(100);
          if (data && data.ok) {
            var reader = new FileReader();
            reader.onload = function(e) {
              spanObj.find('span').remove();
              spanObj.find('img').remove();
              spanObj.append('<img src="' + e.target.result + '" width="74" height="74" style="pointer-events:none"/>');
            };
            reader.readAsDataURL(fileObj);
            spanObj.css('border', '2px solid #00aa00');
          } else {
            spanObj.css('border', '2px solid red');
            alert('Error al subir: ' + (data ? data.msg : 'respuesta inesperada'));
          }
        },
        error: function(xhr) {
          if (spanObj) spanObj.css('border', '2px solid red');
          alert('Error de conexión al subir: ' + xhr.status + ' - ' + xhr.responseText);
        }
      });
      status.setAbort(jqXHR);
    }

    function sendFileToServer2(formData, status, ref, spanObj, fileObj)
    {
      var uploadURL = "<?= $includes_dir ?>grid/up001uy.php";
      var jqXHR = $.ajax({
        xhr: function() {
          var xhrobj = $.ajaxSettings.xhr();
          if (xhrobj.upload) {
            xhrobj.upload.addEventListener('progress', function(event) {
              var percent = 0;
              var position = event.loaded || event.position;
              var total = event.total;
              if (event.lengthComputable) {
                percent = Math.ceil(position / total * 100);
              }
              status.setProgress(percent);
            }, false);
          }
          return xhrobj;
        },
        url: uploadURL,
        type: "POST",
        contentType: false,
        processData: false,
        cache: false,
        data: formData,
        dataType: 'json',
        success: function(data) {
          status.setProgress(100);
          if (data && data.ok) {
            var reader = new FileReader();
            reader.onload = function(e) {
              spanObj.find('span').remove();
              spanObj.find('img').remove();
              spanObj.append('<img src="' + e.target.result + '" width="74" height="74" style="pointer-events:none"/>');
            };
            reader.readAsDataURL(fileObj);
            spanObj.css('border', '2px solid #00aa00');
          } else {
            spanObj.css('border', '2px solid red');
            alert('Error al subir: ' + (data ? data.msg : 'respuesta inesperada'));
          }
        },
        error: function(xhr) {
          if (spanObj) spanObj.css('border', '2px solid red');
          alert('Error de conexión al subir: ' + xhr.status + ' - ' + xhr.responseText);
        }
      });
      status.setAbort(jqXHR);
    }
    var rowCount = 0;
    function createStatusbar(obj)
    {
      rowCount++;
      var row = "odd";
      if (rowCount % 2 == 0)
        row = "even";
      this.statusbar = $("<div class='statusbar " + row + "'></div>");
      this.filename = $("<div class='filename'></div>").appendTo(this.statusbar);
      this.size = $("<div class='filesize'></div>").appendTo(this.statusbar);
      this.progressBar = $("<div class='progressBar'><div></div></div>").appendTo(this.statusbar);
      this.abort = $("<div class='abort'>Abort</div>").appendTo(this.statusbar);
      obj.after(this.statusbar);

      this.setFileNameSize = function(name, size)
      {
        var sizeStr = "";
        var sizeKB = size / 1024;
        if (parseInt(sizeKB) > 1024)
        {
          var sizeMB = sizeKB / 1024;
          sizeStr = sizeMB.toFixed(2) + " MB";
        }
        else
        {
          sizeStr = sizeKB.toFixed(2) + " KB";
        }

        this.filename.html(name);
        this.size.html(sizeStr);
      }
      this.setProgress = function(progress)
      {
        var progressBarWidth = progress * this.progressBar.width() / 100;
        this.progressBar.find('div').animate({width: progressBarWidth}, 10).html(progress + "% ");
        if (parseInt(progress) >= 100)
        {
          this.abort.hide();
        }
      }
      this.setAbort = function(jqxhr)
      {
        var sb = this.statusbar;
        this.abort.click(function()
        {
          jqxhr.abort();
          sb.hide();
        });
      }
    }
    function handleFileUpload(files, obj, ref)
    {
      for (var i = 0; i < files.length; i++)
      {
        var fd = new FormData();
        fd.append('file', files[i]);
        fd.append('fname', ref);

        var status = new createStatusbar(obj);
        status.setFileNameSize(files[i].name, files[i].size);
        sendFileToServer(fd, status, ref, obj, files[i]);
      }
    }
    function handleFileUpload2(files, obj, ref)
    {
      for (var i = 0; i < files.length; i++)
      {
        var fd = new FormData();
        fd.append('file', files[i]);
        fd.append('fname', ref);

        var status = new createStatusbar(obj);
        status.setFileNameSize(files[i].name, files[i].size);
        sendFileToServer2(fd, status, ref, obj, files[i]);
      }
    }
    function sP(e) {
      e.stopPropagation();
      e.preventDefault();
    }
    $(document).ready(function() {
      var obj = $(".imguploader");
      var obj2 = $(".imguploader2");
      $('.row').on('dragenter',".imguploader", function(e) {
        sP(e);
        $(this).css('border', '2px solid #0B85A1');
      });
      $('.row').on('dragover',".imguploader", function(e) {
        sP(e);
      });
      $('.row').on('drop',".imguploader", function(e) {
        $(this).css('border', '2px dotted #0B85A1');
        e.preventDefault();
        var files = e.originalEvent.dataTransfer.files;
        handleFileUpload(files, $(this), $(this).attr("ref"));
      });
      $('.row').on('dragenter',".imguploader2", function(e) {
        sP(e);
        $(this).css('border', '2px solid #0B85A1');
      });
      $('.row').on('dragover',".imguploader2", function(e) {
        sP(e);
      });
      $('.row').on('drop',".imguploader2", function(e) {
        $(this).css('border', '2px dotted #0B85A1');
        e.preventDefault();
        var files = e.originalEvent.dataTransfer.files;
        handleFileUpload2(files, $(this), $(this).attr("ref"));
      });
      $(document).on('dragenter', function(e) {
        sP(e);
      });
      $(document).on('dragover', function(e) {
        sP(e);
        obj.css('border', '2px dotted #0B85A1');
      });
      $(document).on('drop', function(e) {
        sP(e);
      });

      // Click para subir (alternativa al arrastre)
      $(document).on('click', '.imguploader, .imguploader2', function(e) {
        $(this).find('.img-file-input').trigger('click');
      });
      $(document).on('change', '.img-file-input', function(e) {
        var ref = $(this).data('ref');
        var type = parseInt($(this).data('type'));
        var files = e.target.files;
        var span = $(this).parent();
        if (files.length === 0) return;
        if (type === 1) {
          handleFileUpload(files, span, ref);
        } else {
          handleFileUpload2(files, span, ref);
        }
        $(this).val('');
      });
    });
  </script>
</body>
</html>