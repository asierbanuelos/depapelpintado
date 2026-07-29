<?php 
$datos_ga4=array();
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
?> 


<div id='cart' class="wrapper">
<div id='cart_content'>
	<?php  
	echo form_open(current_url());
	?>
	<input type="hidden" name="url_actual" id='url_actual' value="<?php echo current_url(); ?>" />
  <div class="container">
    <div class='row heading-producto'>
    	<div class='cart-grid-body col-xs-12 col-lg-8' id='ajax_content'>
    		<div class='border rounded'>
		      <h1 class="h5 mb-4 py-3 px-3 text-left border-bottom border-dark">CARRITO DE COMPRAS</h1>
		    	<div>
						<?php 
						
/*
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
*/
						if (! empty($cart_items) && $todo_ok) {
							$i = 0;
							echo '<ul class="cart-items list-unstyled">';
							foreach($cart_items as $row) { 
								$url_producto='';
								$trozos_nombre=explode(' - ', $row['name']);
								$marca='';
								$coleccion='';
								$nombre_item='';
								$referencia='';
								if ($row['tipo']==5){
									$pre='Herramientas';
									if (isset($trozos_nombre[0]))
										$marca=$trozos_nombre[0];
									if (isset($trozos_nombre[1]))
										$nombre_item=$trozos_nombre[1];
									if (isset($trozos_nombre[2]))
										$referencia=$trozos_nombre[2];

									$nombre_completo="Herramientas ".$nombre_item;
									$url_producto='/tienda/articulo/herramientas/'.urlenc(strtolower(preg_replace('/[^A-Za-z0-9\-]/', ' ', $row['name']))).'/id/'.$row['id'];
								}
								else{
									if($row['tipo']==0)$pre="Papel pintado";
									else if($row['tipo']==1)$pre="Fotomural";
									else if($row['tipo']==2)$pre="Revestimento";
									else if($row['tipo']==3)$pre="Tela";
									else if($row['tipo']==4)$pre="Alfombra";

									if (isset($trozos_nombre[0]))
										$marca=$trozos_nombre[0];
									if (isset($trozos_nombre[1]))
										$coleccion=$trozos_nombre[1];
									if (isset($trozos_nombre[2]))
										$referencia=$trozos_nombre[2];
									if (isset($trozos_nombre[3]))
										$referencia.=$trozos_nombre[3];
									if (isset($trozos_nombre[4]))
										$referencia.=$trozos_nombre[4];
								
									$nombre_completo=$pre." ".$coleccion." ".str_replace('<br />', ' ', $referencia);
									$url_producto='/tienda/articulo/'.urlenc($marca).'/'.urlenc($coleccion).'/id/'.$row['id'];
								}
								$precio=str_replace('€', '', $row['discount_price_total']);

								$datos_ga4[$row['id']]['name']=$nombre_completo;
								$datos_ga4[$row['id']]['price']=str_replace('€', '', $row['discount_price']);
								$datos_ga4[$row['id']]['brand']=$marca;
								$datos_ga4[$row['id']]['category']=$pre;
								$datos_ga4[$row['id']]['quantity']=$row['quantity'];

								$i++;
								echo '<li class="cart-item px-3 mb-4 pt-2">';
								echo 	'<div class="row">';

								echo 		'<div class="product-line-grid-left col-md-2 col-xs-4 d-flex align-items-center justify-content-center">';
								echo 			'<span class="product-image media-middle">';
								echo 				'<img style="height:75px" src="'.$includes_dir.str_replace("../", "", $row['thumb'])."th.jpg".'"/>';
								//<span style="overflow:hidden;height:75px;width:75px;display:inline-block"><img style="height:75px" src=" echo $includes_dir.str_replace("../", "", $row['thumb'])."th.jpg";"/></span>
								echo 			'</span>';
								echo 		'</div>';
								
								echo 		'<div class="product-line-grid-body col-md-6 col-xs-8">';
								echo 			'<div class="h6 mb-3">';
								echo 				'<input type="hidden" name="items['.$i.'][row_id]" value="'.$row['row_id'].'" />';
								//echo 			'<div class="product-line-info mb-3"><strong>';
								if (isset($url_producto) && trim($url_producto)!=''){
									//echo 				'<a class="label" href="'.$url_producto.'" data-id_customization="0">'.$row['name'].'</a>';
									echo 				'<a class="label" href="'.$url_producto.'" >'.$row['name'].'</a>';
								}
								else
									echo 				$row['name'];
											
											// ESTO NO SE SI SE USA
											/*
											if ($this->flexi_cart->item_option_status($row['row_id']) && isset($row['option_data'])) { 
												foreach($row['option_data'] as $option_column => $option_data) {
													?>
													<!-- 
														Example of displaying an items options if they exist, as an editable field, 
														this example uses a custom field ('option_data') containing an array of option data. 
														To activate this example, add item #202 on the 'Add an item with options via a form' page.
													-->
													<label class="c50"><?php echo $option_column; ?>:</label> 
													<select name="items[<?php echo $i;?>][options][<?php echo $option_column; ?>]" class="width_100">
														<?php foreach($option_data as $data) { ?>
															<option value="<?php echo $data; ?>" <?php echo set_select('items['.$i.'][options]['.$option_column.']', $data, ($data == $row['options'][$option_column]));?>>
																<?php echo $data; ?>
															</option>
														<?php } ?>
													</select><br/>
													<?php 
												} 
											} 
											else if ($this->flexi_cart->item_option_status($row['row_id'])) { 
												// Example of displaying an items options if they exist, but as text, rather than an editable field.
												echo $this->flexi_cart->item_options($row['row_id'], TRUE).'<br/>';
											}
											?>
											
											<!-- 
												Example of displaying any item status messages.
												Status messages are generated if an item cannot be shipped to the current shipping location, or if there is insufficient stock.
												A css style ('highlight_red') can be submitted to the function to format messages.
											-->
											<?php 
											$item_status_message = $this->flexi_cart->item_status_message($row['row_id'], 'highlight_red');
											//echo (! empty($item_status_message)) ? $item_status_message.'<br/>' : NULL;
										 	/*	
											<!-- 
												Example of indicating an items stock level - (Example only displays on item example #112) 
												If TRUE is submited to the 2nd parameter of 'item_stock_quantity()', it returns remaining quantity available once current quantity it deducted.
											-->
										
											if ($row['id'] == 112)
											{
												echo '<span class="highlight_green">There are <strong>'.$this->flexi_cart->item_stock_quantity($row['row_id']).'</strong> items in-stock.</span><br/>';
											}
										
											
											<!-- 
												Example of how to update a custom column defined via the config file var $config['cart']['items']['custom_columns'].
												Ensure the input name is the same as the custom column you wish to update.
												Note: Only custom columns that are defined as 'updatable' can be updated once set.											
											-->
											Note: <input type="text" name="items[<?php echo $i;?>][user_note]" value="<?php echo $row['user_note'];?>" maxlength="50" class="width_175"/>
											*/
								echo 			'</div>';
								if ($row['precio_unitario_final_sin_desc']!=$row['precio_unitario_final'])
									echo 			'<div class="regular-price"><del>'.number_format($row['precio_unitario_final_sin_desc'], 2, ',', '.').' €</del></div>';
								echo 			'<div class="current-price"><strong>'.number_format($row['precio_unitario_final'], 2, ',', '.').' €</strong></div>';
								
								if ($this->flexi_cart->item_discount_status($row['row_id'], FALSE))
									echo 			'<div class="txt-descuento">Descuentos: '.$this->flexi_cart->item_discount_description($row['row_id']).'</div>';
																

								echo 		'</div>';
								
								echo 		'<div class="product-line-grid-right col-md-4 col-xs-8">';
								echo 			'<div class="row">';
								echo 				'<div class="col-md-10 col-xs-5">';
								echo 					'<div class="row">';
								echo 						'<div class="col-md-5 col-xs-5 col-sp-12 qty">';
								//echo 							'<input type="number" min="0" step="1" id="unidades" name="i_unidades" value="'.$row['quantity'].'" class="w-25" oninput="calcular_total();">';
								//echo 							'<input type="number" data-prev="'.$row['quantity'].'" name="items['.$i.'][quantity]" min="0" step="1" id="unidades" name="i_unidades" value="'.number_format($row['quantity'], 0).'" class="w-100 pl-2" oninput="change_unidades();">';
								echo 							'<input type="number" data-prev="'.$row['quantity'].'" name="items['.$i.'][quantity]" min="0" step="1" id="unidades" name="i_unidades" value="'.number_format($row['quantity'], 0).'" class="w-100 pl-2" >';
								echo 						'</div>';
								echo 						'<div class="col-md-7 col-xs-7 col-sp-12 price">'.number_format($row['precio_unitario_final']*$row['quantity'], 2, ',', '.').' €</div>';
								echo 					'</div>';
								echo 				'</div>';
								
								echo 				'<div class="col-md-2 col-xs-3">';
								echo 				'<a class="remove-from-cart" rel="nofollow" href="/tienda/delete_item/'.$row['row_id'].'" data-link-action="delete-from-cart" data-id-product="'.$row['row_id'].'"><i class="fa fa-trash" aria-hidden="true"></i></a>';
					  		/*
					  		<a class='delete-item' data-fab="<?php echo $marca;?>" data-nombre-completo='<?php echo $nombre_completo; ?>' data-tipo-producto='<?php echo $pre; ?>' data-id-producto='<?php echo $row['id']; ?>' data-precio="<?php echo $precio; ?>" data-ref="<?php echo $referencia;?>" data-col="<?php echo $coleccion; ?>" data-unidades='<?php echo $row['quantity']; ?>'  title="Pincha para eliminar el artículo del carro" href="<?php echo $base_url; ?>tienda/delete_item/<?php echo $row['row_id'];?>">Eliminar</a>
								*/
								echo 				'</div>';
								echo 			'</div>';
								echo 		'</div>';
								echo '</li>';
							}
							echo '</ul>';
							
							echo '<div class="row">';
							echo '<div class="col-md-2 col-xs-4 d-flex"> </div>';
							//echo '<div class="col-md-9 col-xs-8 d-flex p-2 pl-4"><img src="/includes/images/information.png" alt="info" title="info"><small>Los artículos fabricados bajo pedido no admiten devoluciones</small></div>';
							echo '<div class="col-md-9 col-xs-8 d-flex p-2 pl-4">* <small> Los artículos fabricados bajo pedido no admiten devoluciones.</small></div>';
							//echo '<div class="col-md-9 col-xs-8 d-flex p-2 pl-4">* <small> Artículo fabricado sobre pedido - no admite devolución.</small></div>';
							echo '</div>';

						}
						elseif(!$todo_ok){
							echo 		'<div class="h5 pl-4 pb-4">Debido a problemas técnicos no podemos procesar pedidos en este momento. <br />Disculpe las molestias.</div>';
						}
						else{
							echo 		'<div class="h5 pl-4 pb-4">¡Tu carro está vacio!</div>';
						}
						?>
		    	</div>
		    </div>

		    <?php
				$hilabete_eguna=date('m-d');
				//$hilabete_eguna='08-31';
				//~ if ($gaur>=date('Y').'-07-25' && $gaur<=date('Y').'-08-31')
				if ($hilabete_eguna>='07-25' && $hilabete_eguna<='08-31'){
				?>
					<div class="row">
						<div class="col-12 mt-3">
							<div class="texto-aviso p-3">
								Dado que algunos fabricantes cierran por vacaciones, los pedidos pueden sufrir un ligero retraso.
							</div>
						</div>
					</div>		    
				<?php 
				}
				?>
		    <div class='botones'>
			    <div class='row'>
			    	<div class='col-12'>
	          	<button onclick="javascript:location.href='/'" type="button" name="volver" value="Volver a la tienda" class="boton-opciones"> < Seguir comprando</button>
	            <button type="submit" name="update" value="Actualizar Carro" class="boton-opciones">Actualizar Carro <i class="fa fa-refresh" aria-hidden="true"></i></button>
	            <button type="submit" name="clear" value="Vaciar Carro" class="boton-opciones">Vaciar Carro <i class="fa fa-times-circle "></i></button>
							<?php 
							/*
							if (! empty($cart_items)) {?>
	            <button type="submit" name="checkout" value="Compra Ahora" class="boton-opciones">Compra Ahora</button>
							<?
							}
							*/
							?>
						</div>
			    </div>
		    </div>
			<?php
			if ($todo_ok){
			?>
				<h2 style="margin-top: 40px;text-align: center;font-size: 22px;font-weight: 100;">
					Pase por la sección de <a href="/tienda/herramientas/" style="color: #b47c9a;">herramientas</a> y complemente su compra.
		        </h2> 
			<?php	
			}
				/*
				<table id="cart_shipping_cola">
					<thead>
						<tr>
							<td colspan="5">
								<div style="font-size: 16px;float:left;">
									<a href="https://www.depapelpintado.es/tienda/herramientas"><img src="https://www.depapelpintado.es/includes/cola.jpg" width="100px"></a>
								</div>
								<div style="font-size: 16px; padding-top:40px; float:left;">
									!No se olvide de la cola! Pase por la sección de <a href="https://www.depapelpintado.es/tienda/herramientas">herramientas</a> y complemente su compra.</span>
								</div>
							</td>
						</tr>
					</thead>
				</table>
								*/
								?>

        <?php 
        /*   	
<section class="page-product-box grelated_products ">
	   <h2 class="products-section-title text-uppercase">
        No te olvides de añadir              </h2>
        <div class="product_grid products">
               			<article class="item product-miniature js-product-miniature" data-id-product="11431" data-id-product-attribute="0" itemscope="" itemtype="http://schema.org/Product">
                    <div class="thumbnail-container">
                      
                                                  <a href="https://presta.depapelpintado.es/mica/11431-Rodillo-juntas-11431.html" class="thumbnail product-thumbnail">
                            <img src="https://presta.depapelpintado.es/177766-home_default/Rodillo-juntas.jpg" alt="Rodillo juntas" data-full-size-image-url="https://presta.depapelpintado.es/177766-large_default/Rodillo-juntas.jpg">
                          </a>
                                              

                      <div class="product-description">
                        
                          <h3 itemprop="name" class="h3 product-title">
        					<a href="https://presta.depapelpintado.es/mica/11431-Rodillo-juntas-11431.html" class="thumbnail product-thumbnail">
                            Rodillo juntas
                          </a>
                        </h3>
                        

                        
                                                      <div class="product-price-and-shipping">
                              
                              

                              <span class="sr-only">Precio</span>
                              <span itemprop="price" class="price">4,80&nbsp;€</span>

                              

                              
                            </div>
                                                  

                        
                          <div class="an_wishlist-mini js-an_wishlist-container">
	<span class="js-an_wishlist-addremove" data-url="//presta.depapelpintado.es/module/an_wishlist/ajax?token=ee31a30a50500b8f47c63fed525a0aa8&amp;id_product=11431&amp;id_product_attribute=0&amp;action=addRemove" title="Añadir a favoritos">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="24px" height="24px"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path></svg>
    </span>
		<div class="an_wishlist-mini-count js-an_wishlist-product-count" title="veces favorito">0</div>
	</div>

                        
                      </div>

                      
                        <ul class="product-flags">
                                                      <li class="product-flag out_of_stock">Fuera de stock</li>
                                                  </ul>
                      

                      <div class="highlighted-informations no-variants hidden-sm-down">
                        
                          <a class="quick-view" href="#" data-link-action="quickview" style="display: block;">
                            <i class="material-icons search"></i> Vista rápida
                          </a>

                        

                        
                                                  
                      </div>

                    </div>
                    <div class="grelated_products_submit_bt">
                        <form action="https://presta.depapelpintado.es/carrito" method="post" class="hiaddtocart">
                            <input type="hidden" name="token" value="ee31a30a50500b8f47c63fed525a0aa8">
                            <input type="hidden" name="id_product" value="11431" class="product_page_product_id">
                            <input type="hidden" name="id_customization" value="0" class="product_customization_id">
                                                            <div class="product-quantity">
                                  <input type="hidden" name="qty" value="1" min="1" class="input-group hi-quantity">
                                </div>
                            <button class="btn btn-primary add-to-cart" data-button-action="add-to-cart" type="submit">
                                Añadir a la cesta
                            </button>
                        </form>
                    </div>
                  </article>
    		    			<article class="item product-miniature js-product-miniature" data-id-product="11432" data-id-product-attribute="0" itemscope="" itemtype="http://schema.org/Product">
                    <div class="thumbnail-container">
                      
                                                  <a href="https://presta.depapelpintado.es/mica/11432-Regla-empapelador-flexible-11432.html" class="thumbnail product-thumbnail">
                            <img src="https://presta.depapelpintado.es/177764-home_default/Regla-empapelador-flexible.jpg" alt="Regla empapelador flexible" data-full-size-image-url="https://presta.depapelpintado.es/177764-large_default/Regla-empapelador-flexible.jpg">
                          </a>
                                              

                      <div class="product-description">
                        
                          <h3 itemprop="name" class="h3 product-title">
        					<a href="https://presta.depapelpintado.es/mica/11432-Regla-empapelador-flexible-11432.html" class="thumbnail product-thumbnail">
                            Regla empapelador flexible
                          </a>
                        </h3>
                        

                        
                                                      <div class="product-price-and-shipping">
                              
                              

                              <span class="sr-only">Precio</span>
                              <span itemprop="price" class="price">19,75&nbsp;€</span>

                              

                              
                            </div>
                                                  

                        
                          <div class="an_wishlist-mini js-an_wishlist-container">
	<span class="js-an_wishlist-addremove" data-url="//presta.depapelpintado.es/module/an_wishlist/ajax?token=ee31a30a50500b8f47c63fed525a0aa8&amp;id_product=11432&amp;id_product_attribute=0&amp;action=addRemove" title="Añadir a favoritos">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="24px" height="24px"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path></svg>
    </span>
		<div class="an_wishlist-mini-count js-an_wishlist-product-count" title="veces favorito">0</div>
	</div>

                        
                      </div>

                      
                        <ul class="product-flags">
                                                      <li class="product-flag out_of_stock">Fuera de stock</li>
                                                  </ul>
                      

                      <div class="highlighted-informations no-variants hidden-sm-down">
                        
                          <a class="quick-view" href="#" data-link-action="quickview" style="display: block;">
                            <i class="material-icons search"></i> Vista rápida
                          </a>

                        

                        
                                                  
                      </div>

                    </div>
                    <div class="grelated_products_submit_bt">
                        <form action="https://presta.depapelpintado.es/carrito" method="post" class="hiaddtocart">
                            <input type="hidden" name="token" value="ee31a30a50500b8f47c63fed525a0aa8">
                            <input type="hidden" name="id_product" value="11432" class="product_page_product_id">
                            <input type="hidden" name="id_customization" value="0" class="product_customization_id">
                                                            <div class="product-quantity">
                                  <input type="hidden" name="qty" value="1" min="1" class="input-group hi-quantity">
                                </div>
                            <button class="btn btn-primary add-to-cart" data-button-action="add-to-cart" type="submit">
                                Añadir a la cesta
                            </button>
                        </form>
                    </div>
                  </article>
    		    			<article class="item product-miniature js-product-miniature" data-id-product="11436" data-id-product-attribute="0" itemscope="" itemtype="http://schema.org/Product">
                    <div class="thumbnail-container">
                      
                                                  <a href="https://presta.depapelpintado.es/mica/11436-Cola-VD-100g-11436.html" class="thumbnail product-thumbnail">
                            <img src="https://presta.depapelpintado.es/177756-home_default/Cola-VD-100g.jpg" alt="Cola VD 100g" data-full-size-image-url="https://presta.depapelpintado.es/177756-large_default/Cola-VD-100g.jpg">
                          </a>
                                              

                      <div class="product-description">
                        
                          <h3 itemprop="name" class="h3 product-title">
        					<a href="https://presta.depapelpintado.es/mica/11436-Cola-VD-100g-11436.html" class="thumbnail product-thumbnail">
                            Cola VD 100g
                          </a>
                        </h3>
                        

                        
                                                      <div class="product-price-and-shipping">
                              
                              

                              <span class="sr-only">Precio</span>
                              <span itemprop="price" class="price">6,90&nbsp;€</span>

                              

                              
                            </div>
                                                  

                        
                          <div class="an_wishlist-mini js-an_wishlist-container">
	<span class="js-an_wishlist-addremove" data-url="//presta.depapelpintado.es/module/an_wishlist/ajax?token=ee31a30a50500b8f47c63fed525a0aa8&amp;id_product=11436&amp;id_product_attribute=0&amp;action=addRemove" title="Añadir a favoritos">
		<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" width="24px" height="24px"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"></path></svg>
    </span>
		<div class="an_wishlist-mini-count js-an_wishlist-product-count" title="veces favorito">0</div>
	</div>

                        
                      </div>

                      
                        <ul class="product-flags">
                                                      <li class="product-flag out_of_stock">Fuera de stock</li>
                                                  </ul>
                      

                      <div class="highlighted-informations no-variants hidden-sm-down">
                        
                          <a class="quick-view" href="#" data-link-action="quickview" style="display: block;">
                            <i class="material-icons search"></i> Vista rápida
                          </a>

                        

                        
                                                  
                      </div>

                    </div>
                    <div class="grelated_products_submit_bt">
                        <form action="https://presta.depapelpintado.es/carrito" method="post" class="hiaddtocart">
                            <input type="hidden" name="token" value="ee31a30a50500b8f47c63fed525a0aa8">
                            <input type="hidden" name="id_product" value="11436" class="product_page_product_id">
                            <input type="hidden" name="id_customization" value="0" class="product_customization_id">
                                                            <div class="product-quantity">
                                  <input type="hidden" name="qty" value="1" min="1" class="input-group hi-quantity">
                                </div>
                            <button class="btn btn-primary add-to-cart" data-button-action="add-to-cart" type="submit">
                                Añadir a la cesta
                            </button>
                        </form>
                    </div>
                  </article>
    		        </div>
    </section>
		*/
		?>

    	</div>
    	<div class='cart-grid-body col-xs-12 col-lg-4' id='resumen_pedido'>
			<?php
			if ($todo_ok){
		        //$this->load->view('demo/cart_view_resumen', $this->data);
		        $this->load->view('demo/cart_view_resumen');
			}
			?>
    	</div>
    </div>
  </div>
	<?php  
	echo form_close();
	?>
