
<?$seccionbase="";
$categ=$key['item_tipo'];
switch ($categ) {
  case 0: $seccionbase="papel_pintado";   break;
  case 1: $seccionbase="murales";   break;
  case 2: $seccionbase="revestimientos";   break;
  case 3: $seccionbase="telas";   break;
  case 4: $seccionbase="alfombras";   break;
  case 5: $seccionbase="herramientas";   break;
  default:    break;
}$ant=0;$sig=0;

for($i=0;$i<count($otro);$i++){

  if($otro[$i]['item_id']==$key['item_id'] || $otro[$i]['item_id']==$key['variante_de']){
    if($i==0) $ant=$otro[(count($otro)-1)]['item_id'];
    else $ant=$otro[($i-1)]['item_id'];
    if($i==(count($otro)-1))$sig=$otro[0]['item_id'];
    else $sig=$otro[($i+1)]['item_id'];
  }
}
?>
<!--  html plano ficha-->

 <div class="units-row units-padding">
 <div class="unit-centered unit-80 cuerpocentral blancobg">

 <div class="units-row units-split end">
    <div class="unit-100 breadcrumbs" style="margin:0; padding:0;">

      <div id="inicio" class="tituloficha nomargin old-h2">
        <?php
        /*<h2 id="inicio" class="tituloficha"> */
        if(isset($migas))echo $migas;

        $url_base='https://www.depapelpintado.es/tienda';
        $a_migas=array();
        $a_migas['Inicio']=$url_base;
        $a_migas[ucwords(str_replace('_', ' ', $seccionbase))]=$url_base.'/'.$seccionbase;


        if($categ!=5){
          echo anchor("tienda/$seccionbase/marcas","Marcas")." / ";
          echo anchor("tienda/$seccionbase/marca/".$key['cat_id']."/".  urlenc($key['cat_name']),$key['cat_name']);
          $a_migas['Marcas']=$url_base.'/'.$seccionbase.'/marcas';
          $a_migas[$key['cat_name']]=$url_base.'/'.$seccionbase.'/marca/'.$key['cat_id'].'/'.urlenc($key['cat_name']);
        }
        else{
          echo anchor("tienda/herramientas","Herramientas");
          $a_migas["Herramientas"]=$url_base.'/herramientas';
        }
        ?> / 
        <?
        if($categ!=5){
          echo anchor("tienda/$seccionbase/marca/".$key['cat_id']."/".  urlenc($key['cat_name'])."/".$key['coleccion_id']."/".  urlenc($key['coleccion_name']),$key['coleccion_name']);
          $a_migas[$key['coleccion_name']]=$url_base.'/'.$seccionbase.'/marca/'.$key['cat_id']."/".  urlenc($key['cat_name'])."/".$key['coleccion_id']."/".  urlenc($key['coleccion_name']);
          $a_migas[$key['item_ref']]=$url_base.'/articulo/'.$key['cat_id']."/".  urlenc($key['cat_name'])."/".$key['coleccion_id']."/".urlenc($key['coleccion_name'])."/id/".$key["item_id"];
        }
        else{
          echo $key['item_name'];
          $a_migas[$key['item_name'].'/'.$key['item_ref']]=$url_base.'/articulo/Herramientas/'.urlenc($key['item_name'].'/id/').$key["item_id"];
        }
        ?> / 
        <?
        echo "<span class='elemento-actual'>".$key['item_ref']."</span>";
        ?>
      </div>
    </div>
    <?php
    $breadcrumbs_items=array();
    $position_miga=1;
    foreach($a_migas as $nombre_elemento_miga=>$url_miga){
      $breadcrumbs_items[]='{"@type": "ListItem","position": "'.$position_miga.'","name": "'.$nombre_elemento_miga.'","item": "'.$url_miga.'"}';
    }
    $itemListElement='['.implode(',', $breadcrumbs_items).']';
    ?>
    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "BreadcrumbList",
        "itemListElement": <?php echo $itemListElement; ?>
      }
    </script> 
 </div>
 <div class="units-row units-split end">

   <div class="unit-100" style="margin:0; padding:0;">
     <div class="unit-30">
