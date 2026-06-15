<div class='border rounded cart-summary' id='contenedor_resumen'>
<table id="cart_summary">
<thead>
<tr>
<th colspan="2">Resumen</th>
</tr>
</thead>
<tbody>

<tr>
<td>
Total Artículos
</td>
<td class='text-right'>
<?php 
	if (isset($resumen_pedido['ord_item_summary_total']))
		echo number_format($resumen_pedido['ord_item_summary_total'], 2, ',', '.');
	else{
		echo $this->flexi_cart->item_summary_total();
		//echo $this->flexi_cart->item_summary_total(false);
	}
?>
</td>
</tr>

<tr>
<td>
Portes*
</td>
<td class='text-right'>
	<?php 
	if (isset($resumen_pedido['ord_shipping_total']))
		echo number_format($resumen_pedido['ord_shipping_total'], 2, ',', '.');
	else
		echo $this->flexi_cart->shipping_total();
	?>
</td>
</tr>

<?php if ($this->flexi_cart->summary_discount_status()) { ?>
<tr class="discount">
<th>Resumen Descuentos</th>
<td>&nbsp;</td>
</tr>

<?php if ($this->flexi_cart->item_summary_discount_status()) { ?>
<!-- 
Rather than repeating the descriptions of each item discount listed via the cart, 
this example summarises the discount totals of all items.
-->
<tr class="discount">
<th>
<span class="pad_l_20">
&raquo; Descuentos por artículo
</span>
</th>
<td class='text-right'>
<?php echo $this->flexi_cart->item_summary_savings_total();?>
</td>
</tr>
<?php } ?>

<!-- 
This example uses the 'summary_discount_data()' function to return an array of summary discount values and descriptions.
An alternative to using a custom loop to return this discount array, is to call the 'summary_discount_description()' function,
which will return a formatted string of all summary discounts. 
-->
<?php foreach($discounts as $discount) { ?>
<tr class="discount">
<th>
<span class="pad_l_20">
&raquo; <?php echo $discount['description'];?>
<?php 
/*
if (! empty($discount['id'])) { ?>
: <a href="<?php echo $base_url; ?>tienda/unset_discount/<?php echo $discount['id']; ?>">Eliminar</a>
<?php 
} 
*/
?>
</span>
</th>
<td class='text-right'><?php echo $discount['value'];?></td>
</tr>
<?php } ?>
<tr class="discount">
<th>Total Descuentos</th>
<td class='text-right'><?php echo $this->flexi_cart->cart_savings_total();?></td>
</tr>
<?php } ?>


<?php if ($this->flexi_cart->surcharge_status()) { ?>
<tr class="surcharge">
<th>Resumen Sobrecostos</th>
<td>&nbsp;</td>
</tr>

<!-- 
This example uses the 'surcharge_data()' function to return an array of surcharge values and descriptions.
An alternative to using a custom loop to return this surcharge array, is to call the 'surcharge_description()' function,
which will return a formatted string of all surcharges.
-->
<?php foreach($surcharges as $surcharge) { ?>
<tr class="surcharge">
<th>
<span class="pad_l_20">
&raquo; <?php echo $surcharge['description'];?>
: <a href="<?php echo $base_url; ?>tienda/unset_surcharge/<?php echo $surcharge['id']; ?>">Eliminar</a>
</span>
</th>
<td class='text-right'><?php echo $surcharge['value'];?></td>
</tr>
<?php } ?>
<tr class="surcharge">
<th>Total Sobrecostos</th>
<td class='text-right'><?php echo $this->flexi_cart->surcharge_total();?></td>
</tr>
<?php } ?>

<?php if ($this->flexi_cart->reward_voucher_status()) { ?>
<tr class="voucher">
<th>Resumen Vales</th>
<td>&nbsp;</td>
</tr>

<!-- This example uses the 'reward_voucher_data()' function to return an array of reward voucher values and descriptions. -->
<?php foreach($reward_vouchers as $voucher) { ?>
<tr class="voucher">
<th>
<span class="pad_l_20">
&raquo; <?php echo $voucher['description'];?>
: <a href="<?php echo $base_url; ?>tienda/unset_discount/<?php echo $voucher['id']; ?>">Eliminar</a>
</span>
</th>
<td class='text-right'><?php echo $voucher['value'];?></td>
</tr>
<?php } ?>
<tr class="voucher">
<th>Total Vales</th>
<td class='text-right'><?php echo $this->flexi_cart->reward_voucher_total();?></td>
</tr>
<?php } ?>