</div>
<?php 
/*
print '<pre><xmp>';
print_r($countries);
print '</xmp></pre>';
print '<pre><xmp>';
print_r($states);
print '</xmp></pre>';
print '<pre><xmp>';
print_r($shipping_options);
print '</xmp></pre>';


print '<pre><xmp>';
print_r($countries);
print '</xmp></pre>';
*/
/*
?>
 <div class="units-row units-padding">
 <div class="unit-centered unit-80 cuerpocentral blancobg estatica sombra">
	
	<!-- Main Content -->
		<div class="clearfix">
			<div id="cart_content_viejo">
        <div style="display:block;height: 75px;"></div>
					
				<?php 
				/*
				if (! empty($message)) { 
				?>
					<div id="message">
						<?php echo $message; ?>
					</div>
				<?php 
				} 
				/*
					print '<pre><xmp>';
					print_r($cart_items);
					print '</xmp></pre>';
				if (isset($_GET['test'])){
				}
				*/
				//~ exit;
				/*
				?>
				
					
				
					

					<?php 
						// Example on how to display how much more needs to be spent, or how many more items need to be added to activate a discount.
						// The function can work on both item and summary discounts.
						// Note: Ensure '$free_shipping_discount' contains no formatted currency strings by submitting FALSE as the 2nd argument to 'get_discount_requirements'.
						$free_shipping_discount = $this->flexi_cart->get_discount_requirements(5, FALSE);
						if ($free_shipping_discount['value'] > 0) { 
					?>
						<div class="frame align_ctr">
							<h3>Si gastas otros <?php echo $this->flexi_cart->get_currency_value($free_shipping_discount['value']);?> ¡Los portes te salen gratis!</h3>
						</div>
					<?php } ?>
												
					<?php //echo form_close();?>
			</div>
		</div>
	</div>	
	
	<!-- Footer -->  
	<?php
	*/
	//$this->load->view('includes/footer'); 
	?> 