<?
   if($categ!=5){?>
<?if(!isset($colest) || $colest==" "){?>
<a class="link_button2" style="padding:7px;text-decoration:none;" href="<?=$base_url?>tienda/articulo/<?=($categ!=5)?urlenc($key['cat_name']):"Herramientas"?>/<?=($categ!=5)? urlenc($key['coleccion_name']):strtolower(str_replace(' ','-',urlenc(preg_replace('/[^A-Za-z0-9\-]/', ' ', $key['item_name'])))) //nombre de la coleccion?>/id/<?=$ant //id del item?>"><i class="fa fa-chevron-left "></i> Anterior</a>
<a class="link_button2" style="padding:7px;text-decoration:none;" href="<?=$base_url?>tienda/articulo/<?=($categ!=5)?urlenc($key['cat_name']):"Herramientas"?>/<?=($categ!=5)? urlenc($key['coleccion_name']):strtolower(str_replace(' ','-',urlenc(preg_replace('/[^A-Za-z0-9\-]/', ' ', $key['item_name'])))) //nombre de la coleccion?>/id/<?=$sig //id del item?>">Siguiente <i class="fa fa-chevron-right "></i></a>

<?}}?></div><?if(isset($colest) && $colest!=" "){?>
<div style="text-align: right" class="unit-70"><?=$colest?>
  <button onclick="history.back(-1)" type="button" name="update" value="Volver a la tienda" class="link_button2">Volver <i class="fa fa-reply"></i></button>
 <!--  <a class="link_button2" style="padding:7px;text-decoration:none;" href="<?=$busqueda?>">Volver <i class="fa fa-reply"></i></a>--></div><?}?>
