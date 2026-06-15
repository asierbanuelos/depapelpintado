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
?> 

<div id='cart' class="wrapper">
	<div id='cart_content'>
		<?php
		/*
		print '<pre><xmp>';
		print_r($usuario);
		print '</xmp></pre>';
		*/
		

		?>
		<div class="container" id='datos_pedido'>
		    <div class='row heading-producto'>
		    	<div class='cart-grid-body col-xs-12 col-lg-8' id='ajax_content'>
					<input type="hidden" name="url_actual" id='url_actual' value="<?php echo current_url(); ?>" />
					<input type="hidden" name="paso-pre-ckeckout" id='paso-pre-ckeckout' value="1" />

					<?php
					echo form_open(current_url());
					?>
	    		<div class='border rounded mb-4'>
						<h1 class="h5 mb-4 py-3 px-3 text-left border-bottom border-dark">¿Tienes cuenta con nosotros? <span class="h6">Inicia sesión y cargaremos tus datos automáticamente</span></h1>
			    	<div>
							<table id="tabla-login"  class='form-group-aux align-bottom'>
								<tr class='info_req'>
									<td class=""><label for="checkout_login_email">Email:</label></td>
									<td class=''>
			              <input id="checkout_login_email" class="form-control" name="email" type="email" value="" autocomplete="off" placeholder="E-mail" /> 
									</td>
								</tr>
								<tr class='info_req'>
									<td class=""><label for="checkout_login_pass">Contraseña:</label></td>
									<td class='input-group'>
		                <input name="pass" id="checkout_login_pass" type="password" placeholder="Contraseña" autocomplete="off" class="form-control" />
				            <span id="imgContrasena" data-activo=false><img src="/includes/iconos/show_hide_password_2_32.png" class="icon"></span>
									</td>
								</tr>
								<tr class='info_req'>
									<td class=""></td>
									<td class=''>
		                <input class="boton-opciones" type="submit" name="identificate" value="Iniciar sesión">
		                <?php
		                /*
		                <a class="boton-opciones" id='continuar-invitado' rel="nofollow" href="#">Continuar como invitado</a>
										*/
										?>
									</td>
								</tr>
							</table>
			    	</div>
				    <?php
				    if(isset($logmsg_carrito)){
				      echo '<div class="no-account text-center m-4 text-danger">';
				      echo $logmsg_carrito;
				      echo '</div>';
				    }
				    ?>
		    	</div>
					<?php
					echo form_close();

					//echo form_open(current_url());
					?>
				  <form id="checkout-registro-form" method="post">
			      <input type="hidden" name="checkout_registro_contacto" id="checkout_registro_contacto" value="1">
		    		<div class='border rounded mb-4'>
							<h1 class="h5 mb-4 py-3 px-3 text-left border-bottom border-dark">Pedido como invitado</span></h1>
				    	<div>
								<table id="tabla-contacto"  class='form-group-aux align-bottom'>
									<tr class='info_req'>
										<td class=""><label for="checkout_email">Email*:</label></td>
										<td class=''>
											<input type="email" class='form-control' name="email" id="checkout_email" required="" value="<?php echo set_value('checkout[email]',$usuario->email);?>" placeholder="Email" />
										</td>
									</tr>
									<tr class='info_req'>
										<td class=""><label for="checkout_phone">Teléfono*:</label></td>
										<td class=''>
											<input type="text" class='form-control' name="phone" id="checkout_phone" required="" value="<?php echo set_value('checkout[phone]',$usuario->phone);?>" placeholder="Teléfono" />
										</td>
									</tr>
								</table>
								<h2 class="h5 mb-4 py-3 px-3 text-left border-bottom border-dark">Crear una cuenta <span class="h6">(opcional)</span></h2>
								<table id="tabla-registro"  class='form-group-aux align-bottom'>
									<tr class='info_req'>
										<td class=""><label for="field-password">Contraseña:</label></td>
										<td class='input-group'>
					            <input name="pass" id="field-password-reg" type="password" placeholder="" class="form-control" autocomplete="" value='<?php echo set_value('checkout[pass]',$pass_1);?>' />
					            <span id="imgContrasenaReg" data-activo=false><img src="/includes/iconos/show_hide_password_2_32.png" class="icon"></span>
										</td>
									</tr>
									<tr class='info_req'>
										<td class=""><label for="field-password-rep">Repita Contraseña:</label></td>
										<td class='input-group'>
					            <input name="pass2" id="field-password-rep" type="password" placeholder="" class="form-control" autocomplete="" value='<?php echo set_value('checkout[pass2]',$pass_2);?>' />
					            <span id="imgContrasenaRep" data-activo=false><img src="/includes/iconos/show_hide_password_2_32.png" class="icon"></span>
										</td>
									</tr>
									<tr class='info_req'>
										<td class=""></td>
										<td class=''>
											<div class="aviso_legal">
												<p>
													<input type="checkbox" id="legaladviceRegistro" name="legaladvice" value="1">
													<label for="legaladviceRegistro">He leído y acepto la <a href="/politica-de-privacidad" target="_blank">política de privacidad</a> </label>      
													<br />
													<input type="checkbox" id="suscripcionRegistro" name="suscripcionRegistro" value="1">
													<label for="suscripcionRegistro">Quiero recibir el boletín de noticias</label>      
												</p>
											</div>
											<input type="submit" name="checkout_contacto" value="Continuar" class="boton-opciones" />			
										</td>
									</tr>
								</table>
				    	</div>
					    <?php
					    if(isset($logmsg_new_carrito)){
					      echo '<div class="no-account text-center m-4 text-danger">';
					      echo $logmsg_new_carrito;
					      echo '</div>';
					    }
					    if(isset($pass_olvidada)){
					      echo '<div class="no-account text-center m-4">';
					      echo $pass_olvidada;
					      echo '</div>';
					    }
					    
					    ?>
						</div>
					</form>
					<?php
					//echo form_close();
					?>

			    </div>
		    	<div class='cart-grid-body col-xs-12 col-lg-4' id='resumen_pedido'>
					<?php
						// Para que no salga el boton de continuar bajo el formulario
						$this->data['formulario_compra_ya']=false;
		        //$this->load->view('demo/cart_view_resumen_pre_checkout', $this->data);
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
