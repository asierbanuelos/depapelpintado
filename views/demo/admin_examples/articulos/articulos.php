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
<?php $this->load->view('includes/demo_header'); 
$cola=array('pared'=>'Pared','papel'=>'Papel','autoadhesivo'=>"Autoadhesivo");
  $lavab = array('0' => 'No Lavable', '1' => 'Lavable', '2'=>'Esponjable', '3'=>'SuperLavable');
    ?>
  <div class="container">
    <?=form_open('admin_library/add_art');?>
    <div style="height: 40px"></div>
    <div class="sec row"><div class="col two">Meta-Title:<br />(hasta 60 caracteres aprox.)</div><?= form_input("meta_title", "", 'class="ten"') ?></div>
    <div class="sec row"><div class="col two">Meta-Description:<br />(hasta 150 caracteres aprox.)</div><?= form_input("meta_description", "", 'class="ten" style="height:50px"') ?></div>
    <div class="sec row"><div class="col two">Meta-Keywords:</div><?= form_input("meta_keywords", "", 'class="ten"') ?></div>
    <div class="sec row"><div class="col two"><label for="google_market_be">Google Market:</label></div><div class="ten"><?= form_checkbox("google_market_be", "1", "0", 'id="google_market_be"') ?></div></div>
    <div class="sec row">
    <div class="col six t-six m-full">
      <div class="sec row">
        <div class="col six">GAMA:</div>
        <div class="col six">ESTILO:</div>
      </div>
      <div class="sec row">
        <?=form_multiselect('gama[]',$gama,'','class="col six" style="height:490px"')?>
        <?=form_multiselect('estilo[]',$estilo,'','class="col six" style="height:490px"')?>
      </div>
      <div class="sec row">
        <div class="col six">CATEGORÍAS PARA FILTROS:</div>
      </div>
      <div class="sec row">
        <?=form_multiselect('nuevas_categorias[]',$nuevas_categorias,'','class="col twelve" style="height:490px"')?>
      </div>
      <div class="sec row">Extra:<?=  form_textarea('extra','','class="col twelve" style="height:150px"')?></div>

      <div class="sec row"><div class="col six">Tiene Variantes:</div><?= form_checkbox("tiene_variantes", "1") ?></div>
      <div class="sec row"><div class="col six">Variante de:</div>
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
      <div class="sec row"><div class="col four">Economico: <?= form_checkbox("economico", "1") ?></div><div class="col four">Más Vendido: <?= form_checkbox("topventas", "1") ?></div><div class="col four">Portada: <?= form_checkbox("portada", "1") ?></div></div>
      <div class="sec row"><div class="col six">Categoría:</div><?=form_dropdown('cats',array("0"=>"Papel Pintado","1"=>"Foto Murales","2"=>"Revestimientos","3"=>"Telas","4"=>"Alfombras","5"=>"Herramientas","6"=>"Complementos"),'','class="six cathid"')?></div>

      <div class="sec row"><div class="col six">Fabricante:</div><?=form_dropdown('fab',$fab,'','class="six fabr"')?></div>
    <div class="sec row"><div class="col six">Colección:</div><?=form_dropdown('col',$col,'','class="six cole"')?></div>
    <div class="sec row"><div class="col six">Modelo:</div><?=form_dropdown('mod',$mod,'','class="six mod"')?></div>
    <div class="sec row"><div class="col six">Referencia:</div><?=  form_input("ref","",'class="six"')?></div>
    <div class="sec row"><div class="col six">Nombre:</div><?=  form_input("name","",'class="six"')?></div>
    <div class="sec row"><div class="col six">Lavable:</div><?= form_dropdown("lavable", $lavab,'', 'class="six"') ?></div>
    <div class="sec row"><div class="col six">Resistente al Sol:</div><?= form_checkbox("sol","1")?></div>
    <div class="sec row"><div class="col six">Vinilo:</div><?= form_checkbox("vinilo","1")?></div>
    <div class="sec row"><div class="col six">Encolar a:</div><?=form_dropdown('cola',$cola,'','class="six fabr"')?></div>
    <div class="sec row"><div class="col six">Ancho metros:</div><?= form_input("ancho","",'class="six"')?></div>
    <div class="sec row"><div class="col six">Largo metros:</div><?= form_input("largo","",'class="six"')?></div>
    <div class="sec row"><div class="col six">Case metros largo (ancho):</div><?= form_input("case","",'class="three"')?> <?= form_input("case2","",'class="three catshow"')?></div>
    <div class="sec row"><div class="col six">Peso:</div><?= form_input("weight","1",'class="six"')?></div>
    <div class="sec row"><div class="col six">Unidades:</div><?=form_dropdown('unidad',array("Rollo"=>"Rollo","m lineal"=>"Metro Lineal","m2"=>"Metro Cuadrado","Unidad"=>"Unidad"),'','class="six fabr"')?></div>  
    <div class="sec row"><div class="col six">Precio:</div><?= form_input("precio","",'class="six"')?></div>
    <div class="sec row"><div class="col six">Orden:</div><?= form_input("orden", "", 'class="six"') ?></div>
    <div class="sec row"><div class="col six">Stock:</div><?= form_input("stock", "", 'class="six"') ?></div>
    <div class="sec row"><div class="col six">Portada ambiente:</div><?= form_checkbox("usar_alt","0")?></div>
    <div class="sec row">
      <div class="col six">
        Categorias ambiente:<br />(sin categoría para mostrar en todas)
      </div>
      <?= form_multiselect('usar_alt_lista[]',$usar_alt_lista,'','class="six" style="height:300px;font-size:0.9em;"')?>
    </div>
    <div class="sec row catshow catshow2"><div class="col six">Composicion:</div><?= form_input("composicion", "", 'class="six"') ?></div>
    <?$uso=array('Cortinas','Tapicerias','Stores','Cojines','Cabeceros','Visillos');?>
    <div class="sec row catshow"><div class="col six">Uso Recomendado:</div><?= form_multiselect("uso[]",$uso ,'', 'class="six"') ?></div>
    </div><div class="col twelve"><div class="sec row"><div class="col six">Imágen detalle:<br>Alt:<?= form_input("imgdetalt", "" ) ?><br>Title:<?= form_input("imgdettitle", "" ) ?></div><div class="col six">Imágen ambiente:<br>Alt:<?= form_input("imgambalt", "" ) ?><br>Title:<?= form_input("imgambtitle", "" ) ?></div></div></div></div>
    
    <?=form_submit("test", "Guardar",'class="button orange-button six m-full send"')?>
    <?=form_reset("test","Resetear",'class="button orange-button six m-full"')?>
    <?=form_close();?>