</div>
</div>

 <div class="units-row ficha end">
    <div class="unit-50">
          <?
          $t= $includes_dir.str_replace("../", "", $key['img']);
          if (trim($key['imgdettitle'])=='')
            $key['imgdettitle']=$key['meta_title'].' - 1';
          if (trim($key['imgdetalt'])=='')
            $key['imgdetalt']=$key['meta_title'].' - 1';
          /*if($categ==5){
          	$t= $includes_dir."images/cat/0/".$key['item_ref'];
          }*/
          ?>
      <div class="cajacaja maincont"  data-zoomed-image="<?=$t?>med.jpg">
           <img src="<?=$t?>med.jpg" title="<?=$key['imgdettitle']?>" alt="<?=$key['imgdetalt']?>"/>
    </div>
  </div>



  <?
  if($categ!=5){
    if (trim($key['imgambtitle'])=='')
      $key['imgambtitle']=$key['meta_title'].' - 2';
    if (trim($key['imgambalt'])=='')
      $key['imgambalt']=$key['meta_title'].' - 2';

    ?>
    <div class="unit-50">
      	<div class="cajacaja">
     			<p> <a href="<?=$includes_dir.str_replace("../", "", $key['imgamb'])?>med.jpg" rel="shadowbox">  <img class="mainimg2" title="<?=$key['imgambtitle']?>" alt="<?=$key['imgambalt']?>" src="<?=$includes_dir.str_replace("../", "", $key['imgamb'])?>med.jpg"></a></p>
     		</div>
    </div>

    <div class="unit-100">
      <!-- 	<h3> Descripción del producto </h3>-->
      <p><?=$key['col_text']?></p>
    </div>
  <?}else{?>
    <div class="unit-50">
      <p><?=$key['item_text']?></p>
    </div>
	<? } ?>




 <div class="units-row end">
   <div class="unit-50">
      <?
      if($key['item_tipo']!=5){
        $nombre_completo=$key['cat_name']." ".$key['coleccion_name']." ".$key['item_ref'];
        ?>
         <h1 style="font-size: 1.8em;color:#87074C"><?=$key['cat_name']." ".$key['coleccion_name']." ".$key['item_ref']?></h1>
        <?
        }
      else{
        $nombre_completo="Herramientas ".$key['item_name'];
        ?>
         <h1 style="font-size: 1.8em;color:#87074C"><?="Herramientas ".$key['item_name']?></h1>
        <?
      }
      ?>
 <?if ($key['item_tipo']==3){ // SI TELA?>
 <h2 class="nomargin">  Características </h2>
 <div class="estilazo">
   <ul>
     <li>Composición: <b><?=$key['composicion']?></b></li>
     <li>Uso recomendado: <b><?
     $usos=explode(" ",$key['uso']);

     $i=0;
     foreach($usos as $k){
       if($i>0)echo ', ';
       if($k==0)echo 'Cortinas';
       if($k==1)echo 'Tapicerias';
       if($k==2)echo 'Stores';
       if($k==3)echo 'Cojines';
       if($k==4)echo 'Cabeceros';
       if($k==5)echo 'Visillos';
       $i++;
     }
     ?></b></li>
     <?php if($key['item_largo']>0):?>
     <li>Largo de la pieza: <b><?=($key['item_largo'])?> cm</b></li>
     <?php endif;?>
      <?php if($key['item_ancho']>0):?>
     <li>Ancho de la pieza: <b><?=($key['item_ancho'])?> cm</b></li>
      <?php endif;?>
      <?php if($key['item_case']>0):?>
     <li>Repetición largo: <b><?=$key['item_case']?> cm</b></li>
      <?php endif;?>
      <?php if($key['item_case2']>0):?>
     <li>Repetición ancho: <b><?=number_format((float)$key['item_case2'], 2, '.', '')?> cm</b> </li>
      <?php endif;?>
     <li>Colores: <b><?=$key['color']?></b></li>
     <li>Estilos: <b><?=$key['estilo']?></b></li>
     <li>Plazo de entrega: <b><?=$key['plazo']?> días laborables<b></li>

 <?}else if ($key['item_tipo']==4){ // SI ALFOMBRA?>
 <h2 class="nomargin">  Características </h2>
 <div class="estilazo">
   <ul>
     <li>Composición: <b><?=$key['composicion']?></b></li>
     <?if ($key['item_unidad']=="Unidad"){?>
     <li>Ancho: <b><?=($key['item_ancho'])?> m</b></li>
     <li>Largo: <b><?=($key['item_largo'])?> m</b></li>
     <?}else{?>
     <li>Dimensiones: <b>A medida</b></li>
     <?}?>
     <li>Colores: <b><?=$key['color']?></b></li>
     <li>Estilos: <b><?=$key['estilo']?></b></li>
     <li>Plazo de entrega: <b><?=$key['plazo']?> días laborables<b></li>

 <?}else if ($key['item_tipo']!=5){ // SI NO ES HERRAMIENTA?>
 <h2 class="nomargin">  Características </h2>
 <div class="estilazo">
  <ul>
    <li><b><?
    switch ($key['item_lavable']){
        case 0: echo "No Lavable"; break;
        case 1: echo "Lavable"; break;
        case 2: echo "Esponjable"; break;
        case 3: echo "SuperLavable"; break;
    }
   ?></b></li>
  <li><?=($key['item_sol']==1)?"Resistencia a la luz: <b>Buena</b>":"Resistencia a la luz: <b>Suficiente</b>"?></li>
     <?=($key['item_vinilo']==1 && $key['item_tipo']==0)?"<li><b>Papel pintado vinílico</b></li>":""?>
  <?=($key['item_vinilo']==1 && $key['item_tipo']==1)?"<li><b>Mural vinílico</b></li>":""?>
  <?=($key['item_vinilo']==1 && $key['item_tipo']==2)?"<li><b>Revestimiento vinílico</b></li>":""?>
  <li><?
  switch ($key['item_cola']){
        case "papel": echo "Encolar: <b>Papel</b>"; break;
        case "pared": echo "Encolar: <b>Pared</b>"; break;
        case "autoadhesivo": echo "Autoadhesivo"; break;
    }?></li>
  <? // Si Unidades ROLLOS
  if ($key['item_unidad']=="Rollo"){?>
    <li>Ancho del rollo: <b><?=($key['item_ancho'])?> centimetros</b></li>
    <li>Largo del rollo: <b><?=($key['item_largo'])?> metros</b></li>
    <li>Case del dibujo: <b><?=($key['item_case']==0)?"No tiene case":($key['item_case']." cm")?></b></li>
  <?}
  elseif($key['item_case']!=0){?>
    <li>Case del dibujo: <b><?php echo $key['item_case']." cm"; ?></b></li>
    <?php } ?>
    <? // Si Unidades UNIDADES
  if ($key['item_unidad']=="Unidad"){?>
    <li>Ancho: <b><?=($key['item_ancho'])?> metros</b></li>
    <li>Alto: <b><?=($key['item_largo'])?> metros</b></li>
  <?}?>
    <? // Si Unidades Metros cuadrados
  if ($key['item_unidad']=="m2"){?>
    <li>Se vende por metros cuadrados</li>
  <?}?>
    <? // Si Unidades Metros cuadrados
  if ($key['item_unidad']=="m lineal"){?>
    <li>Se vende por metros lineales</li>
    <li>Ancho de la pieza: <b><?=($key['item_ancho'])?> cm</b></li>
  <?}?>
    <li>Colores: <b><?=$key['color']?></b></li>
    <li>Estilos: <b><?=$key['estilo']?></b></li>
    <li>Plazo de entrega: <b><?=$key['plazo']?> días laborables</b></li>
 <?}?>
    <?if($key['item_weight']>1){?>
      <li>Peso: <b><?=$key['item_weight']?> gr</b></li>
    <?}?>
    <?if($key['extra']!=''){ ?>
    <li><?=  str_replace("<br />", "</li><li>", nl2br($key['extra']))?></li>
    <?}?>
    <?if ($key['item_tipo']==3 && $key['limpieza']!=""){ // SI TELA?>
    <li>Limpieza:<br>
      <?

      $limp=explode(" ",$key['limpieza']);
      foreach($limp as $k){
       if($k==0)echo '<img src="'.$includes_dir.'iconos/0.jpg" alt="Limpieza en seco" title="Limpieza en seco"/>';
       if($k==1)echo '<img src="'.$includes_dir.'iconos/1.jpg" alt="Lavadora" title="Lavadora"/>';
       if($k==2)echo '<img src="'.$includes_dir.'iconos/2.jpg" alt="A mano" title="A mano"/>';
       if($k==3)echo '<img src="'.$includes_dir.'iconos/3.jpg" alt="No centrifugar" title="No centrifugar"/>';
       if($k==4)echo '<img src="'.$includes_dir.'iconos/4.jpg" alt="No secadora" title="No secadora"/>';
       if($k==5)echo '<img src="'.$includes_dir.'iconos/5.jpg" alt="Sin Lejia" title="Sin Lejia"/>';
	   if($k==6)echo '<img src="'.$includes_dir.'iconos/6.jpg" alt="Planchar a temperatura baja" title="Planchar a temperatura baja"/>';
	   if($k==7)echo '<img src="'.$includes_dir.'iconos/7.jpg" alt="Planchar a temperatura media" title="Planchar a temperatura media"/>';
	   if($k==8)echo '<img src="'.$includes_dir.'iconos/8.jpg" alt="Planchar a temperatura alta" title="Planchar a temperatura alta"/>';
	   if($k==9)echo '<img src="'.$includes_dir.'iconos/9.jpg" alt="Lavar máximo 30º" title="Lavar máximo 30º"/>';
	   if($k==10)echo '<img src="'.$includes_dir.'iconos/10.jpg" alt="Lavar máximo 40º" title="Lavar máximo 40º"/>';
	   if($k==11)echo '<img src="'.$includes_dir.'iconos/11.jpg" alt="Lavar máximo 60º" title="Lavar máximo 60º"/>';
      }
      ?>
    </li>
    <?
    }
    if ($key['item_tipo']==0){ // SI TELA?>
	    <li>Rollos de papel pintado.</li>
    <?
    }
    // 2019-04-02, opción para todos los productos
    ?>
    <li>Leer las instrucciones de colocación en la etiqueta.</li>
  </ul>

   </div>
 <?if ($key['item_tipo']!=5){ // SI NO ES HERRAMIENTA?>
   <button onclick="history.back(-1)" type="button" name="update" value="Volver a la tienda" class="link_button2">Volver <i class="fa fa-reply"></i></button>
   </div>
 <?}?>
 <div class="unit-50">

