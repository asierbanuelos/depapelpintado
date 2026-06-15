<html>
<body>

<style type="text/css">
	body, table {font-size:14px; font-family:Arial; color:#333333;}
	h1, h2, h3 {margin:0 0 10px 0; padding:0;}
	h1 {font-size:18px;}
	p {margin:4px 0;}
</style>

	<div style="width:600px;">
		<h1>Detalles de pedido dePapelPintado.es</h1>
								
		<div style="margin-bottom:10px; padding:10px; background-color:#fafafa; border:1px solid #e9e9e9;">
			<h3>Order</h3>			
			<p><span style="display:inline-block; width:125px;">Número de pedido: </span><?php echo $summary_data[$this->flexi_cart_admin->db_column('order_summary', 'order_number')];?></p>
			<p><span style="display:inline-block; width:125px;">Fecha de pedido: </span><?php echo date('Y-m-d', strtotime($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'date')]));?></p>
		</div>
			
		<div style="margin-bottom:10px; padding:10px; background-color:#fafafa; border:1px solid #e9e9e9;">
			<h3>Detalles de Facturación</h3>
			<p><span style="display:inline-block; width:125px;">Nombre / Razón Social: </span><?php echo $summary_data['ord_demo_bill_name'];?></p>
            <?if($summary_data['ord_demo_bill_company']!=""){?>(<p><span style="display:inline-block; width:125px;">NIF: </span><?php echo $summary_data['ord_demo_bill_company'];?></p><?}?>
			<p><span style="display:inline-block; width:125px;">Direccion 01: </span><?php echo $summary_data['ord_demo_bill_address_01'];?></p>
			<p><span style="display:inline-block; width:125px;">Direccion 02: </span><?php echo $summary_data['ord_demo_bill_address_02'];?></p>
			<p><span style="display:inline-block; width:125px;">Población: </span><?php echo $summary_data['ord_demo_bill_city'];?></p>
			<p><span style="display:inline-block; width:125px;">Provincia: </span><?php echo $summary_data['ord_demo_bill_state'];?></p>
			<p><span style="display:inline-block; width:125px;">Codigo Postal: </span><?php echo $summary_data['ord_demo_bill_post_code'];?></p>
			<p><span style="display:inline-block; width:125px;">Pais: </span><?php echo $summary_data['ord_demo_bill_country'];?></p>
		</div>

		<div style="margin-bottom:10px; padding:10px; background-color:#fafafa; border:1px solid #e9e9e9;">
			<h3>Detalles de Envio</h3>			
			<p><span style="display:inline-block; width:125px;">Nombre: </span><?php echo $summary_data['ord_demo_ship_name'];?></p>
			<p><span style="display:inline-block; width:125px;">Dirección 01: </span><?php echo $summary_data['ord_demo_ship_address_01'];?></p>
			<p><span style="display:inline-block; width:125px;">Dirección 02: </span><?php echo $summary_data['ord_demo_ship_address_02'];?></p>
			<p><span style="display:inline-block; width:125px;">Población: </span><?php echo $summary_data['ord_demo_ship_city'];?></p>
			<p><span style="display:inline-block; width:125px;">Provincia: </span><?php echo $summary_data['ord_demo_ship_state'];?></p>
			<p><span style="display:inline-block; width:125px;">Codigo Postal: </span><?php echo $summary_data['ord_demo_ship_post_code'];?></p>
			<p><span style="display:inline-block; width:125px;">Pais: </span><?php echo $summary_data['ord_demo_ship_country'];?></p>
		</div>
			
		<div style="margin-bottom:10px; padding:10px; background-color:#fafafa; border:1px solid #e9e9e9;">
			<h3>Detalles de Contacto</h3>
			<p><span style="display:inline-block; width:125px;">Email: </span><?php echo $summary_data['ord_demo_email'];?></p>
			<p><span style="display:inline-block; width:125px;">Teléfono: </span><?php echo $summary_data['ord_demo_phone'];?></p>
		<?php if (! empty($summary_data['ord_demo_comments'])) { ?>
			<p><span style="display:inline-block; width:125px;">Comentarios: </span><?php echo $summary_data['ord_demo_comments'];?></p>
		<?php } ?>
		</div>

		<div style="margin-bottom:10px; padding:10px; background-color:#fafafa; border:1px solid #e9e9e9;">
			<h2>Detalles del Pedido</h2>
			
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
				<tr>
					<th style="text-align:left;">Artículo</th>
					<th style="width:80px; text-align:center;">Precio</th>
					<th style="width:80px; text-align:center;">Cantidad</th>
					<th style="width:80px; text-align:right;">Total</th>
				</tr>
			<?php 
				foreach($item_data as $row) {
					$order_detail_id = $row[$this->flexi_cart_admin->db_column('order_details', 'id')];
			?>
				<tr>
					<td>
						<!-- Item Name -->
						<?php echo $row[$this->flexi_cart_admin->db_column('order_details', 'item_name')];?>
						
						<!-- Display an items options if they exist -->
						<?php 
							echo (! empty($row[$this->flexi_cart_admin->db_column('order_details', 'item_options')])) ? 
								'<br/>'.$row[$this->flexi_cart_admin->db_column('order_details', 'item_options')] : NULL; 
						?>
						
						<!-- 
							Display an items user note if it exists
							Note: This is a optional custom field added to this cart demo and is not defined via the cart config file.
						-->										
						<?php echo (! empty($row['ord_det_demo_user_note'])) ? '<br/>Note: '.$row['ord_det_demo_user_note'] : NULL; ?>
					</td>
					<td style="text-align:center;">
					<?php 
						// If an item discount exists.
						if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0) 
						{
							// If the quantity of non discounted items is zero, strike out the standard price.
							if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_non_discount_quantity')] == 0)
							{
								echo '<span style="text-decoration:line-through;">'.$this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price')], TRUE, 2, TRUE).'</span><br/>';
							}
							// Else, display the quantity of items that are at the standard price.
							else
							{
								echo number_format($row[$this->flexi_cart_admin->db_column('order_details', 'item_non_discount_quantity')]).' @ '.
									$this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price')], TRUE, 2, TRUE).'<br/>';
							}
							
							// If there are discounted items, display the quantity of items that are at the discount price.
							if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0)
							{
								echo number_format($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')]).' @ '.
									$this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_price')], TRUE, 2, TRUE);
							}
						}
						// Else, display price as normal.
						else
						{
							echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price')], TRUE, 2, TRUE);
						}
					?>
					</td>
					<td style="text-align:center;">
						<?php echo round($row[$this->flexi_cart_admin->db_column('order_details', 'item_quantity')], 2); ?>
					</td>
					<td style="text-align:right;">
					<?php 
						// If an item discount exists, strike out the standard item total and display the discounted item total.
						if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0)
						{
							echo '<span style="text-decoration:line-through;">'.$this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price_total')], TRUE, 2, TRUE).'</span><br/>';
							echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_price_total')], TRUE, 2, TRUE);
						}
						// Else, display item total as normal.
						else
						{
							echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price_total')], TRUE, 2, TRUE);
						}
					?>
					</td>
				</tr>
			<?php 
				// If an item discount exists.
				if (! empty($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_description')])) { 
			?>
				<tr>
					<td colspan="4" style="background-color:#ecfccb; border-top:1px solid #999; border-bottom:1px solid #999;">
						Descuentos: <?php echo $row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_description')];?>
					</td>
				</tr>
			<?php } } ?>
				<tr>
					<th colspan="3" style="font-weight:bold; text-align:left;">
						 Subtotal:
					</th>
					<td style="text-align:right;">
						<?php echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_total')], TRUE, 2, TRUE);?>
					</td>
				</tr>
			</table>			
		</div>

		<div style="margin-bottom:10px; padding:10px; background-color:#fafafa; border:1px solid #e9e9e9;">
			<h2>Order Summary</h2>
			
			<table width="100%" border="0" cellspacing="0" cellpadding="3">
				<tr>
					<td>
						Envio: <?php echo $summary_data[$this->flexi_cart_admin->db_column('order_summary', 'shipping_name')];?>
					</td>
					<td style="width:100px; text-align:right;">
						<?php echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'shipping_total')], TRUE, 2, TRUE);?>
					</td>
				</tr>
				<tr>
					<td>
						<?php echo "IVA ".$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'tax_rate')];?>
					</td>
					<td style="width:100px; text-align:right;">
						<?php echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'tax_total')], TRUE, 2, TRUE);?>
					</td>
				</tr>
				<tr>
					<th style="font-weight:bold; text-align:left;">
						Total
					</th>
					<td style="width:100px; text-align:right;">
						<?php echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'total')], TRUE, 2, TRUE);?>
					</td>
				</tr>
			</table>
		</div>
	</div>
	
</body>
</html>