
	<?php $this->load->view('frontend/header'); ?> 
    
    
     <div class="units-row units-padding">
 <div class="unit-centered unit-80 cuerpocentral blancobg estatica sombra">

		
        
			<div id="cart_content">
				<div id="ajax_content">

      
					<!--<input type="submit" name="save_order" value="Compra ahora" class="link_button large red total"/>-->
       
        <div style="display:block;height: 75px;"></div>			
		<?php if (! empty($message)) { ?>
			<div id="message">
				<?php echo $message; ?>
			</div>
         
            
            
             
   
     
    

<?php } ?>
										
			<?php echo form_open(current_url());?>	
                  
     <div class="units-row units-split" id="cart_items"> 
     	<div class="unit-100 end proceso">Proceso de compra en 2 pasos:</div>
     	<div class="unit-50 end proceso1 cajapro">Paso 1</div>
     	<div class="unit-50 end proceso2 cajapro2">Paso 2</div> <br/><br/><br/><br/><br/><br/>
        <div class="units-row units-split formulario" id="cart_items">    
   
    
         <div class="unit-100">               
			 <div class="unit-100 proceso linea2">Detalles Contacto</div>				
					<ul>
						<li class="info_req">
							<label for="checkout_email">Email:</label>
							<input type="text" name="checkout[email]" id="checkout_email" value="<?php echo set_value('checkout[email]',$usuario->email);?>" placeholder="Email" />
						</li>
						<li class="info_req">
							<label for="checkout_phone">Teléfono:</label>
							<input type="text" name="checkout[phone]" id="checkout_phone" value="<?php echo set_value('checkout[phone]',$usuario->phone);?>" placeholder="Teléfono" />
						</li>
						<li>
							<label for="checkout_comments">Comentarios:</label>
							<textarea name="checkout[comments]" id="checkout_comments" placeholder="Comentarios" rows="2" class="width_400"><?php echo set_value('checkout[comments]');?></textarea>
						</li>
					</ul>
				
			
       </div>
       </div>
            
            		
            
            
            
				
			<div class="limpiar" ></div>
		</div>
        <div class="units-row end">
        	<div class="unit-100">
            	
                <div class="unit-100 proceso linea2">Datos Envio</div>
                    <span class="c300"><label>
							Copiar datos de facturación
					
						</label></span>
            </div>
        
        </div> 
     
     
    
   <div class="units-row units-split" id="cart_items">  
   
				
   
   	<div class="unit-50 formulario">		         