</tbody>
<tfoot>
<tr>
<td>
Sub Total
</td>
<td class='text-right'>
<?php 
	if (isset($resumen_pedido['ord_sub_total']))
		echo number_format($resumen_pedido['ord_sub_total'], 2, ',', '.');
	else
		echo $this->flexi_cart->sub_total();?>
</td>
</tr>
<tr>
<td>
<?php echo $this->flexi_cart->tax_name()." ".$this->flexi_cart->tax_rate(); ?>
</td>
<td class='text-right'>
<?php 
	if (isset($resumen_pedido['ord_tax_total']))
		echo number_format($resumen_pedido['ord_tax_total'], 2, ',', '.');
	else
		echo $this->flexi_cart->tax_total();?>
</td>
</tr>							
<tr class="grand_total">
<th>Gran Total</th>
<td class='text-right'>
	<?php 
	if (isset($resumen_pedido['ord_total']))
		echo number_format($resumen_pedido['ord_total'], 2, ',', '.');
	else
		echo $this->flexi_cart->total();
	?>
</td>
</tr>
</tfoot>
</table>
<div class='text-left p-2 mb-3'>
<small>
*El coste de los gastos de envio para pedidos inferiores a 50€ sera de 9,90 por pedido.<br>
<strong>Para pedidos superiores a 50€ los gastos de envio son gratuitos salvo Canarias, Ceuta y Melilla.</strong><br>
Si lo necesita, disponemos de envios urgentes, consúltanos. 
</small>
</div>

<div class='text-center mb-3'>
	<?php 
	if(isset($formulario_checkout)){
	?>
		<input type="submit" name="save_order" value="Continuar" class="boton-opciones" />			
	<?php 
	}
	elseif(isset($formulario_compra_ya)){
	}
	else{
	?>
		<button type="submit" name="checkout" value="Compra Ahora" class="boton-opciones">Compra Ahora</button>		
	<?php
	}
