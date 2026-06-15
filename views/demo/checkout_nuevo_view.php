<?php 
//$this->load->view('frontend/header'); 

/*
// mirar mensajes
<div style="display:block;height: 75px;"></div>			
<?php if (! empty($message)) { ?>
<div id="message">
<?php echo $message; ?>
</div>


<tr class='form-group align-bottom'>
<td class=''>
<label class="spacer_250">País:</label>
</td>
<td>
<select id="country_id" name="shipping[country]" class='form-control'>
<option value="0"> - País - </option>
<?php 
foreach($countries as $country) { ?>
<option data-texto-limpio="<?php echo $country['loc_name'];?>" value="<?php echo $country['loc_id'];?>" <?php echo ($this->flexi_cart->match_shipping_location_id($country['loc_id'])) ? 'selected="selected"' : NULL;?>>
<?php echo $country['loc_name'];?>
</option>
<?php 
} ?>
</select>
</td>
</tr>

*/
if (!isset($guardar_datos_nuevo_usuario))
	$guardar_datos_nuevo_usuario=false;
?> 

<div id='cart' class="wrapper">
	<div id='cart_content'>
		<?php  
		echo form_open(current_url());
		?>
		<input type="hidden" name="url_actual" id='url_actual' value="<?php echo current_url(); ?>" />
		<input type="hidden" name="guardar_datos_nuevo_usuario" id='guardar_datos_nuevo_usuario' value="<?php echo $guardar_datos_nuevo_usuario; ?>" />

		<div class="container" id='datos_pedido'>
		    <div class='row heading-producto'>
		    	<div class='cart-grid-body col-xs-12 col-lg-8' id='ajax_content'>
		    		<div class='border rounded'>
						<h1 class="h5 mb-4 py-3 px-3 text-left border-bottom border-dark">Detalles Contacto</h1>
				    	<div>
							<table id="tabla-contacto"  class='form-group align-bottom'>
								<tr class='info_req'>
									<td class=""><label for="checkout_email">Email*:</label></td>
									<td class=''>
										<?php 
										if ($usuario->user_id >= 1){
											echo $usuario->email;
											?>
											<input type="hidden" name="checkout[email]" value="<?php echo $usuario->email;?>"  />
											<?php
										}
										else{
										?>
											<input type="text" class='form-control' name="checkout[email]" id="checkout_email" value="<?php echo set_value('checkout[email]',$usuario->email);?>" placeholder="Email" />
										<?php
										}
										?>
									</td>
								</tr>
								<tr class='info_req'>
									<td class=""><label for="checkout_phone">Teléfono*:</label></td>
									<td class=''>
										<input type="text" class='form-control' name="checkout[phone]" id="checkout_phone" value="<?php echo set_value('checkout[phone]',$usuario->phone);?>" placeholder="Teléfono" />
									</td>
								</tr>
							</table>
				    	</div>
						<h1 class="h5 mb-4 py-3 px-3 text-left border-bottom border-dark">Datos de envío</h1>
				    	<div>
							<table id="tabla-envio"  class='form-group align-bottom'>
								<tr class='info_req form-group align-bottom'>
									<td class="">
										<label for="checkout_shipping_name">Nombre y Apellidos / Razón Social*:</label>
									</td>
									<td class=''>
										<input type="text" name="checkout[shipping][name]" id="checkout_shipping_name" value="<?php echo set_value('checkout[shipping][name]',$usuario->ord_demo_ship_name);?>" placeholder="Nombre y Apellidos / Razón Social" class='form-control'/>
									</td>
								</tr>
								<tr class='info_req form-group align-bottom'>
									<td class=''>
										<label for="country_id" class="spacer_250">País*:</label>
									</td>
									<td>
										<?php 
										$pais_defecto=5;
										if ($usuario->user_id > 1){
											if ($usuario->ord_demo_ship_country)
												$pais_defecto=$usuario->ord_demo_ship_country;
										}
										if (isset($_POST['checkout']['shipping']['country'])){
											$pais_defecto=$_POST['checkout']['shipping']['country'];
										}
										if ($pais_defecto==0)
											$pais_defecto=5;
										?>
										<select id="country_id" name="checkout[shipping][country]" class='form-control pais-envio'>
										<option value="0"> - País - </option>
										<?php 
										ksort($countries);
										foreach($countries as $country){ 
											//$country_selected=($this->flexi_cart->match_shipping_location_id($country['loc_id'])) ? ' selected="selected" ' : NULL;
											$country_selected='';
											if($country['loc_id']==$pais_defecto)
												$country_selected=' selected="selected" ';
											?>
											<option data-texto-limpio="<?php echo $country['loc_name'];?>" value="<?php echo $country['loc_id'];?>" <?php echo $country_selected;?> >
												<?php echo $country['loc_name'];?>
											</option>
										<?php 
										} ?>
										</select>
									</td>
								</tr>
								<tr class='info_req form-group align-bottom'>
									<td class="">
										<label for="checkout_shipping_post_code">Código Postal*:</label>
									</td>
									<td class=''>
									<?php 
									if (!($this->flexi_cart->shipping_location_name(3))) { 
										?>
										<input type="text" name="checkout[shipping][post_code]" id="checkout_shipping_post_code" value="<?php echo set_value('checkout[shipping][post_code]',$usuario->ord_demo_ship_post_code);?>" placeholder="Código Postal" class='form-control' />
										<?php 
									}
									else{ 
										echo $this->flexi_cart->shipping_location_name(3);
										?>
										<input type="hidden" name="checkout[shipping][post_code]" value="<?php echo set_value('checkout[shipping][post_code]', $this->flexi_cart->shipping_location_name(3));?>" style="list-style: none;"/>
										<?php 
									}
									/*
									<input type="hidden" id="checkout_shipping_country" name="checkout[shipping][country]" value="<?php echo $this->flexi_cart->shipping_location_name(1);?>"/>
									*/ 
									?>
									</td>
								</tr>
								<tr class='info_req form-group align-bottom'>
									<td class=""><label for="checkout_shipping_add_01">Dirección*:</label></td>
									<td class=''>
										<input type="text" name="checkout[shipping][add_01]" id="checkout_shipping_add_01" value="<?php echo set_value('checkout[shipping][add_01]',$usuario->ord_demo_ship_address_01);?>" placeholder="Dirección" class='form-control' />
										<input style="display:none;" type="text" name="checkout[shipping][add_02]" id="checkout_shipping_add_02" value="<?php echo set_value('checkout[shipping][add_02]',$usuario->ord_demo_ship_address_02);?>" placeholder="Dirección 2" />
									</td>
								</tr>
								<tr class='info_req form-group align-bottom'>
									<td class="">
										<label for="checkout_shipping_city">Población*:</label>
									</td>
									<td class=''>
										<input type="text" name="checkout[shipping][city]" id="checkout_shipping_city" value="<?php echo set_value('checkout[shipping][city]',$usuario->ord_demo_ship_city);?>" placeholder="Población" class='form-control' />
									</td>
								</tr>
								<tr class='info_req form-group align-bottom'>
									<td class="">
										<label for="checkout_shipping_state">Provincia*:</label>
									</td>
									<td class=''>
									<?php 
									if (!($this->flexi_cart->shipping_location_name(2))) { 
										?>
										<input type="text" name="checkout[shipping][state]" id="checkout_shipping_state" value="<?php echo set_value('checkout[shipping][state]',$usuario->ord_demo_ship_state);?>" placeholder="Provincia"  class='form-control'/>
										<?php 
									}
									else{ 
										?>
										<input type="text" name="checkout[shipping][state]" id="checkout_shipping_state" value="<?php echo set_value('checkout[shipping][state]',$usuario->ord_demo_ship_state);?>" placeholder="Provincia"  class='form-control'/>
										<?php 
									} 
									?>
									</td>
								</tr>
								<tr class=''>
									<td class=""><label for="checkout_comments">Comentarios:</label></td>
									<td class=''>
										<textarea name="checkout[comments]" id="checkout_comments" placeholder="Comentarios" rows="2" class="form-control"><?php echo set_value('checkout[comments]');?></textarea>
									</td>
								</tr>
							</table>
						</div>
				    	
						<h1 class="h5 mb-4 py-3 px-3 text-left border-bottom border-dark">Datos Facturación - SOLO RELLENAR EN CASO DE SOLICITAR FACTURA</h1>
				    	<div>
				    		<?php 
							/*
				    		?>
							<div class="col-12">
								<span class="" id='copiar_datos_envio'>Copiar datos de envío</span>
							</div>
				    		<?php 
							*/
				    		?>
							<table id="tabla-envio"  class='form-group align-bottom'>
								<tr class='info_req form-group align-bottom'>
									<td class="">
										<label for="checkout_billing_name">Nombre y Apellidos / Razón Social:</label>
									</td>
									<td class=''>
										<input type="text" name="checkout[billing][name]" id="checkout_billing_name" value="<?php echo set_value('checkout[billing][name]',$usuario->ord_demo_bill_name);?>" placeholder="Nombre y Apellidos / Razón Social" class='form-control' />
									</td>
								</tr>
								<tr class='info_req form-group align-bottom'>
									<td class="">
										<label for="checkout_billing_company">NIF:</label>
									</td>
									<td class=''>
										<input type="text" name="checkout[billing][company]" id="checkout_billing_company" value="<?php echo set_value('checkout[billing][company]',$usuario->ord_demo_bill_company);?>" placeholder="NIF / CIF" class='form-control' />
									</td>
								</tr>
								<tr class='info_req form-group align-bottom'>
									<td class=""><label for="checkout_billing_add_01">Dirección:</label></td>
									<td class=''>
										<input type="text" name="checkout[billing][add_01]" id="checkout_billing_add_01" value="<?php echo set_value('checkout[billing][add_01]',$usuario->ord_demo_bill_address_01);?>" placeholder="Dirección" class='form-control' />
										<input style="display:none;" type="text" name="checkout[billing][add_02]" id="checkout_billing_add_02" value="<?php echo set_value('checkout[billing][add_02]',$usuario->ord_demo_bill_address_02);?>" placeholder="Dirección 2" />
									</td>
								</tr>
								<tr class='info_req form-group align-bottom'>
									<td class="">
										<label for="checkout_billing_city">Población:</label>
									</td>
									<td class=''>
										<input type="text" name="checkout[billing][city]" id="checkout_billing_city" value="<?php echo set_value('checkout[billing][city]',$usuario->ord_demo_bill_city);?>" placeholder="Población" class='form-control' />
									</td>
								</tr>
								<tr class='info_req form-group align-bottom'>
									<td class="">
										<label for="checkout_billing_state">Provincia:</label>
									</td>
									<td class=''>
										<input type="text" name="checkout[billing][state]" id="checkout_billing_state" value="<?php echo set_value('checkout[billing][state]',$usuario->ord_demo_bill_state);?>" placeholder="Provincia" class='form-control' />
									</td>
								</tr>
								<tr class='info_req form-group align-bottom'>
									<td class="">
										<label for="checkout_billing_post_code">Código Postal:</label>
									</td>
									<td class=''>
										<input type="text" name="checkout[billing][post_code]" id="checkout_billing_post_code" value="<?php echo set_value('checkout[billing][post_code]',$usuario->ord_demo_bill_post_code);?>" placeholder="Código Postal" class='form-control' />
										<input type="hidden" id="checkout_billing_country" name="checkout[billing][country]"  value="5"/>
									</td>
								</tr>
							</table>
						</div>
				    </div>

					<div class='text-center mb-3'>
						<input type="submit" name="save_order" value="Continuar" class="boton-opciones" />			
					</div>

			    </div>
		    	<div class='cart-grid-body col-xs-12 col-lg-4' id='resumen_pedido'>
					<?php
					$this->data['formulario_checkout']=true;
			        //$this->load->view('demo/cart_view_resumen', $this->data);
			        $this->load->view('demo/cart_view_resumen', $this->data);
					?>
		    	</div>
		    </div>
	    </div>
	</div>
