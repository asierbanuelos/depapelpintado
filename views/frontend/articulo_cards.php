<?php

if (!function_exists("urlenc")){
	function urlenc($str){
		$search =  explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,Á,É,Í,Ó,Ú,Ñ,!,(,)");
		$replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,ñ,,,");

		return str_replace($search,$replace,strtolower(str_replace(',','', str_replace('+','-plus-',str_replace('#','number-',str_replace('&','and',str_replace(' ','-',str_replace('/','-',rawurldecode($str)))))))));
	}
}
if (!function_exists("urldec")){
	function urldec($str){
		return str_replace('-',' ',str_replace('-plus-','+',str_replace('-and-',' & ',rawurldecode($str))));
	}
}

$datos_ga4=array();

$cont_actual=0;
$item_position=0;
foreach($all as $key){
	/*
	if (isset($_GET['test'])){
	  print '<pre><xmp>';
	  print_r($key);
	  print '</xmp></pre>';

	}
	*/
	$todo_ok=true;
	if(isset($key['stock_quantity']) && $key['stock_quantity']<=0){
		$todo_ok=false;
	}

	$item_position++;
	$cont_actual++;
	//print_r($key);

  switch ($key['item_tipo']) {
      case 0: $pre = "Papel Pintado";
              $categoria_principal='papel-pintado';
              $link_estilos='estilos-papel-pintado';
              break;
      case 1: $pre = "Mural";
              $categoria_principal='murales';
              $link_estilos='estilos-murales';
              break;
      case 2: $pre = "Revestimiento";
              $categoria_principal='revestimientos';
              $link_estilos='estilos-revestimientos';
              break;
      case 3: $pre = "Tela";
              $categoria_principal='telas';
              $link_estilos='estilos-telas';
              break;
      case 4: $pre = "Alfombra";
              $categoria_principal='alfombras';
              $link_estilos='estilos-alfombras';
              break;
      case 5: $pre = "Herramientas";
              break;
      default: break;
  }

	if($key['item_unidad']=="m2")
		$mostrarunidad="m<sup>2</sup>";
	else if($key['item_unidad']=="m lineal")
		$mostrarunidad="Metro Lineal";
	else 
		$mostrarunidad=$key['item_unidad'];

	$id_cat_seo_aux=-1;
	if (isset($categoria_seo))
		 $id_cat_seo_aux=$categoria_seo->nueva_categoria_id;
	$a_categorias_alt=explode(',', $key['usar_alt_lista']);

	$title_img=$key['meta_title'];
	$alt_img=$key['meta_title'];
	if ($key['usar_alt']==1 && (trim($key['usar_alt_lista'])=='' || in_array($id_cat_seo_aux, $a_categorias_alt))){
		if (trim($key['imgambtitle'])=='')
			$title_img=$key['meta_title'];
		if (trim($key['imgambalt'])=='')
			$alt_img=$key['meta_title'].' - 2';

		$imagen_a_usar=$key['imgamb'];
	}
	else{
		if (trim($key['imgdettitle'])=='')
			$title_img=$key['meta_title'];
		if (trim($key['imgdetalt'])=='')
			$alt_img=$key['meta_title'].' - 1';
		
		$imagen_a_usar=$key['img'];
	}

  $txt_referencia=$pre.' '.$key['item_ref'];
  $txt_fabricante='';
  $url_producto='';
  if ($key['item_tipo']!=5){
  	if (isset($key['cat_id'])){
	  	$enlace_marca='<a href="/'.$categoria_principal.'/marca/'.$key['cat_id'].'/'.urlenc($key['cat_name']).'" >'.$key['cat_name'].'</a>';
	  	$enlace_coleccion='<a href="/'.$categoria_principal.'/marca/'.$key['cat_id'].'/'.urlenc($key['cat_name']).'/'.$key['coleccion_id'].'/'.urlenc($key['coleccion_name']).'" >'.$key['coleccion_name'].'</a>';
		  //$txt_fabricante=$key['cat_name']." - ".$key['coleccion_name'];
		  $txt_fabricante=$enlace_marca." - ".$enlace_coleccion;
		  $url_producto='/'.urlenc($key['cat_name']).'/'.urlenc($key['coleccion_name']).'/'.urlenc((trim($key['item_name'])!='')?$key['item_name']:$key['item_ref']).'-'.$key['item_id'];
	  }
    $nombre_completo=$pre." - ".$key['coleccion_name']." - ".$key['item_ref'];
  }
	else{
	  $txt_fabricante=$key['item_name'];
	  $url_producto='/herramientas/'.urlenc((trim($key['item_name'])!='')?$key['item_name']:$key['item_ref']).'-'.$key['item_id'];
    $nombre_completo="Herramientas ".$key['item_name'];
	}


	$precio_original=$key['item_price'];
	$precio_final=$key['item_price'];
	$tiene_precio_aux = ($key['item_price_aux'] > 0 && $key['item_price_aux'] < $precio_original);
	if ($tiene_precio_aux){
		$precio_final=$key['item_price_aux'];
	}
	//$precio_original_txt=$key['item_price'].' €/'.$mostrarunidad;
	
	if(!isset($key['disc_value_discounted'])){
		$key['disc_value_discounted']=0;
	}
	/*
  print '<pre><xmp>';
  print_r($key);
  print '</xmp></pre>';
  exit;
	*/
	$tiene_descuento=false;
	$etiqueta_descuento='';
	if(isset($key['disc_status']) && $key['disc_status']==1 && $key['disc_type_fk']==1 && $totalcarro>=$key['disc_value_required']){//tipo de descuento
		if($key['disc_method_fk']==1){//%
			$tiene_descuento=true;
			//$precio_final=number_format(round(($key['item_price']*(100-$key['disc_value_discounted'])/100),2),2);
			//$precio_final=round(($key['item_price']*(100-$key['disc_value_discounted'])/100),2);
			/*
			$precio_final=round(($precio_final*(100-$key['disc_value_discounted'])/100),2);
			$etiqueta_descuento='<span class="etiqueta-descuento">-'.round($key['disc_value_discounted']).'%</span>';
			*/
			$precio_final=round(($precio_final*(100-$key['disc_value_discounted'])/100),2,PHP_ROUND_HALF_DOWN);
			$etiqueta_descuento='<span class="etiqueta-descuento">-'.round($key['disc_value_discounted']).'%</span>';
		}
		if($key['disc_method_fk'] && $key['disc_method_fk']==2){//%
			$tiene_descuento=true;
			//$precio_final=number_format(round(($key['item_price']-$key['disc_value_discounted']),2),2);
			//$precio_final=round(($key['item_price']-$key['disc_value_discounted']),2);
			/*
			$precio_final=round(($precio_final-$key['disc_value_discounted']),2);
			$etiqueta_descuento='<span class="etiqueta-descuento">-'.round($key['disc_value_discounted']).'€</span>';
			*/
			$precio_final=round(($precio_final-$key['disc_value_discounted']),2,PHP_ROUND_HALF_DOWN);
			$etiqueta_descuento='<span class="etiqueta-descuento">-'.round($key['disc_value_discounted']).'€</span>';
		}
	} 
	$precioMostrar=number_format($precio_final,2, '.', '');

	$lazy_load=' loading="lazy" ';
	if ($cont_actual < 4)
		$lazy_load='';

	$txt_columnas="col-6 col-md-4 col-lg-4";
	if (isset($no_hay_filtros))
		$txt_columnas="col-6 col-md-4 col-lg-4";
	?>
	<div class="articulo-block <?php echo $txt_columnas; ?>" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<meta itemprop="position" content="<?php echo $item_position; ?>" />
		<meta itemprop="name" content="<?php echo $key['meta_title']; ?>" />
		<div class="card mb-4">
			<div class="card-img" style="overflow:hidden;position:relative;">
				<?php
				if (isset($key['novedad_bool']) && $key['novedad_bool']==1)
					echo '<span class="etiqueta-novedad">Nuevo</span>';
				echo $etiqueta_descuento;
				?>
				<a itemprop="url" href="<?php echo $url_producto; ?>">
					<?php
					// Calcular segunda imagen para hover
					if ($imagen_a_usar == $key['imgamb'] && !empty($key['img']))
					  $imagen_hover = $includes_dir.str_replace('../', '', $key['img']).'med.jpg';
					elseif (!empty($key['imgamb']) && $key['imgamb'] != $imagen_a_usar)
					  $imagen_hover = $includes_dir.str_replace('../', '', $key['imgamb']).'med.jpg';
					else
					  $imagen_hover = '';
					?>
					<img <?php echo $lazy_load; ?> width="313" height="417"
					  class="card-img-top img-prefichas<?= $imagen_hover ? ' has-hover-img' : '' ?>"
					  title="<?php echo $title_img; ?>"
					  alt="<?php echo $alt_img; ?>"
					  src="<?php echo $includes_dir.str_replace('../', '', $imagen_a_usar); ?>med.jpg"
					  <?= $imagen_hover ? 'data-hover="'.htmlspecialchars($imagen_hover).'" data-src-original="'.$includes_dir.str_replace('../', '', $imagen_a_usar).'med.jpg"' : '' ?>/>
				</a>
				<?php
				if ($todo_ok) {
					if ($key['item_tipo']!=1 && $key['item_tipo']!=4 && $key['item_unidad']!="m2" && $key['tiene_variantes']!="1" && !isset($ocultar_boton)) {
					?>
					<p class="card-text text-center">
						<a data-fab="<?=(isset($key['cat_name']))?$key['cat_name']:$key['item_name']?>"
						   data-nombre-completo='<?php echo $nombre_completo; ?>'
						   data-tipo-producto='<?php echo $pre; ?>'
						   data-id-producto='<?php echo $key['item_id']; ?>'
						   data-img="<?=$includes_dir?><?=str_replace('../', '', $key['img'])?>th.jpg"
						   data-precio-original="<?=number_format($precio_original,2)?>"
						   data-precio="<?=$precioMostrar?>"
						   data-ref="<?=$key['item_ref']?>"
						   data-col="<?=(isset($key['coleccion_name']))?$key['coleccion_name']:""?>"
						   aria-label="Añadir al carrito <?php echo $txt_referencia; ?>"
						   class="add_item_via_ajax_link boton-opciones"
						   rel="nofollow"
						   href="<?=$base_url?>tienda/insert_database_item_to_cart/<?=$key['item_id']?>">
							Añadir al carrito
						</a>
					</p>
					<?php
					}
				}
				?>
			</div>
			<div class="card-body px-0">
				<h3 class="card-title"><a href="<?php echo $url_producto; ?>"><?php echo $txt_referencia; ?></a></h3>
				<p class="card-text precio">
					<?php
					if ($todo_ok) {
						if ($tiene_descuento || $tiene_precio_aux)
							echo '<strike class="tachado">'.number_format($precio_original, 2, ',', '.').' €/'.$mostrarunidad.'</strike> ';
						echo '<strong>'.number_format($precio_final, 2, ',', '.').' €/'.$mostrarunidad.'</strong>';
					}
					?>
				</p>
				<?php
				// Swatches de color por tonalidad
				if (!empty($key['tonalidades'])) {
					$tonal_colors = [
						1 => ['#1a1a1a', '#e0e0e0'],
						2 => ['#8B6847'],
						3 => ['#C9A84C'],
						4 => ['#4A7BB7'],
						5 => ['#C4778A'],
						6 => ['#6B8C5B'],
					];
					$ton_ids = array_unique(array_filter(explode(',', $key['tonalidades'])));
					if (!empty($ton_ids)) {
						echo '<div class="card-tonalidades">';
						foreach ($ton_ids as $tid) {
							$tid = (int)$tid;
							if (isset($tonal_colors[$tid])) {
								foreach ($tonal_colors[$tid] as $hex) {
									echo '<span class="tonal-dot" style="background:'.$hex.'"></span>';
								}
							}
						}
						echo '</div>';
					}
				}
				?>
			</div>
		</div>
	</div>
	<?php
	/*
	*/

	$datos_ga4[$key['item_id']]['item_name']=$nombre_completo;
	$datos_ga4[$key['item_id']]['price']=$precioMostrar;
	if (isset($key['cat_name']))
		$datos_ga4[$key['item_id']]['item_brand']=$key['cat_name'];
	$datos_ga4[$key['item_id']]['item_category']=$pre;
	//$datos_ga4[$key['item_id']]['item_category2']=$nombre_completo;
	//$datos_ga4[$key['item_id']]['item_category3']=$nombre_completo;
	//$datos_ga4[$key['item_id']]['item_category4']=$nombre_completo;
	//$datos_ga4[$key['item_id']]['item_variant']=$nombre_completo;
	//$datos_ga4[$key['item_id']]['item_list_name']=$nombre_completo;
	//$datos_ga4[$key['item_id']]['item_list_id']=$nombre_completo;
	//$datos_ga4[$key['item_id']]['index']=$nombre_completo;
	//$datos_ga4[$key['item_id']]['quantity']=$nombre_completo;

}