/*
<button type="submit" name="checkout" value="Compra Ahora" class="boton-opciones">Compra Ahora <i class="fa fa-shopping-cart"></i></button>		
*/
?>
</div>
<?php 
/*
if (isset($countries)) { 
?>
<table id="cart_shipping">
<tbody>
<tr>
<th colspan='2'>Envío</th>
</tr>
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
<tr class='form-group align-bottom'>
<td>
<label class="spacer_200">Zona:</label>
</td>
<td>
<select id="zonaid" name="shipping[state]" <?php if (empty($states)) { echo 'disabled="disabled"'; }?>  class='form-control'>
<option value="0"> - Zona - </option>
<?php foreach($states as $state) { ?>
<option data-texto-limpio="<?php echo $state['loc_name'];?>" value="<?php echo $state['loc_id'];?>" <?php echo ($this->flexi_cart->match_shipping_location_id($state['loc_id'])) ? 'selected="selected"' : NULL;?>>
<?php echo $state['loc_name'];?>
</option>
<?php } ?>
</select>
<?php
/*
<label>Codigo Postal:
<!-- The value '3' in the 'shipping_location_name()' function requests the location name for the 3rd location tier - in this example, postal/zip code -->
<input type="text" name="shipping[postal_code]" value="<?php echo $this->flexi_cart->shipping_location_name(3);?>" <?php if (empty($postal_codes)) { echo 'disabled="disabled"'; }?> placeholder="00000" class="width_75"/>
</label>
*/
/*
?>
</td>
</tr>
<tr class='form-group align-bottom'>
<td colspan='2'>
<label class="spacer_125">Opciones de envio:</label>
<select id="opcion_envio" name="shipping[db_option]"  class='form-control'>
<option value="0"> - Opciones de envio - </option>
<?php 
if (! empty($shipping_options)) {
foreach($shipping_options as $shipping) { 
?>
<option data-texto-limpio="<?php echo $shipping['name'];?>" value="<?php echo $shipping['id'];?>" <?php echo ($shipping['id'] == $this->flexi_cart->shipping_id()) ? 'selected="selected"' : NULL; ?>>
<?php echo $shipping['name']." : ".$shipping['description'];?>
</option>
<?php } } else { ?>
<option data-texto-limpio="<?php echo 'Te cotizaremos antes de despachar la mercancia.';?>" value="0">
Te cotizaremos antes de despachar la mercancia.
</option>
<?php } ?>
</select>
</td>
</tr>
<tr>
<td colspan='2'>
<small>
El coste de los gastos de envio para pedidos inferiores a 50€ sera de 6,95 por pedido.<br>
<strong>Para pedidos superiores a los 50€ los gastos de envio son gratuitos.</strong><br>
Si lo necesita, disponemos de envios urgentes, consúltanos. 
</small>
</td>	
</tr>
</tbody>
</table>
<?php } else { ?>					
<!-- Manually set shipping option example -->
<table id="cart_shipping">
<thead>
<tr>
<th>Envio</th>
</tr>
</thead>
<tbody>
<tr>
</tr>
<tr>
<td>
<label>Opciones de envio:
<select name="shipping[manual_option]">
<option value="0"> - Opciones de envio - </option>
<?php 
if (! empty($shipping_options)) {
foreach($shipping_options as $shipping) { 
?>
<option value="<?php echo $shipping['id'];?>" <?php echo ($shipping['id'] == $this->flexi_cart->shipping_id()) ? 'selected="selected"' : NULL; ?>>
<?php echo $shipping['name']." : ".$shipping['description'];?>
</option>
<?php } } else { ?>
<option value="0">
Te cotizaremos antes de despachar la mercancia.
</option>
<?php } ?>
</select>
</label>
</td>
</tr>
</tbody>
<tfoot>
<tr>
<td>&nbsp;</td>
</tr>
</tfoot>
</table>
<?php 
} 
*/
?>
	<?php
	/*
	<table id="cart_codes">
		<thead>
			<tr><th>Vales descuento</th></tr>
		</thead>
		<tbody>
			<tr>
				<td> <input class="formulario2" type="text" name="discount[0]" value=""/> 
				<button type="submit" name="update_discount" value="Añadir código de descuento" class="boton-opciones">Añadir código de descuento</button>
				<?php
				/*
				<button type="submit" name="update_discount" value="Añadir código de descuento" class="boton-opciones">Añadir código de descuento <i class="fa fa-barcode"></i></button>
				*/
				/*
				?>
				<button type="submit" name="remove_all_discounts" value="Eliminar todos los descuentos" class="link_button tooltip_trigger">Eliminar todos los descuentos <i class="fa fa-exclamation-circle"></i></button>


				</td>
			</tr>
			<tr>
				<td> <?php 
					// Get an array of all discount codes. The returned array keys are 'id', 'code' and 'description'.
					if ($discount_data = $this->flexi_cart->discount_codes()) {
					foreach($discount_data as $discount_codes) {
					?>
					<input type="text" name="discount[<?php echo $discount_codes['code']; ?>]" value="<?php echo $discount_codes['code']; ?>"/> 
					<input type="submit" name="update_discount" value="Actualizar" class="link_button grey"/>
					<input type="submit" name="remove_discount_code[<?php echo $discount_codes['code']; ?>]" value="Eliminar" class="link_button grey"/>
					<small class="inline">* <?php echo $discount_codes['description'];?></small><br/>
					<?php
					}
					}
					?>
				</td>
			</tr>
		</tbody>
	</table>
	*/
	?>

	<?php
	/*
	if (! $this->flexi_cart->location_shipping_status()) { ?>
		<div class="warning">
		<h3>Aviso!</h3>
		<p> Hay artículos en tu carro que no pueden ser enviados al destino seleccionado.</p>
		</div>
	<?php 
	} 
	?>

	<table id="cart_items">
		<tfoot>
		<?php 
		// Ensure the 'item_summary_savings_total()' functions format argument is set to 'FALSE' to prevent comparing a formatted STRING against an INT of '0'.
		if ($this->flexi_cart->item_summary_savings_total(FALSE) > 0) { 
		?>
		<tr class="discount">
		<th colspan="4">Total Descuentos por artículo</th> 
		<td><?php echo $this->flexi_cart->item_summary_savings_total();?></td>
		</tr>
		<?php } ?>
		<tr>
		<th colspan="4">Total Artículos</th>
		<td><?php echo $this->flexi_cart->item_summary_total();?></td>
		</tr>

		</tfoot>
	</table>
	<div class='text-center mb-3'>
		<button type="submit" name="checkout" value="Compra Ahora" class="boton-opciones">Compra Ahora</button>		
	</div>
	<?php
	*/
	?>
</div>
