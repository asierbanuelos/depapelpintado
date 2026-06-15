<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Insert Shipping Options | flexi cart | A Shopping Cart Library for CodeIgniter</title>
	<meta name="description" content="A live working demo of flexi carts insert shipping options function."/> 
	<meta name="keywords" content="insert, shipping options, flexi cart, shopping cart, codeigniter"/>
	<?php $this->load->view('includes/admin_head'); ?> 
</head>

<body id="shipping_insert">

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
				<h1>Añadir Nueva Opcion de Envio</h1>
				<p><a href="<?php echo $base_url; ?>admin_library/shipping">Administrar Opciones de Envio</a></p>
				
				<table>
					<caption>Shipping Option</caption>
					<thead>
						<tr>
							<th class="info_req tooltip_trigger"
								title="<strong>Nombre: Requerido</strong><br/>Nombre y breve descripción de las opciones de envio.">
								Opción / <br/>Descripcion
							</th>
							<th class="tooltip_trigger"
								title="Seleccionar el area en la que la opcion es aplicable.">
								Area
							</th>
							<th class="tooltip_trigger"
								title="Seleccionar la zona en la que la opcion es aplicable. <br/>Nota: Si un area esta definida esta tiene prioridad sobre la zona.">
								Zona
							</th>
							<th class="spacer_75 align_ctr tooltip_trigger"
								title="Si se marca, apareceran las opciones disponibles dentro del area.">
								Inc. Sub Areas
							</th>
							<th class="align_ctr tooltip_trigger"
								title="Indicar impuestos aplicables sobre el total de los costes de envio aplicables. <br/>Nota: Dejar en blanco para utilizar los valores por defecto.">
								Impuesto (%)
							</th>
							<th class="spacer_75 align_ctr tooltip_trigger"
								title="Si se marca, los descuentos aplicables podrán incluir el valor del porte. <br/>Por ejemplo, podras evitar aplicar un descuento sobre el total de la compra al valor del envio.">
								Descuento
							</th>
							<th class="spacer_75 align_ctr tooltip_trigger" 
								title="Si se marca, la opcion de envio sera marcada como activa.">
								Estado
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<input type="text" name="insert_option[name]" value="<?php echo set_value('insert_option[name]');?>" placeholder="Name" class="width_125"/><br/>
								<textarea name="insert_option[description]" placeholder="Description" class="width_125"><?php echo set_value('insert_option[description]');?></textarea>
							</td>
							<td>
							<?php foreach($locations_tiered as $location_type => $locations) { ?>
								<select name="insert_option[location][]" id="shipping_<?php echo strtolower(url_title($location_type.'_101', 'underscore'));?>" class="width_150">
									<option value="0" class="parent_id_0">- Select <?php echo $location_type; ?> -</option>
								<?php 
									// Note: CI's set_select() function does not return the empty '[]' from the name 'insert_option[location][]'.
									// Therefore, ensure it is set as "set_select('insert_option[location]', $id)".
									foreach($locations as $location) { 
										$id = $location[$this->flexi_cart_admin->db_column('locations', 'id')];
								?>
									<option value="<?php echo $id; ?>" class="parent_id_<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'parent')]; ?>" <?php echo set_select('insert_option[location]', $id); ?>>
										<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'name')]; ?>
									</option>
								<?php } ?>
								</select><br/>
							<?php } ?>
							</td>
							<td>
								<select name="insert_option[zone]" class="width_150">
									<option value="0">Sin Zona de envio</option>
								<?php 
									foreach($shipping_zones as $zone) { 
										$id = $zone[$this->flexi_cart_admin->db_column('location_zones', 'id')];
								?>
									<option value="<?php echo $id; ?>" <?php echo set_select('insert_option[zone]', $id); ?>>
										<?php echo $zone[$this->flexi_cart_admin->db_column('location_zones', 'name')]; ?>
									</option>
								<?php } ?>
								</select>
							</td>
							<td class="align_ctr">
								<input type="hidden" name="insert_option[inc_sub_locations]" value="0"/>
								<input type="checkbox" name="insert_option[inc_sub_locations]" value="1" <?php echo set_checkbox('insert_option[inc_sub_locations]', '1'); ?>/>
							</td>
							<td class="align_ctr">
								<input type="text" name="insert_option[tax_rate]" value="<?php echo set_value('insert_option[tax_rate]');?>" placeholder="Default" class="width_50 validate_decimal"/>
							</td>
							<td class="align_ctr">
								<input type="hidden" name="insert_option[discount_inclusion]" value="0"/>
								<input type="checkbox" name="insert_option[discount_inclusion]" value="1" <?php echo set_checkbox('insert_option[discount_inclusion]', '1'); ?>/>
							</td>
							<td class="align_ctr">
								<input type="hidden" name="insert_option[status]" value="0"/>
								<input type="checkbox" name="insert_option[status]" value="1" <?php echo set_checkbox('insert_option[status]', '1', TRUE); ?>/>
							</td>
						</tr>
					</tbody>
				</table>
				
				<table>
					<caption>Niveles de precio para Envios</caption>
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
								<input type="text" name="insert_rate[<?php echo $row_id; ?>][value]" value="<?php echo set_value('insert_rate['.$row_id.'][value]', '0.00');?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="insert_rate[<?php echo $row_id; ?>][tare_weight]" value="<?php echo set_value('insert_rate['.$row_id.'][tare_weight]', '0');?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="insert_rate[<?php echo $row_id; ?>][min_weight]" value="<?php echo set_value('insert_rate['.$row_id.'][min_weight]', '0');?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="insert_rate[<?php echo $row_id; ?>][max_weight]" value="<?php echo set_value('insert_rate['.$row_id.'][max_weight]',' 9999');?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="insert_rate[<?php echo $row_id; ?>][min_value]" value="<?php echo set_value('insert_rate['.$row_id.'][min_value]', '0.00');?>" class="width_50 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="insert_rate[<?php echo $row_id; ?>][max_value]" value="<?php echo set_value('insert_rate['.$row_id.'][max_value]', '9999.00');?>" class="width_50 validate_decimal"/>
							</td>
							<td class="align_ctr">
								<input type="hidden" name="insert_rate[<?php echo $row_id; ?>][status]" value="0"/>
								<input type="checkbox" name="insert_rate[<?php echo $row_id; ?>][status]" value="1" <?php echo set_checkbox('insert_rate['.$row_id.'][status]', '1', TRUE); ?>/>
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
								<input type="submit" name="insert_shipping" value="Añadir Opción de Envio" class="link_button large"/>
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
<script>
$(function() {
	// As this page is listing multiple tax options all on the same page, and therefore multiple location menus, use the jQuery 'each()' function to call the top level menu of each location type ('Country' in this example). 
	$('select[id^="shipping_country"]').each(function() 
	{
		var elem_id = $(this).attr('id');
		var shipping_id = elem_id.substring(elem_id.lastIndexOf('_')+1);
	
		// !IMPORTANT NOTE: The dependent_menu functions must be called in their reverse order - i.e. the most specific locations first.
		dependent_menu('shipping_state_'+shipping_id, 'shipping_post_zip_code_'+shipping_id, false, true);
		dependent_menu('shipping_country_'+shipping_id, 'shipping_state_'+shipping_id, ['shipping_post_zip_code_'+shipping_id], true);
	});
});
</script>

</body>
</html>