<?
if(isset($variantes) && count($variantes)>1){
?>
	<div style="padding-bottom: 30px;">
		<h3 class="magenta-secundario destacado">Otras medidas:</h3>
		<select onchange="self.location='<?=base_url()."tienda/articulo/".$this->uri->segment(3)."/".$this->uri->segment(4)."/id/"?>'+this.options[this.selectedIndex].value;">
			<?foreach($variantes as $item){?>
			<option <?if($item['item_id']==$key['item_id'])echo 'selected="selected"';?> value="<?=$item['item_id']?>"><?=$item['item_ref'].": dimensiones (alto x ancho): ".$item['item_largo']."x".$item['item_ancho']?></option>
			<?}?>
		</select>
	</div>
<?
}

//CALCULADORA DE ROLLOS

    if(($categ==0 || $categ==2) && $key['item_unidad']!="Unidad" ){?>
   <h3>Calculadora de rollos <?if($categ==0) echo "de papel pintado"; else echo "de revestimientos"?>:</h3>
    <p>Introduce las dimensiones a cubrir en metros, ej: 3.8</p>
   <p><input type="text" class="calcuinput" id="paredancho" value="" placeholder="Ancho Pared en metros"/>
<input type="text" class="calcuinput" id="paredalto" value="" placeholder="Alto Pared en metros"/>
<button onclick="calcular();">Calcular</button>
<input type="hidden" id="p_ancho" name="p_ancho" value="<?=$key['item_ancho']?>"/>
<input type="hidden" id="p_alto" name="p_alto" value="<?=$key['item_largo']?>"/>
<input type="hidden" id="case" name="case" value="<?=$key['item_case']?>"/>
<input type="hidden" id="ud" name="ud" value="<?=$key['item_unidad']?>"/></p>

<div id="rescalcu"> </div>

<?
} // FIN CALCULADORA

