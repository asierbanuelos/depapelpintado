<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Insertar Moneda</title>
	<meta name="description" content=""/> 
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?> 
</head>

<body id="currency_insert">

<div id="body_wrap">
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
				<h1>Añadir Nueva Divisa</h1>
				<p><a href="<?php echo $base_url; ?>admin_library/currency">Gestionar Divisas</a></p>
			
				<table>
					<thead>
						<tr>
							<th class="info_req tooltip_trigger"
								title="Nombre de la divisa.">
								Nombre
							</th>
							<th class="info_req tooltip_trigger"
								title="Valor del cambio con la divisa por defecto de la tienda.">
								Cambio
							</th>
							<th class="info_req tooltip_trigger"
								title="Simbolo que representa la moneda, Ej. '$' para mostrar '$9.99'.">
								Simbolo HTML
							</th>
							<th class="spacer_75 align_ctr tooltip_trigger"
								title="Si se marca el simbolo aparerá como sufijo<br/> Marcado: '9.99&euro;',<br/> Sin Marcar: '&pound;9.99'.">
								Sufijo
							</th>
							<th class="info_req tooltip_trigger"
								title="Caracter para representar los miles.">
								Miles
							</th>
							<th class="info_req tooltip_trigger"
								title="Caracter para representar el punto decimal.">
								Decimal
							</th>
							<th class="spacer_75 align_ctr tooltip_trigger" 
								title="Si se marca la divisa se considerará activa y valida en la tienda.">
								Estado
							</th>
							<th class="spacer_125 align_ctr tooltip_trigger" 
								title="Copiar o eliminar la fila actual y sis datos.">
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
								<input type="text" name="insert[<?php echo $row_id; ?>][name]" value="<?php echo set_value('insert['.$row_id.'][name]');?>" class="width_100"/>
							</td>
							<td>
								<input type="text" name="insert[<?php echo $row_id; ?>][exchange_rate]" value="<?php echo set_value('insert['.$row_id.'][exchange_rate]');?>" class="width_100 validate_decimal"/>
							</td>
							<td>
								<input type="text" name="insert[<?php echo $row_id; ?>][symbol]" value="<?php echo set_value('insert['.$row_id.'][symbol]');?>" class="width_100 validate_alpha"/>
							</td>
							<td class="align_ctr">
								<input type="hidden" name="insert[<?php echo $row_id; ?>][symbol_suffix]" value="0"/>
								<input type="checkbox" name="insert[<?php echo $row_id; ?>][symbol_suffix]" value="1" <?php echo set_checkbox('insert['.$row_id.'][symbol_suffix]', '1'); ?>/>
							</td>
							<td>
								<input type="text" name="insert[<?php echo $row_id; ?>][thousand]" value="<?php echo set_value('insert['.$row_id.'][thousand]');?>" class="width_50 validate_alpha"/>
							</td>
							<td>
								<input type="text" name="insert[<?php echo $row_id; ?>][decimal]" value="<?php echo set_value('insert['.$row_id.'][decimal]');?>" class="width_50 validate_alpha"/>
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
								<input type="submit" name="insert_currency" value="Insertar Nueva Moneda" class="link_button large"/>
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