<div style="height: 40px"></div>
<div class="list">   
<?

foreach ($all as $key => $value) {?>
    
     <div class="sec row">
      
       <div class="col one t-two m-three">
         <?=$value['item_ref']?><br/>
         <span style="background-color: #000;display:block;width:74px;height:74px"></span>
       </div>
       <div class="col three t-three m-three">
         <?=$value['item_name']?><br/>
         <?=$value['cat_name']?><br/>
         <?=$value['coleccion_name']?><br/>
         <?=$value['modelo_name']?><br/>
         <b>Color: </b><?=$value["color"]?><br/>
       </div>
       <div class="col two t-three m-three">
         Ancho:<?=$value['item_ancho']?><br/>
         Largo:<?=$value['item_largo']?><br/>
         Case: <?=$value['item_case']?><br/>
         <?=($value['item_lavable']==1)?"L":"l"?> - <?=($value['item_sol']==1)?"S":"s"?> - <?=($value['item_vinilo']==1)?"V":"v"?><br/>
         <b>Precio: <?=$value['item_price']?></b><br/>
       </div>
      
       <div class="col three t-three m-three">
         <div class="btn del" id="<?=$value['item_id']?>">Del</div>
       </div>
       
       
     </div>
<?}?>
   </div>
 </div>
  <?php $this->load->view('includes/scripts'); ?> 
  <script>
    function addline(d){
      var l=(d.item_lavable==1)?"L":"l";
      var s=(d.item_sol==1)?"S":"s";
      var v=(d.item_vinilo==1)?"V":"v";
      var text='<div class="sec row"><div class="col one t-two m-three"><span style="background-color: #000;display:block;width:74px;height:74px"></span></div><div class="col two t-three m-three">'+
         d.item_name+'<br/>'+d.cat_name+'<br/>'+d.coleccion_name+'<br/>'+d.modelo_name+'<br/></div><div class="col two t-three m-three">Ancho: '+d.item_ancho+'<br/>Largo: '+d.item_largo+'<br/>Case: '+d.item_case+'<br/>'+
         l+' - '+s+' - '+v+'</div><div class="col two t-three m-three"><b>Precio: '+
          d.item_price+'</b><br/></div></div>';
       $('.list').prepend(text);
      
    }
  $('.send').click(function(event){
		event.preventDefault();
    var t=$(this);
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
			success:function(data){
				addline($.parseJSON(data)[0]);
        $.ajax({
          url: "<?= site_url('admin_library/con_variantes') ?>",
          type: 'POST',
          data: t.closest('form').serialize(),
          success: function(data) {
            $('.variante_de').html(data);
          }
        });
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
    
    $(".fabr").change(function(e){
     var t=$(this);
    if($(this).val()>0){
      $.ajax({
        url:"<?=site_url('admin_library/get_col_select')?>",
        type:'POST',
        data:$(this).closest('form').serialize(),
        success:function(data){ 
          $('.cole').html(data);$('.mod').html("");
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
      })}
    });
    
    $(".cole").change(function(e){
     var t=$(this);
      if($(this).val()>0){
      $.ajax({
        url:"<?=site_url('admin_library/get_mod_select')?>",
        type:'POST',
        data:$(this).closest('form').serialize(),
        success:function(data){ 
          $('.mod').html(data);
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
      })}
    });
    $('.del').click(function(e){
    var t=$(this).attr('id');
    var p=$(this).parent().parent();
      $.ajax({
        url:"<?=site_url('admin_library/del')?>",
        type:'POST',
        data:'&t=items&n=item&i='+t,
        success:function(data){p.slideUp();}
      })
    });
    $(".fabr").change();
    
</script>
</body>
</html>