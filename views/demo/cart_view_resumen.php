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
<?php 
if ($this->flexi_cart->item_summary_discount_status()) { 
/*
?>
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
<?php
*/ 
} 
?>

	<!-- 
	This example uses the 'summary_discount_data()' function to return an array of summary discount values and descriptions.
	An alternative to using a custom loop to return this discount array, is to call the 'summary_discount_description()' function,
	which will return a formatted string of all summary discounts. 
	-->
	<?php 
	foreach($discounts as $discount){ 
	?>
		<tr class="discount">
			<td>
				<span class="pad_l_20">
				<?php echo $discount['description'];?>
				<?php 
				/*
				&raquo; <?php echo $discount['description'];?>
				if (! empty($discount['id'])) { ?>
				: <a href="<?php echo $base_url; ?>tienda/unset_discount/<?php echo $discount['id']; ?>">Eliminar</a>
				<?php 
				} 
				*/
				?>
				</span>
			</td>
			<td class='text-right'><?php echo $discount['value'];?></td>
		</tr>
		<?php 
	}

	$descuento_por_articulos=0; 
	if ($this->flexi_cart->item_summary_discount_status())
		$descuento_por_articulos=$this->flexi_cart->item_summary_savings_total();
	?>
	<tr class="discount">
		<th>Total Descuentos</th>
		<td class='text-right'>
			<?php 
			//echo $this->flexi_cart->cart_savings_total();
			echo $this->flexi_cart->summary_savings_total();
			?>
		</td>
	</tr>
<?php 
} 
?>


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

<?php
//if (isset($_GET['test']) && $_GET['test']=='eneko'){
if(!isset($formulario_compra_ya)){
?>
	<table id="cart_codes" class='mt-3 mb-3'>
		<thead>
			<tr><th colspan="2">Vales descuento</th></tr>
		</thead>
		<tbody>
			<?php 
			if ($discount_data = $this->flexi_cart->discount_codes()) {
				/*
				?>
				<tr>
					<td colspan="2"> 
						<button type="submit" name="remove_all_discounts" value="Eliminar todos los descuentos" class="boton-opciones">Eliminar todos los descuentos <i class="fa fa-exclamation-circle"></i></button>
					</td>
				</tr>
				*/
				?>
				<tr>
					<td colspan="2"> 
						<?php 
						// Get an array of all discount codes. The returned array keys are 'id', 'code' and 'description'.
						foreach($discount_data as $discount_codes) {
						?>
							<input type="text" name="discount[<?php echo $discount_codes['code']; ?>]" value="<?php echo $discount_codes['code']; ?>"/> 
							<input type="submit" name="update_discount" value="Actualizar" class="boton-opciones"/>
							<input type="submit" name="remove_discount_code[<?php echo $discount_codes['code']; ?>]" value="Eliminar" class="boton-opciones"/>
							<br /><small class="inline"><?php echo $discount_codes['description'];?></small><br/>
						<?php
						}
						?>
					</td>
				</tr>
			<?php 
			}
			else{
			?>
				<tr>
					<td> 
						<input class="formulario2" type="text" name="discount[0]" value=""/> 
					</td> 
					<td> 
						<button type="submit" name="update_discount" value="Añadir código de descuento" class="boton-opciones m-0">Añadir código</button>
						<?php 
						/*
						<button type="submit" name="update_discount" value="Añadir código de descuento" class="boton-opciones">Añadir código de descuento</button>
						*/
						?>
					</td> 
				</tr>
			<?php 
			}
			?>
		</tbody>
	</table>
<?php
}
?>

<div class='text-left p-2 mb-3'>
<small>
*El coste de los gastos de envio para pedidos inferiores a 50€ sera de 9,90 por pedido.<br>
<strong>Para pedidos superiores a 50€ los gastos de envío son gratuitos a Península y Baleares</strong><br>
<?php 
/*
<strong>Para pedidos superiores a 50€ los gastos de envio son gratuitos salvo Canarias, Ceuta y Melilla.</strong><br>
*/
?>
Si lo necesita, disponemos de envios urgentes, consúltanos. 
</small>
</div>

<?php
if (isset($resumen_pedido['ord_total']))
	$importe_total_pedido=number_format($resumen_pedido['ord_total'], 2, '.', '');
else
	$importe_total_pedido= str_replace('€', '', $this->flexi_cart->total());
?>

<div class='text-center mb-3'>
	<?php 
	if(isset($formulario_checkout)){
	?>
		<div id='plazos_paypal' class='p-2'
			data-pp-message
			data-pp-style-layout="text"
			data-pp-style-logo-type="inline"
			data-pp-style-text-color="black"
			data-pp-amount="<?php echo $importe_total_pedido; ?>">
		</div>            
		<input type="submit" name="save_order" value="Continuar" id='btn-continuar' class="boton-opciones" />			
	<?php 
	}
	elseif(isset($formulario_compra_ya)){
		?>
		<div id='plazos_paypal' class='p-2'
			data-pp-message
			data-pp-style-layout="text"
			data-pp-style-logo-type="inline"
			data-pp-style-text-color="black"
			data-pp-amount="<?php echo $importe_total_pedido; ?>">
		</div>            
		<?php
	}
	else{
	?>
		<div id='plazos_paypal' class='p-2'
			data-pp-message
			data-pp-style-layout="text"
			data-pp-style-logo-type="inline"
			data-pp-style-text-color="black"
			data-pp-amount="<?php echo $importe_total_pedido; ?>">
		</div>            
		<button type="submit" name="checkout" value="Compra Ahora" class="boton-opciones">Compra Ahora</button>		
	<?php
	}
?>
</div>
</div>

