  <?
  

  if (!function_exists("urlenc")){
    function urlenc($str){
        $search =  explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,Á,É,Í,Ó,Ú,Ñ,!,(,)");
        $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,ñ,,,");

        return str_replace($search,$replace,strtolower(str_replace(',','', str_replace('+','-plus-',str_replace('#','number-',str_replace('&','and',str_replace(' ','-',rawurldecode($str))))))));
    }
  }
  if (!function_exists("urldec")){
    function urldec($str){
        return str_replace('-',' ',str_replace('-plus-','+',str_replace('-and-',' & ',rawurldecode($str))));
    }
  }
 $count=0;
 $item_position=0;
 foreach($all as $key){
	 $item_position++;
		//print_r($key);
		$pre="";
		if($key['item_tipo']==0)$pre="Papel pintado ";
		else if($key['item_tipo']==1)$pre="Fotomural ";
		else if($key['item_tipo']==2)$pre="Revestimento ";
		else if($key['item_tipo']==3)$pre="Tela ";
		else if($key['item_tipo']==4)$pre="Alfombra ";

		if($key['item_unidad']=="m2")$mostrarunidad="m<sup>2</sup>";
		else if($key['item_unidad']=="m lineal")$mostrarunidad="Metro Lineal";
		else $mostrarunidad=$key['item_unidad']?>
		
		<li itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
      <meta itemprop="position" content="<?php echo $item_position; ?>" />
      <meta itemprop="name" content="<?php echo $key['meta_title']; ?>" />

    <?//Datos a mostrar?>
    <div class="preficha <?php if($key['item_tipo']==0) echo "prefpapel";?>  <?php if ($key['usar_alt']==1){echo "border";} ?>" style="overflow:hidden" >
<?if(false){?>    
        <div style="position:absolute;left:0px;bottom:65px;z-index: 1000; width:100%;"><img class="siniva" src="<?=$includes_dir?>images/etiqueta-sin-iva.png"></div>
<?}?>
      <?php if(isset($key['novedad_bool']) && $key['novedad_bool']==1):
	/*?>
	 <div style="position:absolute;top:0px;z-index: 1000;width:90px"><img class="novedad" alt="novedad" src="<?=$includes_dir?>images/novedad_izq.png"></div>      
	*/
	?>	
	 <div style="position:absolute;top:0px;right:0;z-index: 1000;width:90px"><img class="novedad" alt="novedad" src="<?=$includes_dir?>images/novedad_der.png"></div>      
	 <?php endif;?>
      <?
      
	if(isset($key['disc_resumen']) && $key['disc_resumen']!="" && $key['disc_status']==1 && $totalcarro>=$key['disc_value_required']){
	?>
		<div style="position:absolute;right:0px;top:0px;z-index: 1000;width:100px"><img src="<?=$includes_dir?>images/descuentob.png"></div>
		<div style="position:absolute;right:5px;top:0px;z-index: 1001;width:85px;height:75px;text-align: center;color: #fff;font-weight: bold;padding-top:23px;font-size: 20px;"><?=$key['disc_resumen']?></div>
	<?
	}
	//~ 2018-02-15 Quitamos el aiso del descuento pocentual
	/*
	if(isset($key['disc_resumen']) && $key['disc_resumen']=="" && $key['disc_status']==1 && $key['disc_method_fk']==1 && $totalcarro>=$key['disc_value_required']){
	?>
		<div style="position:absolute;right:0px;top:0px;z-index: 1000;width:75px"><img src="<?=$includes_dir?>images/descuento.png"></div>
		<?
		if(false){
		?> 
			<div style="position:absolute;right:0px;top:0px;z-index: 1001;width:75px;height:75px;text-align: center;color: #fff;font-weight: bold;padding-top:20px;font-size: 10px;">Descuento</div><div style="position:absolute;right:0px;top:0px;z-index: 1001;width:75px;height:75px;text-align: center;color: #fff;font-weight: bold;padding-top:38px;font-size: 20px;"><?=  number_format($key['disc_value_discounted'])?>%</div>
		<?
		}
		else{
			?>
			<div style="position:absolute;right:2px;top:0px;z-index: 1001;width:75px;height:75px;text-align: center;color: #fff;font-weight: bold;padding-top:25px;font-size: 20px;">-<?=  number_format($key['disc_value_discounted'])?>%</div>
			<?
		}
	}
	*/
	if(isset($key['disc_resumen']) && $key['disc_resumen']=="" && $key['disc_status']==1 && $key['disc_method_fk']==2 && $totalcarro>=$key['disc_value_required']){
		?>
			<div style="position:absolute;right:0px;top:0px;z-index: 1000;width:75px"><img src="<?=$includes_dir?>images/descuento.png"></div>
		<?
		if(false){
			?>
			<div style="position:absolute;right:0px;top:0px;z-index: 1001;width:75px;height:75px;text-align: center;color: #fff;font-weight: bold;padding-top:20px;font-size: 10px;">Descuento</div><div style="position:absolute;right:0px;top:0px;z-index: 1001;width:75px;height:75px;text-align: center;color: #fff;font-weight: bold;padding-top:38px;font-size: 20px;">-<?=  number_format($key['disc_value_discounted'])?>€</div>
		<?
		}
		else{
		?>
			<div style="position:absolute;right:2px;top:0px;z-index: 1001;width:75px;height:75px;text-align: center;color: #fff;font-weight: bold;padding-top:25px;font-size: 20px;">-<?=  number_format($key['disc_value_discounted'])?>€</div>
		<?
		}
	}
	?>

      <a itemprop='url' href="<?=$base_url?>tienda/articulo/<?=($categ!=5)? urlenc($key['cat_name']):"Herramientas"?>/<?=($categ!=5)? urlenc($key['coleccion_name']):  urlenc(strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $key['item_name']))) //nombre de la coleccion?>/id/<?=$key['item_id'] //id del item?>">
      <?php 
      if ($key['usar_alt']==1){
        if (trim($key['imgambtitle'])=='')
          $key['imgambtitle']=$key['meta_title'];
        if (trim($key['imgambalt'])=='')
          $key['imgambalt']=$key['meta_title'].' - 2';
				?>
				<img loading="lazy" class="img-prefichas" title="<?=$key['imgambtitle']?>" alt="<?=$key['imgambalt']?>" src="<?=$includes_dir?><?=str_replace("../", "", $key['imgamb']) //imagen del articulo?>th.jpg"/> 
				<?php 
    	}else{
        if (trim($key['imgdettitle'])=='')
          $key['imgdettitle']=$key['meta_title'];
        if (trim($key['imgdetalt'])=='')
          $key['imgdetalt']=$key['meta_title'].' - 1';
				?>
				<img loading="lazy" class="img-prefichas" title="<?=$key['imgdettitle']?>" alt="<?=$key['imgdetalt']?>" src="<?=$includes_dir?><?=str_replace("../", "", $key['img']) //imagen del articulo?>th.jpg"/>
				<?php 
			}?></a></div>
    <div style="height:125px;overflow:hidden;padding-top: 5px;">
  <?//=$key['item_id'] //id del item?>

  <?='<span style="font-size:14px;"><strong>'.$pre.$key['item_ref'].'</strong></span>'; //referencia?><br>
  
  
  <?=($categ!=5)?$key['cat_name']." - ":"" //nombre del fabricante?> 
  
  <?=($categ!=5)?$key['coleccion_name']:$key['item_name'] //nombre de la coleccion?><br>
  


<?
$precio='<span style="font-size:16px;color:#000"><strong>'.$key['item_price'].' €/'.$mostrarunidad.'</strong></span>';
if(!isset($key['disc_value_discounted'])){
	$key['disc_value_discounted']=0;
}
$precioMostrar=number_format(round(($key['item_price']*(100-$key['disc_value_discounted'])/100),2),2);
if(isset($key['item_economico']) && $key['item_economico']){
	//~ $precio='<span style="font-size:18px;color:#AE0058"><strong>'.$precio.'</strong></span>';
	$precio='<span style="font-size:18px;color:#000"><strong>'.$precio.'</strong></span>';
}
if(isset($key['disc_status']) && $key['disc_status']==1 && $key['disc_type_fk']==1 && $totalcarro>=$key['disc_value_required']){//tipo de descuento
	if($key['disc_method_fk']==1){//%
		//~ $precio='<span><strike>'.$key['item_price'].' €/'.$mostrarunidad.'</strike></span><br><span style="font-size:18px;color:#AE0058"><strong>'.number_format(round(($key['item_price']*(100-$key['disc_value_discounted'])/100),2),2).' €/'.$mostrarunidad.'</strong>';
		$precio='<span><strike>'.$key['item_price'].' €/'.$mostrarunidad.'</strike></span><br><span style="font-size:18px;color:#000"><strong>'.number_format(round(($key['item_price']*(100-$key['disc_value_discounted'])/100),2),2).' €/'.$mostrarunidad.'</strong>';
	}
	if($key['disc_method_fk'] && $key['disc_method_fk']==2){//%
		//~ $precio='<span><strike>'.$key['item_price'].' €/'.$mostrarunidad.'</strike></span><br><span style="font-size:18px;color:#AE0058"><strong>'.number_format(round(($key['item_price']-$key['disc_value_discounted']),2),2).' €/'.$mostrarunidad.'</strong>';
		$precio='<span><strike>'.$key['item_price'].' €/'.$mostrarunidad.'</strike></span><br><span style="font-size:18px;color:#000"><strong>'.number_format(round(($key['item_price']-$key['disc_value_discounted']),2),2).' €/'.$mostrarunidad.'</strong>';
	}
} 
echo $precio;
?>

 
  <?if($key['item_unidad']!="m2" && $key['tiene_variantes']!="1"){?><span class="right"><a data-fab="<?=(isset($key['cat_name']))?$key['cat_name']:$key['item_name']?>" data-img="<?=$includes_dir?><?=str_replace("../", "", $key['img']) //imagen del articulo?>th.jpg" data-precio="<?=$precioMostrar?>" data-ref="<?=$key['item_ref']?>" data-col="<?=(isset($key['coleccion_name']))?$key['coleccion_name']:""?>" class="add_item_via_ajax_link" href="<?=$base_url; ?>tienda/insert_database_item_to_cart/<?=$key['item_id']?>">
      
      <img class="carroadd" title="Añadir al carro" alt="Añadir al carro" src="<?=$includes_dir?>images/carroadd.png" width='30' height='25' loading="lazy" />
    
    </a> &nbsp; </span>
 
  <?}
//Datos para calcular / formatos especiales?>
  <?if($key['item_economico']){} //si esta marcado como economico (0/1)?>
  
  <?if($key['item_top']){} //los mas vendidos (0/1)?>
  
  <?// DESCUENTOS Y MOSTRAR PRECIO REAL DE ESTO ME ENCARGO?>
  
  </div>
  </li>
 <?}?>