</div>

<div style="display:block;height: 75px;"></div>			
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
print_r($postal_codes);
print '</xmp></pre>';
<div class="modal fade show d-block" id="erroresModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">

*/
if (! empty($message)) { 
?>
	<div class="modal fade in" id="erroresModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
	  <div class="modal-dialog modal-dialog-centered" role="document" >
	    <div class="modal-content">
	      <div class="modal-header" style='background-color:#000;color:#fff;'>
	        <h2 class="modal-title h6" id="exampleModalLongTitle">Rellene los campos obligatorios:</h2>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true" style='color:#fff;'>&times;</span>
	        </button>
	      </div>


	      <div class="modal-body">
	        <div class="row">
	          <div class="col-12">
							<?php echo $message; ?>
	          </div>
	        </div>
	      </div>

	      <div class="text-center p-2">
	        <button type="button" class="boton-opciones m-0" data-dismiss="modal">Cerrar</button>
	      </div>
	    </div>
	  </div>
	</div>
<?php 
} 
?>

<!-- Scripts -->  
<?php 
//$this->load->view('includes/scripts'); 
?> 

<?php 
foreach($mini_cart_items as $row){
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
	
		$nombre_completo=$pre." ".$coleccion." ".$referencia;
	}

	$datos_ga4[$row['id']]['name']=$nombre_completo;
	$datos_ga4[$row['id']]['price']=str_replace('€', '', $row['discount_price']);
	$datos_ga4[$row['id']]['brand']=$marca;
	$datos_ga4[$row['id']]['category']=$pre;
	$datos_ga4[$row['id']]['quantity']=$row['quantity'];
}

?>
<script>
/**
* A function to handle a click on a checkout button. This function uses the eventCallback
* data layer variable to handle navigation after the ecommerce data has been sent to Google Analytics.
*/
dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
dataLayer.push({
  'event': 'add_shipping_info',
  'ecommerce': {
    'currencyCode': 'EUR',
    'checkout': {
      'actionField': {'step': 3},
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