<ul>
						<li class="info_req">
							<label for="checkout_shipping_name">Nombre y Apellidos / Razón Social:</label>
							<input type="text" name="checkout[shipping][name]" id="checkout_shipping_name" value="<?php echo set_value('checkout[shipping][name]',$usuario->ord_demo_ship_name);?>" placeholder="Nombre y Apellidos / Razón Social" />
						</li>
						<!--<li>
							<label for="checkout_shipping_company">NIF:</label>
							<input type="text" name="checkout[shipping][company]" id="checkout_shipping_company" value="<?php echo set_value('checkout[shipping][company]',$usuario->ord_demo_ship_company);?>" placeholder="NIF / CIF" />
						</li>-->
						<li class="info_req">
							<label for="checkout_shipping_add_01">Dirección 1:</label>
							<input type="text" name="checkout[shipping][add_01]" id="checkout_shipping_add_01" value="<?php echo set_value('checkout[shipping][add_01]',$usuario->ord_demo_ship_address_01);?>" placeholder="Dirección 1" />
						</li>
						<li  style="display:none;">
							<label for="checkout_shipping_add_02">Dirección 2:</label>
							<input type="text" name="checkout[shipping][add_02]" id="checkout_shipping_add_02" value="<?php echo set_value('checkout[shipping][add_02]',$usuario->ord_demo_ship_address_02);?>" placeholder="Dirección 2" />
						</li>
					</ul>
     </div>
     <div class="unit-50 formulario">
     
					<ul>
						<li class="info_req">
							<label for="checkout_shipping_city">Población:</label>
							<input type="text" name="checkout[shipping][city]" id="checkout_shipping_city" value="<?php echo set_value('checkout[shipping][city]',$usuario->ord_demo_ship_city);?>" placeholder="Población" />
						</li>
						<li class="info_req">
							<label for="checkout_shipping_state">Provincia:</label>
						<?php if (!($this->flexi_cart->shipping_location_name(2))) { ?>
							<input type="text" name="checkout[shipping][state]" id="checkout_shipping_state" value="<?php echo set_value('checkout[shipping][state]',$usuario->ord_demo_ship_state);?>" placeholder="Provincia" />
						<?php } else { ?>
							<input type="text" name="checkout[shipping][state]" id="checkout_shipping_state" value="<?php echo set_value('checkout[shipping][state]',$usuario->ord_demo_ship_state);?>" placeholder="Provincia" />
						<?php } ?>
						</li>
						<li class="info_req">
							<label for="checkout_shipping_post_code">Código Postal:</label>
						<?php if (!($this->flexi_cart->shipping_location_name(3))) { ?>
							<input type="text" name="checkout[shipping][post_code]" id="checkout_shipping_post_code" value="<?php echo set_value('checkout[shipping][post_code]',$usuario->ord_demo_ship_post_code);?>" placeholder="Código Postal" />
						<?php } else { ?>
							<?php echo $this->flexi_cart->shipping_location_name(3);?>
							<input type="hidden" name="checkout[shipping][post_code]" value="<?php echo set_value('checkout[shipping][post_code]', $this->flexi_cart->shipping_location_name(3));?>" style="list-style: none;"/>
						<?php } ?>
						</li>
						
							
							
					
					</ul>
					<input type="hidden" name="checkout[shipping][country]" value="<?php echo $this->flexi_cart->shipping_location_name(1);?>"/>
				
         </div>
            
       </div>    
       
    <div class="limpiar" ></div>     
    <div class="unit-100 proceso linea2">Datos Facturación    --    SOLO RELLENAR EN CASO DE SOLICITAR FACTURA</div>
     <div class="units-row units-split" id="cart_items">    
		<div class="unit-50 formulario">		
					
                
					<ul>
						<li class="info_req">
							<label for="checkout_billing_name">Nombre y Apellidos / Razón Social:</label>
							<input type="text" name="checkout[billing][name]" id="checkout_billing_name" value="<?php echo set_value('checkout[billing][name]',$usuario->ord_demo_bill_name);?>" placeholder="Nombre y Apellidos / Razón Social" />
						</li>
						<li>
							<label for="checkout_billing_company">NIF:</label>
							<input type="text" name="checkout[billing][company]" id="checkout_billing_company" value="<?php echo set_value('checkout[billing][company]',$usuario->ord_demo_bill_company);?>" placeholder="NIF / CIF" />
						</li>
						<li class="info_req">
							<label for="checkout_billing_add_01">Dirección 1:</label>
							<input type="text" name="checkout[billing][add_01]" id="checkout_billing_add_01" value="<?php echo set_value('checkout[billing][add_01]',$usuario->ord_demo_bill_address_01);?>" placeholder="Dirección 1" />
						</li>
						<li style="display:none;">
							<label for="checkout_billing_add_02">Dirección 2:</label>
							<input type="text" name="checkout[billing][add_02]" id="checkout_billing_add_02" value="<?php echo set_value('checkout[billing][add_02]',$usuario->ord_demo_bill_address_02);?>" placeholder="Dirección 2" />
						</li>
					</ul>
                    
                   </div>
                    
                    
                        <div class="unit-50 formulario">
                        
					<ul>
						<li class="info_req">
							<label for="checkout_billing_city">Población:</label>
							<input type="text" name="checkout[billing][city]" id="checkout_billing_city" value="<?php echo set_value('checkout[billing][city]',$usuario->ord_demo_bill_city);?>" placeholder="Población" />
						</li>
						<li class="info_req">
							<label for="checkout_billing_state">Provincia:</label>
							<input type="text" name="checkout[billing][state]" id="checkout_billing_state" value="<?php echo set_value('checkout[billing][state]',$usuario->ord_demo_bill_state);?>" placeholder="Provincia" />
						</li>
						<li class="info_req">
							<label for="checkout_billing_post_code">Código Postal:</label>
							<input type="text" name="checkout[billing][post_code]" id="checkout_billing_post_code" value="<?php echo set_value('checkout[billing][post_code]',$usuario->ord_demo_bill_post_code);?>" placeholder="Código Postal" />
						</li>

							
							

					</ul>
               <input type="hidden" id="checkout_billing_country" name="checkout[billing][country]"  value="5"/>
        
     </div>   
     </div>
      <input type="submit" name="save_order" value="Compra ahora" class="total"/>			
			<?php echo form_close();?>          
    
</div>
	
	<!-- Footer -->  
	<?php //$this->load->view('includes/footer'); ?> 


<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 
<script>
$(function() 
{
	// Toggle show/hide cart session array
	$('#copy_billing_details').click(function()
	{
//      if($("#checkout_billing_country").val()=="<?php echo $this->flexi_cart->shipping_location_name(1);?>"){
		$('input[name^="checkout[billing]"]').each(function()
		{
         
			// Target textboxes only, no hidden fields
			if ($(this).attr('type') == 'text')
			{
				var name = $(this).attr('name').replace('billing', 'shipping');
				var value = ($('#copy_billing_details').is(':checked')) ? $(this).val() : '';
				
				$('input[name="'+name+'"]').val(value);
			}
		});
 //     }
 //     else alert("No es posible copiar la dirección, los paises no coinciden.");
	
	});
});
</script>

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


</div><!-- fin cart content-->
</div> <!--fin cuerpo central-->
</div><!--fin units row-->

</body>
</html>