if($key['item_unidad']=='m2'){?>
	<h3>Dimensiones:</h3>
	<p>Introduce las dimensiones necesarias en metros, ej: 3.8 x 2.5</p>
	<p >
		<input type="text" class="metrs calcuinput" placeholder="Ancho en metros" value="" id="p_ancho" name="p_ancho" >
		<input type="text" class="metrs calcuinput" placeholder="Alto en metros" value="" id="p_alto" name="p_alto" ><button id="calculaboton">Calcular</button>
	</p>

<?
}
if($key['item_unidad']=='m2' || $key['item_unidad']=='m lineal'){?>
	<div>*Las medidas introducidas se ajustarán automáticamente a las exigencias del fabricante. Consultanos otras opciones</div>
<?
}
if(isset($key['stock_quantity']) && $key['stock_quantity']<5){?>
	<div style="color: #3c3; font-size:25px; margin-bottom: 5px" ><span>Últimas unidades</span></div>
<?
}
else if(isset($key['stock_quantity']) && $key['stock_quantity']<100){?>
	<div style="color: #3c3; font-size:25px; margin-bottom: 5px" ><span>Unidades limitadas</span></div>
<?
}
?>
<p class="unidades">
	Unidades:
	<input type="text" id="unidades" name="unidades" value="1" />
	<input type="hidden" id="ud" name="ud" value="<?=$key['item_unidad']?>"/> <?=($key['item_unidad']=='m2')?"":$key['item_unidad']?>
</p>



<p class="precio magenta-secundario"><b>Precio: </b>
<?
$precio=$key['item_price'];
// print_r($key);
if($key['item_unidad']=="m2") $mostrarunidad="m<sup>2</sup>";
else if($key['item_unidad']=="m lineal") $mostrarunidad="Metro Lineal";
else $mostrarunidad=$key['item_unidad'];

$preciobase=$precio;
$preal=$key['item_price'];
if($key['item_economico']){
	$precio='<span style="font-size:18px;color:#AE0058"><strong>'.$precio.' €/'.$mostrarunidad.'</strong></span>';
}

if(isset($key['disc_status']) && $key['disc_status']==1 && $key['disc_type_fk']==1 && $totalcarro>=$key['disc_value_required']){//tipo de descuento
	if($key['disc_method_fk']==1){//%
		$preal=($key['item_price']*(100-$key['disc_value_discounted'])/100);
		$precio='<span><strike><span id="pb">'.$key['item_price'].'</span> €/'.$mostrarunidad.'</strike></span><br><span style="font-size:18px;color:#AE0058"><strong>'.number_format(round($preal,2),2).' €/'.$mostrarunidad.'</strong>';
	}
	else if($key['disc_status']==1 && $key['disc_method_fk']==2 && $totalcarro>=$key['disc_value_required']){//%
		$preal=($key['item_price']-$key['disc_value_discounted']);
		$precio='<span><strike>'.$key['item_price'].' €/'.$key['item_unidad'].'</strike></span><br><span style="font-size:18px;color:#AE0058"><strong>'.number_format(round($preal,2),2).' €/'.$key['item_unidad'].'</strong>';
	}
}
elseif(!$key['item_economico']){
	$precio=$precio.' €/'.$mostrarunidad;
}

