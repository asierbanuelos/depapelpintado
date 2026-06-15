<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Update Order Details | flexi cart | A Shopping Cart Library for CodeIgniter</title>
	<meta name="description" content="A live working demo of flexi carts update order details function."/> 
	<meta name="keywords" content="update, order details, flexi cart, shopping cart, codeigniter"/>
	<?php $this->load->view('includes/head'); ?> 
</head>

<body id="order_details">

<div id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 
	
	
	<!-- Main Content -->
	<div class="content_wrap main_content_bg">
		<div class="content clearfix">
			
		<?php if (! empty($message)) { ?>
			<div id="message">
				<?php echo $message; ?>
			</div>
		<?php } ?>
										
			<h1>Actualizar detalles de Pedido</h1>
			<?php $order_number = $current_order_data[$this->flexi_cart_admin->db_column('order_summary', 'order_number')];?>
			<p><a href="<?php echo $base_url; ?>admin_library/orders">Administrar Pedidos</a> | <a href="<?php echo $base_url; ?>admin_library/order_details/<?php echo $order_number; ?>">Ver Pedidos Guardados</a></p>
						
			<?php echo form_open(current_url());?>						
				<fieldset>
					<legend>Pedidos</legend>
					
					<ul class="left">
						<li>
							<span class="spacer_125">Nº de Pedido: </span>
							<?php echo $order_number;?>
						</li>
					</ul>
					<ul class="right">
						<li>
							<span class="spacer_125">Fecha: </span>
							<?php echo date('jS M Y', strtotime($current_order_data[$this->flexi_cart_admin->db_column('order_summary', 'date')]));?>
						</li>
					</ul>
				</fieldset>
				
			<?php if ($current_order_data[$this->flexi_cart_admin->db_column('order_status', 'cancelled')] == 1) { ?>
				<div class="order_status_cancelled align_ctr">
					<p>Este pedido ha sido Cancelado, Si el pedido se vuelve a guardar, Su estado pasara a ser automáticamente el estado por defeccto.</p>
				</div>
			<?php } ?>

				<fieldset>
					<legend>Añadir nuevos Articulos</legend>
					<br/>

					<input type="button" value="Mostrar / Ocultar" class="link_button toggle"/>
					<div class="hide_toggle">
						<table>
							<thead>
								<tr>
									<th class="tooltip_trigger" 
										title="Nombre del articulo.">
										Nombre
									</th>
									<th class="spacer_100 align_ctr tooltip_trigger" 
										title="Indica el peso del articulo, puede utilizarse para calcular los portes.">
										Peso
									</th>
									<th class="spacer_100 align_ctr tooltip_trigger" 
										title="Precio Base del Artículo.">
										Precio
									</th>
									<th class="spacer_100 align_ctr tooltip_trigger" 
										title="Nº de articulos a añadir al carro.">
										Cantidad
									</th>
									<th class="spacer_100 align_ctr tooltip_trigger" 
										title="Número de articulos disponibles en stock.">
										Stock
									</th>
								</tr>
							</thead>
							<tbody>
							<?php
								foreach($item_data as $item) {
									$item_id = $item['item_id'];
									$item_tax_rate = $this->flexi_cart_admin->get_item_tax_rate($item_id);
							?>
								<tr>
									<td>
										<?php echo $item['item_name']; ?>
									</td>
									<td class="align_ctr">
										<?php echo $this->flexi_cart_admin->format_weight($item['item_weight']); ?>
									</td>
									<td class="align_ctr">
										<input type="text" name="insert_item[<?php echo $item_id; ?>][item_price]" value="<?php echo $item['item_price'];?>" class="width_50 align_ctr validate_decimal"/>
									</td>
									<td class="align_ctr">
										<input type="text" name="insert_item[<?php echo $item_id; ?>][item_quantity]" value="0" class="width_50 align_ctr validate_integer"/>
									</td>
									<td class="align_ctr">
										<?php 
											$item_stock_quantity = $this->flexi_cart_admin->get_item_stock_quantity($item_id, TRUE); 
											echo ($item_stock_quantity) ? $item_stock_quantity : '-';
										?>
									</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
						<input type="submit" name="update_order[insert_items]" value="Añadir Articulos al Pedido" class="link_button large"/>
					</div>
				</fieldset>

				<fieldset>
					<legend>Updated Order Details</legend>
					<table id="cart_items">
						<thead>
							<tr>
								<th>Item</th>
								<th class="spacer_100 align_ctr">Price</th>
								<th class="spacer_100 align_ctr tooltip_trigger"
									title="Cantidad total de articulos.">
									Cantidad Pedida
								</th>
								<th class="spacer_100 align_ctr tooltip_trigger"
									title="Cantidad de ariculos servida, activa los puntos promocionales correspondientes.">
									Cantidad Entregada
								</th>
								<th class="spacer_100 align_ctr tooltip_trigger"
									title="Cantidad de articulos cancelados, serán devueltos al stock.">
									Cantidad Cancelada
								</th>
								<th class="spacer_100 align_ctr">Total</th>
							</tr>
						</thead>
						<tbody>
						<?php 
							if (! empty($update_cart_items)) {
								$i = 0;
								foreach($update_cart_items as $row) { $i++;
						?>
							<tr>
								<td>
									<input type="hidden" name="items[<?php echo $i;?>][row_id]" value="<?php echo $row['row_id'];?>"/>
									<strong><?php echo $row['name'];?></strong><br/>

								<?php if ($this->flexi_cart_admin->item_option_status($row['row_id'])) { ?>
									<!-- Example of displaying an items options if they exist as text, rather than an editable field. -->
									<?php echo $this->flexi_cart_admin->item_options($row['row_id'], TRUE).'<br/>';?>										
								<?php } ?>
									
									<!-- 
										Example of displaying any item status messages.
										Status messages are generated if an item cannot be shipped to the current shipping location, or if there is insufficient stock.
										A css style ('highlight_red') can be submitted to the function to format messages.
									-->
									<?php 
										$item_status_message = $this->flexi_cart_admin->item_status_message($row['row_id'], 'highlight_red');
										echo ($item_status_message) ? $item_status_message.'<br/>' : NULL;
									?>										

									<!-- 
										Example of displaying the current stock quantity of an item within the cart.
										As this page is displaying data of a comfirmed order, the quantity of items from the original order has already been deducted from stock when the order was placed.
										Therefore, the stock level will only change when either a quantity different from that originally ordered is entered, or a different quantity of 'cancelled' items is selected.
									-->
									<span class="highlight_grey">Item stock level: 
									<?php 
										$item_stock_quantity = $this->flexi_cart_admin->item_stock_quantity($row['row_id'], TRUE);
										echo ($item_stock_quantity !== FALSE) ? $item_stock_quantity : 'Item not in database stock table.	';
									?>
									</span>
								</td>
								<td class="align_ctr">
									<input type="text" name="items[<?php echo $i;?>][price]" value="<?php echo $this->flexi_cart_admin->item_price($row['row_id'], FALSE, FALSE, TRUE);?>" class="width_50 align_ctr validate_decimal"/><br/>
								<?php 
									// If an item discount exists.
									if ($this->flexi_cart_admin->item_discount_status($row['row_id'])) 
									{
										// If the quantity of non discounted items is zero, strike out the standard price.
										if ($row['non_discount_quantity'] == 0)
										{
											echo '<span class="strike">'.$row['price'].'</span><br/>';
										}
										// Else, display the quantity of items that are at the standard price.
										else
										{
											echo $row['non_discount_quantity'].' @ '.$row['price'].'<br/>';
										}
										
										// If there are discounted items, display the quantity of items that are at the discount price.
										if ($row['discount_quantity'] > 0)
										{
											echo $row['discount_quantity'].' @ '.$row['discount_price'];
										}
									}
								?>
								</td>
								<td class="align_ctr">
									<input type="text" name="items[<?php echo $i;?>][quantity]" value="<?php echo $row['quantity'];?>" maxlength="3" class="width_50 align_ctr validate_integer"/>
								</td>
								
								<td class="align_ctr">
									<select name="items[<?php echo $i;?>][quantity_shipped]" class="width_50">
										<option value="0">0</option>
									<?php $shipped_qty = 0; do { $shipped_qty++; ?>
										<option value="<?php echo $shipped_qty; ?>" <?php echo set_select('update_details['.$i.'][quantity_shipped]', $shipped_qty, ($this->flexi_cart_admin->item_shipped_quantity($row['row_id']) == $shipped_qty)); ?>>
											<?php echo $shipped_qty; ?>
										</option>
									<?php } while($shipped_qty < $row['quantity']); ?>
									</select>
								</td>
								<td class="align_ctr">
									<select name="items[<?php echo $i;?>][quantity_cancelled]" class="width_50">
										<option value="0">0</option>
									<?php $cancelled_qty = 0; do { $cancelled_qty++;?>
										<option value="<?php echo $cancelled_qty; ?>" <?php echo set_select('update_details['.$i.'][quantity_cancelled]', $cancelled_qty, ($this->flexi_cart_admin->item_cancelled_quantity($row['row_id']) == $cancelled_qty)); ?>>
											<?php echo $cancelled_qty; ?>
										</option>
									<?php } while($cancelled_qty < $row['quantity']); ?>
									</select>
								</td>
								
								<td class="align_ctr">
								<?php 
									// If an item discount exists, strike out the standard item total and display the discounted item total.
									if ($row['discount_quantity'] > 0)
									{
										echo '<span class="strike">'.$row['price_total'].'</span><br/>';
										echo $row['discount_price_total'];
									}
									// Else, display item total as normal.
									else
									{
										echo $row['price_total'];
									}
								?>
								</td>
							</tr>
						<?php 
							// To display a description of the discount, this example submits a 2nd parameter to the item_discount_status() function.
							// This sets the function to show item shipping discounts as well as the standard item price discounts. 
							if ($this->flexi_cart_admin->item_discount_status($row['row_id'], FALSE)) { 
						?>
							<tr class="discount">
								<td colspan="6">
									Discount: <?php echo $row['discount_description'];?>
									: <a href="<?php echo $base_url; ?>admin_library/unset_discount/<?php echo $this->flexi_cart_admin->item_discount_id($row['row_id']).'/'.$order_number;?>">Remove</a>
								</td>
							</tr>
						<?php } } } else { ?>
							<tr>
								<td colspan="6" class="empty">
									<h4>No tienes articulos en el carro</h4>
								</td>
							</tr>
						<?php } ?>
						</tbody>
						<tfoot>
						<?php if ($this->flexi_cart_admin->item_summary_savings_total(FALSE) > 0) { ?>
							<tr class="discount">
								<th colspan="5">Resumen Total descuentos</th> 
								<td><?php echo $this->flexi_cart_admin->item_summary_savings_total();?></td>
							</tr>
						<?php } ?>
							<tr>
								<th colspan="5">Resumen Total</th>
								<td><?php echo $this->flexi_cart_admin->item_summary_total();?></td>
							</tr>
						</tfoot>
					</table>
				</fieldset>
				
				<fieldset>
					<legend>Resumen del carro</legend>
					<table id="cart_summary">
						<tbody>
							<tr>
								<td>
									Puntos fidelidad Ganados
								</td>
								<td>
									<?php echo $this->flexi_cart_admin->total_reward_points();?> points
								</td>
							</tr>
							<tr>
								<td>
									Peso Total
								</td>
								<td>
									<?php echo $this->flexi_cart_admin->total_weight();?>
								</td>
							</tr>
							<tr>
								<td>
									Resumen Articulos Total
								</td>
								<td>
									<?php echo $this->flexi_cart_admin->item_summary_total(TRUE, TRUE, TRUE);?>
								</td>
							</tr>
							<tr>
								<td>
									Opciones de envion : 
									<select name="shipping">
										<option value="0"> - Opciones de envios - </option>
									<?php 
										if (! empty($update_shipping_options)) {
											foreach($update_shipping_options as $shipping) { 
									?>
										<option value="<?php echo $shipping['id'];?>" <?php echo set_select('shipping', $shipping['id'], ($shipping['id'] == $this->flexi_cart_admin->shipping_id())); ?>>
											<?php echo $shipping['name']." : ".$shipping['description'];?>
										</option>
									<?php } } else { ?>
										<option value="0" <?php echo set_select('shipping', 0, (0 == $this->flexi_cart_admin->shipping_id())); ?>>
											Se cotizara antes de enviar la mercancia.
										</option>
									<?php } ?>
									</select>
								</td>
								<td>
									<?php echo $this->flexi_cart_admin->shipping_total(TRUE, TRUE, TRUE);?>
								</td>
							</tr>
															
						<?php if ($this->flexi_cart_admin->summary_discount_status()) { ?>
							<tr class="discount">
								<th>Resumen Descuentos</th>
								<td>&nbsp;</td>
							</tr>
							
						<?php if ($this->flexi_cart_admin->item_summary_discount_status()) { ?>
							<!-- 
								Rather than repeating the descriptions of each item discount listed via the cart, 
								this example summarises the discount totals of all items.
							-->
							<tr class="discount">
								<th>
									<span class="pad_l_20">
										&raquo; Descuentos de articulo
									</span>
								</th>
								<td>
									<?php echo $this->flexi_cart_admin->item_summary_savings_total();?>
								</td>
							</tr>
						<?php } ?>
							
							<!-- 
								This example uses the 'summary_discount_data()' function to return an array of summary discount values and descriptions.
								An alternative to using a custom loop to return this discount array, is to call the 'summary_discount_description()' function,
								which will return a formatted string of all summary discounts. 
							-->
						<?php foreach($update_discounts as $discount) { ?>
							<tr class="discount">
								<th>
									<span class="pad_l_20">
										&raquo; <?php echo $discount['description'];?>
									<?php if (! empty($discount['id'])) { ?>
										: <a href="<?php echo $base_url; ?>admin_library/unset_discount/<?php echo $discount['id'].'/'.$order_number; ?>">Eliminar</a>
									<?php } ?>
									</span>
								</th>
								<td><?php echo $discount['value'];?></td>
							</tr>
						<?php } ?>
							<tr class="discount">
								<th>Descuentos dobre el Total</th>
								<td><?php echo $this->flexi_cart_admin->cart_savings_total();?></td>
							</tr>
						<?php } ?>

							
						<?php if ($this->flexi_cart_admin->surcharge_status()) { ?>
							<tr class="surcharge">
								<th>Resumen Sobrecostos</th>
								<td>&nbsp;</td>
							</tr>
							
							<!-- 
								This example uses the 'surcharge_data()' function to return an array of surcharge values and descriptions.
								An alternative to using a custom loop to return this surcharge array, is to call the 'surcharge_description()' function,
								which will return a formatted string of all surcharges.
							-->
						<?php foreach($update_surcharges as $surcharge) { ?>
							<tr class="surcharge">
								<th>
									<span class="pad_l_20">
										&raquo; <?php echo $surcharge['description'];?>
										: <a href="<?php echo $base_url; ?>admin_library/unset_surcharge/<?php echo $surcharge['id'].'/'.$order_number; ?>">Eliminar</a>
									</span>
								</th>
								<td><?php echo $surcharge['value'];?></td>
							</tr>
						<?php } ?>
							<tr class="surcharge">
								<th>Total Sobrecargos</th>
								<td><?php echo $this->flexi_cart_admin->surcharge_total();?></td>
							</tr>
						<?php } ?>

						<?php if ($this->flexi_cart_admin->reward_voucher_status()) { ?>
							<tr class="voucher">
								<th>Resumen Vales Descuento</th>
								<td>&nbsp;</td>
							</tr>
							
							<!-- This example uses the 'reward_voucher_data()' function to return an array of reward voucher values and descriptions. -->
						<?php foreach($update_reward_vouchers as $voucher) { ?>
							<tr class="voucher">
								<th>
									<span class="pad_l_20">
										&raquo; <?php echo $voucher['description'];?>
										: <a href="<?php echo $base_url; ?>admin_library/unset_discount/<?php echo $voucher['id'].'/'.$order_number; ?>">Remove</a>
									</span>
								</th>
								<td><?php echo $voucher['value'];?></td>
							</tr>
						<?php } ?>
							<tr class="voucher">
								<th>Total Vales Descuento</th>
								<td><?php echo $this->flexi_cart_admin->reward_voucher_total();?></td>
							</tr>
						<?php } ?>
						
						</tbody>
						<tfoot>
							<tr>
								<th>Sub Total </th>
								<td><?php echo $this->flexi_cart_admin->sub_total(TRUE, TRUE, TRUE);?></td>
							</tr>
							<tr>
								<th>
									<?php echo $this->flexi_cart_admin->tax_name()." @ ".$this->flexi_cart_admin->tax_rate();?>
								</td>
								<td>
									<?php echo $this->flexi_cart_admin->tax_total(TRUE, TRUE, TRUE);?>
								</td>
							</tr>
							<tr class="grand_total">
								<th>Gran Total</th>
								<td><?php echo $this->flexi_cart_admin->total(TRUE, TRUE, TRUE);?></td>
							</tr>
						</tfoot>
					</table>
					
					<input type="submit" name="update_order[order]" value="Actualizar carro (Sin Guardar)" class="link_button large"/>
					<input type="submit" name="update_order[save]" value="Guardar Carro como Pedido" class="link_button red large"/>
				</fieldset>

				<fieldset>
					<legend>Descuentos / Vales / Sobrecargos</legend>
					<br/>

					<input type="button" value="Show / Hide" class="link_button toggle"/>
					<div class="hide_toggle">
						<hr/>
						<h3 class="caption">Descuentos / Codigo Vales</h3>
						<ul class="frame_note">
						<?php 
							// Get an array of all discount codes. The returned array keys are 'id', 'code' and 'description'.
							if ($discount_data = $this->flexi_cart_admin->discount_codes()) {
								foreach($discount_data as $discount_codes) {
						?>
							<li>
								<input type="text" name="discount_code[<?php echo $discount_codes['code']; ?>]" value="<?php echo $discount_codes['code']; ?>"/> 
								<input type="submit" name="update_discount" value="Actualizar" class="link_button grey"/>
								<input type="submit" name="remove_discount_code[<?php echo $discount_codes['code']; ?>]" value="Eliminar" class="link_button grey"/>
								<small class="inline">* <?php echo $discount_codes['description'];?></small>
							</li>
						<?php
								}
							}
						?>
							<li>
								<input type="text" name="discount_code[0]" value=""/> 
								<input type="submit" name="update_order[discount_code]" value="Añadir Codigo Promocional" class="link_button"/> 
							</li>
						</ul>
														
						<table>
							<caption>Aplicar Nuevos Sescuentos</caption>
							<thead>
								<tr>
									<th class="tooltip_trigger" 
										title="Breve descripción del descuento.">
										Descripcion
									</th>
									<th class="spacer_200 align_ctr tooltip_trigger" 
										title="Indica a que partida se aplicara el descuento.">
										Partida
									</th>
									<th class="spacer_200 align_ctr tooltip_trigger" 
										title="Porcentaje o importe del descuento.">
										Valor
									</th>
									<th class="spacer_125 align_ctr tooltip_trigger" 
										title="Copiar o Eliminar una fila y sus datos.">
										Copiar / Eliminar
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<input type="text" name="discount[0][description]" placeholder="Añadir Nuevo Descuento" class="width_300"/>
									</td>
									<td class="align_ctr">
										<!-- 
											Note the select option values are the valid column names required by the 'set_discount()' function.
											'item_summary_total' = apply discount to total of all items only, 
											'shipping_total' = apply discount to total of shipping only, 'total' = apply discount to total of entire cart.
										-->
										<select name="discount[0][column]" class="width_175">
											<option value="item_summary_total">Valor Total Articulos</option>
											<option value="shipping_total">Valor Envio</option>
											<option value="total">Gran Total</option>
										</select>
									</td>
									<td class="align_ctr">
										<input type="text" name="discount[0][value]" value="0" class="width_50 align_ctr validate_decimal"/>
										
										<!-- 
											Note the select option values are the valid calculation method ids required by the 'set_discount()' function.
											1 = percentage based discounts, 2 = flat rate discounts, 3 = new value (Can only be applied to shipping total).
										-->
										<select name="discount[0][calculation]" class="width_100">
											<option value="1">Porcentaje</option>
											<option value="2">Valor</option>
											<option value="3">Nuevo Valor</option>
										</select>
									</td>
									<td class="align_ctr">
										<input type="button" value="+" class="copy_row link_button"/>
										<input type="button" value="x" disabled="disabled" class="remove_row link_button"/>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4">
										<small>
											Nota: 'Nuevo Valor' solo puede aplicarse a la columna Total Envio.
										</small>
									</td>
								</tr>
							</tfoot>
						</table>
						
						<table>
							<caption>Aplicar Nuevos Sobrecargos</caption>
							<thead>
								<tr>
									<th class="tooltip_trigger" 
										title="Descripcion del sobrecargo.">
										Description
									</th>
									<th class="spacer_100 align_ctr tooltip_trigger" 
										title=" porcentaje de impuestos aplicados al sobrecargo, si no se especifica que aplicara el impuesto por defecto del carro.">
										Tax Rate
									</th>
									<th class="spacer_300 align_ctr tooltip_trigger" 
										title="Porcentaje o importe del sobrecargo.">
										Value
									</th>
									<th class="spacer_125 align_ctr tooltip_trigger" 
										title="Copiar o Eliminar una fila y sus datos.">
										Copy / Remove
									</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										<input type="text" name="surcharge[0][description]" placeholder="Add New Surcharge" class="width_300"/>
									</td>
									<td class="align_ctr">
										<input type="text" name="surcharge[0][tax_rate]" value="" placeholder="default" class="width_50 align_ctr validate_decimal"/>
									</td>
									<td class="align_ctr">
										<input type="text" name="surcharge[0][value]" value="0" class="width_50 align_ctr validate_decimal"/>
										
										<!-- 
											Note the select option values are the valid column names required by the 'set_surcharge()' function.
											Blank = flat rate surcharge to grand total, 'item_summary_total' = a percentage surcharge on item total only,
											'shipping_total' = a percentage surcharge on shipping total only, 'total' = a percentage surcharge on total of entire cart.
										-->
										<select name="surcharge[0][column]" class="width_225">
											<option value="">Importe fijo sobre Gran Total</option>
											<option value="item_summary_total">% Sobre Total Articulos</option>
											<option value="shipping_total">% Soobre Total Envio</option>
											<option value="total">% Sobre el Gran Total</option>
										</select>
									</td>
									<td class="align_ctr">
										<input type="button" value="+" class="copy_row link_button"/>
										<input type="button" value="x" disabled="disabled" class="remove_row link_button"/>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td colspan="4">
										&nbsp;
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
				</fieldset>
			<?php echo form_close(); ?>

		</div>
	</div>
	
	<!-- Footer -->  
	<?php $this->load->view('includes/footer'); ?> 
</div>

<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 

</body>
</html>