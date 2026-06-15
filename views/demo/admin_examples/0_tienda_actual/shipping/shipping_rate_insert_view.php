<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Insert Shipping Option Rates | flexi cart | A Shopping Cart Library for CodeIgniter</title>
	<meta name="description" content="A live working demo of flexi carts insert shipping option rates function."/> 
	<meta name="keywords" content="insert, shipping option rates, flexi cart, shopping cart, codeigniter"/>
	<?php $this->load->view('includes/admin_head'); ?> 
</head>

<body id="shipping_rate_insert">

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
										
			<?php echo form_open(current_url());?>
				<h1>Añadir Tarifa de envio para <?php echo $shipping_data[$this->flexi_cart_admin->db_column('shipping_options', 'name')];?></h1>
				<p>
					<a href="<?php echo $base_url; ?>admin_library/shipping">Administrar Opciones de Envio</a> | 
					<a href="<?php echo $base_url; ?>admin_library/shipping_rates/<?php echo $shipping_data[$this->flexi_cart_admin->db_column('shipping_options', 'id')];?>">Manage <?php echo $shipping_data[$this->flexi_cart_admin->db_column('shipping_options', 'name')];?> Rates</a>
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
					<tbody>
					<?php 
						for($i = 0; ($i == 0 || (isset($validation_row_ids[$i]))); $i++) { 
							$row_id = (isset($validation_row_ids[$i])) ? $validation_row_ids[$i] : $i;
					?>
						<tr>
							<td>
								<input type="text" name="insert[<?php echo $row_id; ?>][value]" value="<?php echo set_value('insert['.$row_id.'][value]', '0.00');?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="insert[<?php echo $row_id; ?>][tare_weight]" value="<?php echo set_value('insert['.$row_id.'][tare_weight]', '0');?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="insert[<?php echo $row_id; ?>][min_weight]" value="<?php echo set_value('insert['.$row_id.'][min_weight]', '0');?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="insert[<?php echo $row_id; ?>][max_weight]" value="<?php echo set_value('insert['.$row_id.'][max_weight]',' 9999');?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="insert[<?php echo $row_id; ?>][min_value]" value="<?php echo set_value('insert['.$row_id.'][min_value]', '0.00');?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="insert[<?php echo $row_id; ?>][max_value]" value="<?php echo set_value('insert['.$row_id.'][max_value]', '9999.00');?>" class="width_50 validate_decimal"/>
							</td>
							<td class="align_ctr">
								<input type="hidden" name="insert[<?php echo $row_id; ?>][status]" value="0"/>
								<input type="checkbox" name="insert[<?php echo $row_id; ?>][status]" value="1" <?php echo set_checkbox('insert['.$row_id.'][status]', '1', TRUE); ?>/>
							</td>
							<td class="align_ctr">
								<input type="button" value="+" class="copy_row link_button"/>
								<input type="button" value="x" <?php echo ($i == 0) ? 'disabled="disabled"' : NULL;?> class="remove_row link_button"/>
							</td>
						</tr>
					<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="8">
								<input type="submit" name="insert_shipping_rate" value="Añadir Tarifa de Envio" class="link_button large"/>
							</td>
						</tr>
					</tbody>
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