echo '<b>'.$precio.'</b>';

?>
<div class="precio magenta-secundario" style="display:none" id="importe">Importe: <span><?=$precio?></span></div>

<div class="contacto-promociones-especiales magenta-secundario" id="contacto-promociones-especiales">
	<p>
		Promociones especiales<br />
		Llámanos: <a rel="nofollow" target="_blank" href="tel:944056616"><strong>94 405 66 16</strong></a>
	</p>
</div>

</p>

<p class="carroficha">
<input type="hidden" id="preciobase" name="pb" value="<?=$preciobase?>"/>
 <input type="hidden" id="preciobase" name="pb" value="<?=$preciobase?>"/>
  <input type="hidden" id="preciounitario" name="pu" value="<?=$preal?>"/>
  <input type="hidden" id="fab" name="fab" value="<?=(isset($key['cat_name']))?$key['cat_name']:$key['item_name']?>"/>
  <input type="hidden" id="col" name="col" value="<?=(isset($key['coleccion_name']))?$key['coleccion_name']:""?>"/>
  <input type="hidden" id="itemid" name="itemid" value="<?=$key['item_id']?>"/>
  <input type="hidden" id="ancho_para_calculo" name="ancho_para_calculo" value="<?$key['item_ancho']; ?>"/>
  <input type="hidden" id="alto_para_calculo" name="alto_para_calculo" value="<?=$key['item_largo']; ?>"/>
 <?if(false/*$key['item_tipo']==0*/){?> <input type="button" class="addformsample" name="addformsample" value="Solicitar Muestra"/> <?}?>
  <button class="addformitem" name="addform" value="Añadir al carro"/>Añadir al carro <i class="fa fa-shopping-cart"></i></button>
</p>

<?if(false/*$key['item_tipo']==0*/){echo anchor ("informacion_muestras_papel_pintado","Política de muestras");}?>
 </div>
  <?if ($key['item_tipo']==5){ // SI NO ES HERRAMIENTA?>
   <button onclick="history.back(-1)" type="button" name="update" value="Volver a la tienda" class="link_button2">Volver <i class="fa fa-reply"></i></button>

 <?
  }?>
   </div>

   <div class="units-row end">
   <div class="unit-100">
     <?php if($key['item_tipo']!=5) $this->load->view('frontend/otrosarticulos'); ?>
   </div>

 </div>
 </div>
    </div>
<script>
  function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}
