<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Update Shipping Option Rates | flexi cart | A Shopping Cart Library for CodeIgniter</title>
	<meta name="description" content="A live working demo of flexi carts update shipping option rates function."/> 
	<meta name="keywords" content="update, shipping option rates, flexi cart, shopping cart, codeigniter"/>
	<?php $this->load->view('includes/admin_head'); ?> 
</head>

<body id="shipping_rate_update">

<div id="body_wrap">
	<!-- Header -->  
	<?php $this->load->view('includes/header'); ?> 

	<!-- Demo Navigation -->
	<?php $this->load->view('includes/demo_header'); ?> 
	
	<!-- Main Content -->
	<div class="container">
		<div class="content clearfix">
		
		<?php if (! empty($message)) { ?>
			<div id="message">
				<?php echo $message; ?>
			</div>
		<?php } ?>
										
			<?php echo form_open(current_url());?>
				<h1>Tarifas de Envio para <?php echo $shipping_data[$this->flexi_cart_admin->db_column('shipping_options', 'name')];?></h1>
				<p>
					<a href="<?php echo $base_url; ?>admin_library/shipping">Administrar Opciones de Envio</a> | 
					<a href="<?php echo $base_url; ?>admin_library/insert_shipping_rate/<?php echo $shipping_data[$this->flexi_cart_admin->db_column('shipping_options', 'id')];?>">Añadir Nueva Tarifa de Envio</a>
				</p>

				<table>
					<thead>
						<tr>
							<th class="spacer_100 info_req tooltip_trigger"
								title="<strong>Campo requerido</strong><br/>Precio del envio para el nivel.">
								Precio (&euro;)
							</th>
							<th class="tooltip_trigger"
								title="Representa el peso de los materiales necesarios para el embalaje. Se activa cuando el peso del pedido esta entre los limites siguientes">
								Tara (g)
							</th>
							<th class="tooltip_trigger"
								title="Representa el peso minimo para que el pedido entre a formar parte de este nivel. <br/>Nota: Nota la tara sera inclida al calcular el peso de los articulos.">
								Peso Minimo (g)
							</th>
							<th class="tooltip_trigger"
								title="Representa el peso máximo para que el pedido entre a formar parte de este nivel. <br/>Nota: Nota la tara sera inclida al calcular el peso de los articulos.">
								Peso Máximo (g)
							</th>
							<th class="tooltip_trigger"
								title="Representa el valor minimo para que el pedido entre a formar parte de este nivel.">
								Valor Minimo (&euro;)
							</th>
							<th class="tooltip_trigger"
								title="Representa el valor minimo para que el pedido entre a formar parte de este nivel.">
								Valor Máximo (&euro;)
							</th>
							<th class="spacer_75 align_ctr tooltip_trigger" 
								title="Si se marca, el Nivel sera marcado como activo.">
								Estado
							</th>
							<th class="spacer_125 align_ctr tooltip_trigger" 
								title="Copiar o eliminar la fila y sus datos.">
								Copiar / Eliminar
							</th>
						</tr>
					</thead>
				<?php if (! empty($shipping_rate_data)) { ?>	
					<tbody>
					<?php 
						foreach ($shipping_rate_data as $row) {
							$shipping_rate_id = $row[$this->flexi_cart_admin->db_column('shipping_rates', 'id')];
					?>
						<tr>
							<td>
								<input type="hidden" name="update[<?php echo $shipping_rate_id; ?>][id]" value="<?php echo $shipping_rate_id; ?>"/>
								<input type="hidden" name="update[<?php echo $shipping_rate_id; ?>][parent_id]" value="<?php echo $row[$this->flexi_cart_admin->db_column('shipping_rates', 'parent')]; ?>"/>
								<input type="text" name="update[<?php echo $shipping_rate_id; ?>][value]" value="<?php echo set_value('update['.$shipping_rate_id.'][value]',$row[$this->flexi_cart_admin->db_column('shipping_rates', 'value')]); ?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="update[<?php echo $shipping_rate_id; ?>][tare_weight]" value="<?php echo set_value('update['.$shipping_rate_id.'][tare_weight]',$row[$this->flexi_cart_admin->db_column('shipping_rates', 'tare_weight')]); ?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="update[<?php echo $shipping_rate_id; ?>][min_weight]" value="<?php echo set_value('update['.$shipping_rate_id.'][min_weight]',$row[$this->flexi_cart_admin->db_column('shipping_rates', 'min_weight')]); ?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="update[<?php echo $shipping_rate_id; ?>][max_weight]" value="<?php echo set_value('update['.$shipping_rate_id.'][max_weight]',$row[$this->flexi_cart_admin->db_column('shipping_rates', 'max_weight')]); ?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="update[<?php echo $shipping_rate_id; ?>][min_value]" value="<?php echo set_value('update['.$shipping_rate_id.'][min_value]',$row[$this->flexi_cart_admin->db_column('shipping_rates', 'min_value')]); ?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="update[<?php echo $shipping_rate_id; ?>][max_value]" value="<?php echo set_value('update['.$shipping_rate_id.'][max_value]',$row[$this->flexi_cart_admin->db_column('shipping_rates', 'max_value')]); ?>" class="width_50 validate_decimal"/>
							</td>
							<td class="align_ctr">
								<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('shipping_rates', 'status')]; ?>
								<input type="hidden" name="update[<?php echo $shipping_rate_id; ?>][status]" value="0"/>
								<input type="checkbox" name="update[<?php echo $shipping_rate_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$shipping_rate_id.'][status]','1', $status); ?>/>
							</td>
							<td class="align_ctr">
								<input type="hidden" name="update[<?php echo $shipping_rate_id; ?>][delete]" value="0"/>
								<input type="checkbox" name="update[<?php echo $shipping_rate_id; ?>][delete]" value="1"/>
							</td>
						</tr>
					<?php } ?>	
					</tbody>
					<tfoot>
						<tr>
							<td colspan="8">
								<input type="submit" name="update_shipping_rates" value="Actualizar Tarifas de Envio" class="link_button large"/>
							</td>
						</tr>
					</tfoot>
				<?php } else { ?>
					<tbody>
						<tr>
							<td colspan="8">
								No hay tarifas de envio Configuradas.<br/>
								<a href="<?php echo $base_url; ?>admin_library/insert_shipping_rate/<?php echo $shipping_data[$this->flexi_cart_admin->db_column('shipping_options', 'id')];?>">Insert New Shipping Rate</a>
							</td>
						</tr>
					</tbody>
				<?php } ?>
				</table>
			<?php echo form_close();?>						

		</div>
	</div>
	
	<!-- Footer -->  
	<?php $this->load->view('includes/footer'); ?> 
</div>

<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 

</body>
</html>