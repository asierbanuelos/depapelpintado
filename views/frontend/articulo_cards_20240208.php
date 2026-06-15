<?php
$todo_ok=true;

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

$datos_ga4=array();

$cont_actual=0;
$item_position=0;
foreach($all as $key){
	$item_position++;
	$cont_actual++;
	//print_r($key);

  switch ($key['item_tipo']) {
      case 0: $pre = "Papel Pintado";
              $categoria_principal='tienda/papel_pintado';
              $link_estilos='estilos-papel-pintado';
              break;
      case 1: $pre = "Fotomural";
              $categoria_principal='tienda/fotomurales';
              $link_estilos='estilos-fotomurales';
              break;
      case 2: $pre = "Revestimiento";
              $categoria_principal='tienda/revestimientos';
              $link_estilos='estilos-revestimientos';
              break;
      case 3: $pre = "Tela";
              $categoria_principal='tienda/telas';
              $link_estilos='estilos-telas';
              break;
      case 4: $pre = "Alfombra";
              $categoria_principal='tienda/alfombras';
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
		  $url_producto='/tienda/articulo/'.urlenc($key['cat_name']).'/'.urlenc($key['coleccion_name']).'/id/'.$key['item_id'];
	  }
    $nombre_completo=$pre." - ".$key['coleccion_name']." - ".$key['item_ref'];
  }
	else{
	  $txt_fabricante=$key['item_name'];
	  $url_producto='/tienda/articulo/herramientas/'.urlenc(strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $key['item_name']))).'/id/'.$key['item_id'];
    $nombre_completo="Herramientas ".$key['item_name'];
	}


	$precio_original=$key['item_price'];
	$precio_final=$key['item_price'];
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
			$precio_final=round(($key['item_price']*(100-$key['disc_value_discounted'])/100),2);
			$etiqueta_descuento='<span class="etiqueta-descuento">-'.round($key['disc_value_discounted']).'%</span>';
		}
		if($key['disc_method_fk'] && $key['disc_method_fk']==2){//%
			$tiene_descuento=true;
			//$precio_final=number_format(round(($key['item_price']-$key['disc_value_discounted']),2),2);
			$precio_final=round(($key['item_price']-$key['disc_value_discounted']),2);
			$etiqueta_descuento='<span class="etiqueta-descuento">-'.round($key['disc_value_discounted']).'€</span>';
		}
	} 
	$precioMostrar=number_format($precio_final,2, '.', '');

	$lazy_load=' loading="lazy" ';
	if ($cont_actual < 4)
		$lazy_load='';

	$txt_columnas="col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12 col-sp-12";
	if (isset($no_hay_filtros))
		$txt_columnas="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 col-sp-12";
	?>
	<div class="articulo-block <?php echo $txt_columnas; ?>" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem">
		<meta itemprop="position" content="<?php echo $item_position; ?>" />
		<meta itemprop="name" content="<?php echo $key['meta_title']; ?>" />
		<div class="card mb-4">
			<div class="card-img" style="overflow:hidden">
				<?php 
				if(isset($key['novedad_bool']) && $key['novedad_bool']==1)
					echo '<span class="etiqueta-novedad">Nuevo</span>';
				
				echo $etiqueta_descuento; 
				?>
				<a itemprop="url" href="<?php echo $url_producto; ?>">
					<img <?php echo $lazy_load; ?> heigth="313.75" width="313.75" class=" card-img-top img-prefichas" title="<?php echo $title_img;?>" alt="<?php echo $alt_img;?>" src="<?php echo $includes_dir.str_replace("../", "", $imagen_a_usar);?>th.jpg"/>
				</a>
			</div>			
			<div class="card-body px-0">
				<p class="card-text fabricante text-center"><?php echo $txt_fabricante; ?></p>
				<h3 class="card-title text-center"><a href="<?php echo $url_producto; ?>"><?php echo $txt_referencia; ?></a></h3>
				<p class="card-text precio text-center">
					<?php 
					if ($todo_ok){
						if ($tiene_descuento)
							echo '<strike class="tachado">'.number_format($precio_original, 2, ',', '.').' €/'.$mostrarunidad.'</strike><br />';
						
						echo '<strong>'.number_format($precio_final, 2, ',', '.').' €/'.$mostrarunidad.'</strong>';
					}	
					//echo '<strong>'.$precio_final .' €/'.$mostrarunidad.'</strong>';
					
					/*
					if(isset($key['item_economico']) && $key['item_economico']){
						$precio='<span style="font-size:18px;color:#000"> ojo economino <strong>'.$precio.'</strong></span>';
					}
					*/
					?>
				</p>
				<?php
				if ($todo_ok){
					if($key['item_tipo']!=1 && $key['item_tipo']!=4 && $key['item_unidad']!="m2" && $key['tiene_variantes']!="1" && !isset($ocultar_boton)){
					?>
						<p class="text-center">
							<a 	data-fab="<?=(isset($key['cat_name']))?$key['cat_name']:$key['item_name']?>" 
				  				data-nombre-completo='<?php echo $nombre_completo; ?>' 
				  				data-tipo-producto='<?php echo $pre; ?>' 
				  				data-id-producto='<?php echo $key['item_id']; ?>' 
									data-img="<?=$includes_dir?><?=str_replace("../", "", $key['img']) //imagen del articulo?>th.jpg" 
									data-precio-original="<?echo number_format($precio_original,2);?>" 
									data-precio="<?=$precioMostrar?>" 
									data-ref="<?=$key['item_ref']?>" 
									data-col="<?=(isset($key['coleccion_name']))?$key['coleccion_name']:""?>"
									aria-label="Añadir al carrito <?php echo $txt_referencia; ?>" 
									class="add_item_via_ajax_link boton-opciones" 
									rel='nofollow'
									href="<?=$base_url; ?>tienda/insert_database_item_to_cart/<?=$key['item_id']?>">
									<?php /*<i class="fas fa-cart-plus fa-lg"></i>*/ ?>
									Añadir al carrito
							</a> 
						</p>
					<?php
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