<!-- Scripts -->  
<?php 
//$this->load->view('includes/scripts'); 
?> 
<script>

	function data_layer_zona_envio(){

		//opcion_envio_txt=$('#country_id option:selected').attr('data-texto-limpio')+' '+$('#zonaid option:selected').attr('data-texto-limpio')+' '+$('#opcion_envio option:selected').attr('data-texto-limpio');
		opcion_envio_txt='Confirmar carrito';
		//alert(opcion_envio_txt);
		/**
		* A function to handle a click on a checkout button. This function uses the eventCallback
		* data layer variable to handle navigation after the ecommerce data has been sent to Google Analytics.
		*/
		// QUITAMOS EL PUSH HASTA QUE ESTE EN PROD
		/*
		*/
		dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
		dataLayer.push({
		  'event': 'checkout',
		  'ecommerce': {
		    'currencyCode': 'EUR',
		    'checkout': {
		      'actionField': {'step': 2,  'option': opcion_envio_txt},
		      'products': [
						<?php 
						foreach ($datos_ga4 as $idproducto => $datos_producto) {
							echo "{ \n";
							echo "  name: '{$datos_producto['name']}',  \n";       // Name or ID is required.
							echo "  id: '$idproducto', \n";
							echo "  price: {$datos_producto['price']}, \n";
							echo "  brand: '{$datos_producto['brand']}', \n";
							echo "  category: '{$datos_producto['category']}', \n";
							//echo "  item_category2: "Mens", \n";
							//echo "  item_category3: "Shirts", \n";
							//echo "  item_category4: "Tshirts", \n";
							//echo "  item_variant: "Gray", \n";
							echo "  quantity: '{$datos_producto['quantity']}' \n";
							echo "}, \n";
						}
						?>
		      ]
		    }
		  }
		});
	}
