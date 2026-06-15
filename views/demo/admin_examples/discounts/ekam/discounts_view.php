<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Descuentos EKAM</title>
	<meta name="description" content=""/> 
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?> 
</head>

<body id="discounts">

<div id="body_wrap">
	<!-- Demo Navigation -->
	<?php 
	$this->load->view('includes/demo_header'); 

	$tabla_descuentos='discounts_ekam';
	?> 
	
	<!-- Main Content -->
	<div class="container">
		<div class="content clearfix">
			
		<?php if (! empty($message)) { ?>
			<div id="message">
				<?php echo $message; ?>
			</div>
		<?php } ?>
										
			<?php echo form_open(current_url());?>						
				<h1><?php echo ($discount_type == 'item') ? 'Artículo' : 'Resumen';?> Descuentos EKAM</h1>
				<p>
				<?php if ($discount_type == 'summary') { ?>
					<a href="<?php echo $base_url; ?>admin_library/item_discounts_ekam">Administrar descuentos por artículo EKAM</a> | 
				<?php } else { ?>
					<a href="<?php echo $base_url; ?>admin_library/summary_discounts_ekam">Administrar descuentos por pedido EKAM</a> | 
				<?php } ?>
					<a href="<?php echo $base_url; ?>admin_library/insert_discount_ekam">Añadir Descuento EKAM</a>
				</p>

				<table>
					<thead>
						<tr>
							<th class="spacer_50 align_ctr tooltip_trigger"
								title="Administrar el Descuento.">
								Administrar
							</th>
							<th class="tooltip_trigger"
								title="Breve descripcion del descuento.">
								Descripción
							</th>
							<th class="spacer_50 align_ctr tooltip_trigger"
								title="El numero de articulos que quedan a los que aplicar el descuento.">
								Limite de uso
							</th>
							<th class="spacer_100 align_ctr tooltip_trigger"
								title="Fecha de inicio del descuento.">
								Desde
							</th>
							<th class="spacer_100 align_ctr tooltip_trigger"
								title="Fecha final del descuento.">
								Hasta
							</th>
							<th class="spacer_50 align_ctr tooltip_trigger" 
								title="si está marcado el descuento esta activo.">
								Estado
							</th>
							<th class="spacer_50 align_ctr tooltip_trigger" 
								title="Si esta marcado borrará el descuento al guardar los cambios.">
								Borrar
							</th>
						</tr>
					</thead>
				<?php if (! empty($discount_data)) { ?>	
					<tbody>
					<?php 
						foreach ($discount_data as $row) {
							$discount_id = $row[$this->flexi_cart_admin->db_column($tabla_descuentos, 'id')];
					?>
						<tr>
							<td class="align_ctr">
								<input type="hidden" name="update[<?php echo $discount_id; ?>][id]" value="<?php echo $discount_id; ?>"/>
								<a href="<?php echo $base_url; ?>admin_library/update_discount_ekam/<?php echo $discount_id; ?>">Edit</a>
							</td>
							<td>
								<?php echo $row[$this->flexi_cart_admin->db_column($tabla_descuentos, 'description')]; ?>
							</td>
							<td class="align_ctr">
								<?php echo $row[$this->flexi_cart_admin->db_column($tabla_descuentos, 'usage_limit')]; ?>
							</td>
							<td class="align_ctr">
								<?php echo date('d-m-Y', strtotime($row[$this->flexi_cart_admin->db_column($tabla_descuentos, 'valid_date')])); ?>
							</td>
							<td class="align_ctr">
								<?php echo date('d-m-Y', strtotime($row[$this->flexi_cart_admin->db_column($tabla_descuentos, 'expire_date')])); ?>
							</td>
							<td class="align_ctr">
								<?php $status = (bool)$row[$this->flexi_cart_admin->db_column($tabla_descuentos, 'status')]; ?>
								<input type="hidden" name="update[<?php echo $discount_id; ?>][status]" value="0"/>
								<input type="checkbox" name="update[<?php echo $discount_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$discount_id.'][status]','1', $status); ?>/>
							</td>
							<td class="align_ctr">
								<input type="hidden" name="update[<?php echo $discount_id; ?>][delete]" value="0"/>
								<input type="checkbox" name="update[<?php echo $discount_id; ?>][delete]" value="1"/>
							</td>
						</tr>
					<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="7">
								<input type="submit" name="update_discounts" value="Guardar Cambios" class="link_button large"/>
							</td>
						</tr>
					</tfoot>
				<?php } else { ?>
					<tbody>
						<tr>
							<td colspan="7">
								No hay descuentos disponibles.<br/>
								<a href="<?php echo $base_url; ?>admin_library/insert_discount_ekam">Añadir nuevo descuento</a>
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