var importeval=0;
document.getElementById('inicio').scrollIntoView();
  $(document).ready(function(){
 Shadowbox.init({
    handleOversize: "resize",
});

  $('.maincont').zoomy({innerZoom:true,magnify:1.2, lensHeight: 285,
  lensWidth: 285});
$('.metrs').change(function(){
  CalculaMetros();
});
$('#unidades').change(function(){
  CalculaMetros();
});
$('#calculaboton').click(function(){
  CalculaMetros();
});
function CalculaMetros(){
	if(isNumeric($("#p_ancho").val()) && isNumeric($("#p_alto").val())&& isNumeric($("#unidades").val())){
		var cm=0;
		var dec=parseFloat($("#p_ancho").val());
		var alt=parseFloat($("#p_alto").val());;
		<?if($key['item_unidad']=="m2" && $key['item_ancho']!=0){?>
			dec=Math.ceil(parseFloat($("#p_ancho").val())/<?=$key['item_ancho']?>)*<?=$key['item_ancho']?>;
		<?}?>
		<?if($key['item_unidad']=="m2" && $key['item_largo']!=0){?>
			alt=Math.ceil(parseFloat($("#p_alto").val())/<?=$key['item_largo']?>)*<?=$key['item_largo']?>;
		<?}?>
		<?if(isset($key['fabmargen']) && $key['item_unidad']=="m2" && $key['fabmargen']!=0){?>
			alt+=<?=$key['fabmargen']?>;
		<?}?>

		console.log("dec"+dec+" alt:"+alt);
		//~ alert($("#ancho_para_calculo").val());
		//~ alert($("#alto_para_calculo").val());
		$("#ancho_para_calculo").val(dec);
		$("#alto_para_calculo").val(alt);
		//~ alert($("#ancho_para_calculo").val());
		//~ alert($("#alto_para_calculo").val());

		cm=dec*alt;
		if (cm<0)cm*=-1;
		<?if($key['item_unidad']=="m2"){?>
			if(cm.toFixed(2)<1) DisplayImporte(parseFloat(<?=$preal?>)*parseFloat($("#unidades").val()));
		<?}else{?>
			if(cm.toFixed(2)-<?=($key['item_ancho']*$key['item_largo'])?><Math.abs(0.001)) DisplayImporte(parseFloat(<?=$preal?>)*parseFloat($("#unidades").val()));
		<?}?>
		else
			DisplayImporte(cm*parseFloat(<?=$preal?>)*parseFloat($("#unidades").val()));
	}
	else if(isNumeric($("#unidades").val())){
		DisplayImporte(parseFloat(<?=$preal?>)*parseFloat($("#unidades").val()));
	}
	else DisplayImporte(0);
}

var esmuestra=false;
function DisplayImporte(valor){
  if (valor==0){
    $("#importe").hide();
  }
  else{
	//~ 2017-06-06, no mostrar el importe al final
	//~ $("#importe").show();
	$("#importe>span").html(valor.toFixed(2)+" €");
	importeval=valor.toFixed(2)+" €";
  }
}
    $(".calcuinput").change(function(e){
      $(this).val($(this).val().replace(",","."));
      <?if($categ==3 || $categ==4){?>
            $(this).val(Math.ceil($(this).val()*10)/10);
      <?}?>
    });

    $("#unidades").change(function(e){
         <?if($categ==3 || $categ==4){?>
            $(this).val($(this).val().replace(",","."));
            $(this).val(Math.ceil($(this).val()*10)/10);
         <?}if($key['item_unidad']!="m lineal"){?>
             $(this).val(Math.ceil($(this).val()));
         <?}?>
    });


  $('.jsCarousel').jsCarousel({  autoscroll: true, masked:false,itemstodisplay:8 });
	$(".addformitem").click(function(event){
		event.preventDefault();
		if ($("#unidades").val()<1){
			alert ('Pedido mínimo de 1 unidad');
			return;
		}
		CalculaMetros();
		<?if($key['item_unidad']=='m2'){?>
			if(!isNumeric($("#p_ancho").val())||!isNumeric($("#p_alto").val())){
				alert ('valores no validos');
				return;
			}
		<?}?>
		$.ajax({
			url: "<?php echo $base_url; ?>tienda/insert_database_item_to_cart/"+$("#itemid").val() ,
			type: 'POST',
			//~ data: { 'qty': $("#unidades").val(),'p_ancho':$("#p_ancho").val(),'p_alto':$("#p_alto").val(),'ud':$("#ud").val(),'fab':$("#fab").val(),'col':$("#col").val()},
			//~ data: { 'qty': $("#unidades").val(),'p_ancho':$("#ancho_para_calculo").val(),'p_alto':$("#alto_para_calculo").val(),'ud':$("#ud").val(),'fab':$("#fab").val(),'col':$("#col").val()},
			data: { 'qty': $("#unidades").val(),'p_ancho':$("#ancho_para_calculo").val(),'p_alto':$("#alto_para_calculo").val(),'p_ancho_solicitado':$("#p_ancho").val(),'p_alto_solicitado':$("#p_alto").val(),'ud':$("#ud").val(),'fab':$("#fab").val(),'col':$("#col").val()},
			success: function(data)
			{
				ajax_update_mini_cart(data,false);
			}
		});
	});

    $(".addformsample").click(function(event){
      event.preventDefault();

      $.ajax({
        url: "<?php echo $base_url; ?>tienda/insert_database_item_to_cart/"+$("#itemid").val() ,
        type: 'POST',
        data: { 'sample': 1,'fab':$("#fab").val(),'col':$("#col").val()},
        success: function(data)
        {
          ajax_update_mini_cart(data,true);
        }
      });
    });
  });
   var categ =<?=$key['item_tipo']?>;
   var uds="<?=($key['item_unidad']=="m lineal")?"Metros lineal(es)":"Rollo(s)"?>"
   var paredancho= parseFloat($("#paredancho").val());
   var paredalto= parseFloat($("#paredalto").val());