</script>

<script>
/**
* A function to handle a click on a checkout button. This function uses the eventCallback
* data layer variable to handle navigation after the ecommerce data has been sent to Google Analytics.
*/
// QUITAMOS EL PUSH HASTA QUE ESTE EN PROD
/*
*/

dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
dataLayer.push({
  'event': 'begin_checkout',
  'ecommerce': {
    'currencyCode': 'EUR',
      'checkout': {
      'actionField': {'step': 1},
      'products': [
		    <?php 
		    foreach ($datos_ga4 as $idproducto => $datos_producto) {
		      echo "{ \n";
		      echo "  name: '{$datos_producto['name']}',  \n";       // Name or ID is required.
		      echo "  id: '$idproducto', \n";
		      echo "  price: {$datos_producto['price']}, \n";
		      echo "  brand: '{$datos_producto['brand']}', \n";
		      echo "  category: '{$datos_producto['category']}', \n";
		      //echo "  item_category2: "Mens", \n";
		      //echo "  item_category3: "Shirts", \n";
		      //echo "  item_category4: "Tshirts", \n";
		      //echo "  item_variant: "Gray", \n";
		      echo "  quantity: '{$datos_producto['quantity']}' \n";
		      echo "}, \n";
		    }
		    ?>
      ]
    }
  }
});
</script>	

<?php 
//if (isset($_GET['test'])){
	/*
	print '<pre><xmp>';
	print_r($datos_ga4);
	print '</xmp></pret>';
	*/
	?>
	<?php
//}
?>
</div>
</div>
</div>
<div style="display:none" id="dialog-confirm" title="Está seguro de querer eliminar este artículo">
<p><span>Esta acción no puede deshacerse</span></p>
</div>