$nombre_listado_final='No definido';
if (isset($nombre_listado))
	$nombre_listado_final=$nombre_listado;
if (isset($texto_h1_seccion) && trim($texto_h1_seccion)!='')
	$nombre_listado_final=$texto_h1_seccion;

$id_listado_final='no_definido';
if (isset($id_listado))
	$id_listado_final=$id_listado;
elseif($nombre_listado_final!='No definido')
	$id_listado_final='listado '.$nombre_listado_final;
/*
print '<pre><xmp>';
print_r($datos_ga4);
print '</xmp></pre>';
exit;
*/
?>

<script>
	// Measure product views / impressions
	dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
	dataLayer.push({
	  event: "view_item_list",
	  ecommerce: {
	    'currencyCode': 'EUR',
	    items: [
	    <?php 
	    $index_listado=0;
	    foreach ($datos_ga4 as $idproducto => $datos_producto) {
	      echo "{ \n";
	      echo "  item_name: '{$datos_producto['item_name']}',  \n";       // Name or ID is required.
	      echo "  item_id: '$idproducto', \n";
	      echo "  price: {$datos_producto['price']}, \n";
	      if (isset($datos_producto['item_brand']))
		      echo "  item_brand: '{$datos_producto['item_brand']}', \n";
	      echo "  item_category: '{$datos_producto['item_category']}', \n";
	      //echo "  item_category2: "Mens", \n";
	      //echo "  item_category3: "Shirts", \n";
	      //echo "  item_category4: "Tshirts", \n";
	      //echo "  item_variant: "Gray", \n";
	      echo "  item_list_name: '$nombre_listado_final', \n";
	      echo "  item_list_id: '$id_listado_final', \n";
	      echo "  index: $index_listado, \n";
	      echo "  quantity: 1 \n";
	      echo "}, \n";

	      $index_listado++;
	    }
	    ?>
	    ]
	  }
	});
</script>
<script>
(function() {
  function initHover() {
    document.querySelectorAll('img.has-hover-img').forEach(function(img) {
      var hoverSrc = img.getAttribute('data-hover');
      var origSrc  = img.getAttribute('data-src-original');
      if (!hoverSrc) return;
      var loaded = false;
      img.addEventListener('mouseenter', function() {
        img.src = hoverSrc;
        loaded = true;
      });
      img.addEventListener('mouseleave', function() {
        img.src = origSrc;
      });
    });
  }
  if (document.readyState === 'loading')
    document.addEventListener('DOMContentLoaded', initHover);
  else
    initHover();
})();
</script>