function calcular(){


      var calcu=false;
        if (categ==1){
          alert("Calculadora no disponible para murales")
        }
        else if (categ<3){
          if (!isNumeric($("#paredancho").val())||!isNumeric($("#paredalto").val())){
            $("#rescalcu").html("<div style=\"font-size: 16px;\">Los valores introducidos no son validos</div>");
            return;
          }
          paredancho= parseFloat($("#paredancho").val());
          paredalto= parseFloat($("#paredalto").val());
          $("#rescalcu").html("<div style=\"font-size: 16px;\"><b><font>"+ calcula()+ " "+uds+"</font></b>* Los resultados son aproximados</div>");
          calcu=true;
        }
        else{
          alert("Calculadora no disponible para estos articulos");
        }

      }
      function calcula(){
        var ancho = parseFloat($("#p_ancho").val())/100;
         var rollo = parseFloat($("#p_alto").val());
         var caser = parseFloat($("#case").val())/100;
        return calcuval(ancho,rollo,caser);
      }
      function calcuval(ancho,rollo,caser){
        var segmentos=Math.ceil(paredancho/ancho);
        if(categ==0){

         if(caser>0.005){
          var tiracase=paredalto%caser;
          var tirafinal=paredalto+caser-tiracase;
         }
         else var tirafinal=paredalto;
         var rollofinal=(rollo/tirafinal>1)?Math.floor(rollo/tirafinal):1/Math.floor(tirafinal/rollo);

         return Math.ceil(segmentos/rollofinal);
        }
        if(categ==2){
           var segmentos=Math.ceil(paredancho/ancho);
            if(caser>0.005){
              var tiracase=paredalto%caser;
              var tirafinal=paredalto+caser-tiracase;
             }
            else var tirafinal=paredalto;

            return Math.ceil(tirafinal*segmentos);
        }
      }
      function ajax_update_mini_cart(data,esmuestra) {
        var ajax_mini_cart = $(data).find('.ulcarro>.status');
        var importe =$(data).find('.precio-minicarro').html();
        $('.ulcarro>.status').replaceWith(ajax_mini_cart);
        $('.precio-minicarro').replaceWith(importe);
       <?if(isset($key['stock_quantity'])){?>
        if(!esmuestra && parseFloat($("#unidades").val())>parseFloat(<?=$key['stock_quantity']?>)){
          alert("No es posible añadir todos los artículos al carro, solo quedan <?=$key['stock_quantity']?> unidades");
          importeval=(<?=$preal?>*parseFloat(<?=$key['stock_quantity']?>)).toFixed(2)+" €";
          }
       <?}?>
      if(esmuestra)  $( "#importevalor").html("2 €");
      else  $( "#importevalor").html(importeval);

         $( "#dialog-confirm" ).dialog({
resizable: false,
height:240,
width:500,
modal: true,
buttons: {
"Continuar en la tienda": function() {
$( this ).dialog( "close" );
},
"Ir al carro": function() {
$( this ).dialog( "close" );
window.location="<?=$base_url?>tienda/carrito";
}
}
});
        //confirm("El carro se ha actualizado.");

      }
</script>
<div style="display:none" id="dialog-confirm" title="Se ha añadido el artículo">
  <p><span><img style="width:60px; margin-right:10px;" src="<?=$t?>th.jpg" alt='<?php echo $key['imgdetalt']; ?> - th' title='<?php echo $key['imgdettitle']; ?> - th' /> <?=(isset($key['cat_name']))?$key['cat_name']:$key['item_name']?> - <?=(isset($key['coleccion_name']))?$key['coleccion_name']:""?> - <?=$key['item_ref']?> : <span id="importevalor"></span></span></p>
</div>

<script>
// Measure a view of product details. This example assumes the detail view occurs on pageload,
// and also tracks a standard pageview of the details page.
dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
dataLayer.push({
  'ecommerce': {
    'detail': {
      'products': [{
        'name': '<?php echo $nombre_completo; ?>',         // Name or ID is required.
        'id': '<?php echo $key['item_id']; ?>',
        'price': '<?php echo number_format(round($preal,2),2); ?>',
        'brand': '<?php echo $key['cat_name']; ?>',
        'category': '<?php echo ucwords(str_replace('_', ' ', $seccionbase)); ?>',
       }]
     }
   }
});
</script>

