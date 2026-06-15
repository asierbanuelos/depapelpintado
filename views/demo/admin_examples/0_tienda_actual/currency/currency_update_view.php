<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Actualizar Moneda</title>
	<meta name="description" content=""/> 
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?> 
</head>

<body id="currency_update">

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
					<h1>Administrar Divisas</h1>
					<p><a href="<?php echo $base_url; ?>admin_library/insert_currency">Añade una nueva divisa</a></p>

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
					<?php if (! empty($currency_data)) { ?>	
						<tbody>
						<?php 
							foreach ($currency_data as $row) { 
								$currency_id = $row[$this->flexi_cart_admin->db_column('currency', 'id')];
						?>
							<tr>
								<td>
									<input type="hidden" name="update[<?php echo $currency_id; ?>][id]" value="<?php echo $currency_id; ?>"/>
									<input type="text" name="update[<?php echo $currency_id; ?>][name]" value="<?php echo set_value('update['.$currency_id.'][name]', $row[$this->flexi_cart_admin->db_column('currency', 'name')]); ?>" class="width_100"/>
								</td>
								<td>
									<input type="text" name="update[<?php echo $currency_id; ?>][exchange_rate]" value="<?php echo set_value('update['.$currency_id.'][exchange_rate]', round($row[$this->flexi_cart_admin->db_column('currency', 'exchange_rate')],4)); ?>" class="width_100 validate_decimal"/>
								</td>
								<td>
									<?php echo $row[$this->flexi_cart_admin->db_column('currency', 'symbol')]; ?>
								</td>
								<td>
									<input type="text" name="update[<?php echo $currency_id; ?>][symbol]" value="<?php echo set_value('update['.$currency_id.'][symbol]', $row[$this->flexi_cart_admin->db_column('currency', 'symbol')]); ?>" class="width_100 validate_alpha"/>
								</td>
								<td class="align_ctr">
									<?php $symbol_suffix = (bool)$row[$this->flexi_cart_admin->db_column('currency', 'symbol_suffix')]; ?>
									<input type="hidden" name="update[<?php echo $currency_id; ?>][symbol_suffix]" value="0"/>
									<input type="checkbox" name="update[<?php echo $currency_id; ?>][symbol_suffix]" value="1" <?php echo set_checkbox('update['.$currency_id.'][symbol_suffix]','1', $symbol_suffix); ?>/>
								</td>
								<td>
									<input type="text" name="update[<?php echo $currency_id; ?>][thousand]" value="<?php echo set_value('update['.$currency_id.'][thousand]', $row[$this->flexi_cart_admin->db_column('currency', 'thousand_separator')]); ?>" class="width_50 validate_alpha"/>
								</td>
								<td>
									<input type="text" name="update[<?php echo $currency_id; ?>][decimal]" value="<?php echo set_value('update['.$currency_id.'][decimal]', $row[$this->flexi_cart_admin->db_column('currency', 'decimal_separator')]); ?>" class="width_50 validate_alpha"/>
								</td>
								<td class="align_ctr">
									<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('currency', 'status')]; ?>
									<input type="hidden" name="update[<?php echo $currency_id; ?>][status]" value="0"/>
									<input type="checkbox" name="update[<?php echo $currency_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$currency_id.'][status]','1', $status); ?>/>
								</td>
								<td class="align_ctr">
									<input type="hidden" name="update[<?php echo $currency_id; ?>][delete]" value="0"/>
									<input type="checkbox" name="update[<?php echo $currency_id; ?>][delete]" value="1"/>
								</td>
							</tr>
						<?php } ?>
						</tbody>
						<tfoot>
							<tr>
								<td colspan="9">
									<input type="submit" name="update_currency" value="Actualizar Monedas" class="link_button large"/>
								</td>
							</tr>
						</tfoot>
					<?php } else { ?>
						<tbody>
							<tr>
								<td colspan="9">
									No hay divisas configuradas<br/>
									<a href="<?php echo $base_url; ?>admin_library/insert_currency">Añadir Moneda</a>
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