<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Insert Order Status | flexi cart | A Shopping Cart Library for CodeIgniter</title>
	<meta name="description" content="A live working demo of flexi carts insert order status function."/> 
	<meta name="keywords" content="insert, order status, flexi cart, shopping cart, codeigniter"/>
	<?php $this->load->view('includes/admin_head'); ?> 
</head>

<body id="order_status_insert">

<div id="body_wrap">
	
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
				<h1>Introducir Nuevo Estado de Pedido</h1>
				<p><a href="<?php echo $base_url; ?>admin_library/order_status">Administrar Estado de Pedido</a></p>
			
				<table>
					<thead>
						<tr>
							<th class="info_req tooltip_trigger"
								title="Nombre / Descripción del Estado de Pedido.">
								Descrición de Estado
							</th>
							<th class="spacer_125 align_ctr tooltip_trigger" 
								title="Si se marca, indica que este estado cancela la orden de Pedido.">
								Cancelar Pedido
							</th>
							<th class="spacer_125 align_ctr tooltip_trigger" 
								title="Si se marca, indica que este es el estado por defecto de los pedidos 'Guardados'.">
								Por defecto Guardar
							</th>
							<th class="spacer_125 align_ctr tooltip_trigger" 
								title="Si se marca, indica que este es el estado por defecto de los pedidos 'ReGuardados'.">
								Por defecto ReGuardar
							</th>
							<th class="spacer_125 align_ctr tooltip_trigger" 
								title="Copy or remove a specific row and its data.">
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
								<input type="text" name="insert[<?php echo $row_id; ?>][status]" value="<?php echo set_value('insert['.$row_id.'][status]');?>" class="width_200"/>
							</td>
							<td class="align_ctr">
								<input type="hidden" name="insert[<?php echo $row_id; ?>][cancelled]" value="0"/>
								<input type="checkbox" name="insert[<?php echo $row_id; ?>][cancelled]" value="1" <?php echo set_checkbox('insert['.$row_id.'][cancelled]', '1', FALSE); ?>/>
							</td>
							<td class="align_ctr">
								<input type="hidden" name="insert[<?php echo $row_id; ?>][save_default]" value="0"/>
								<input type="checkbox" name="insert[<?php echo $row_id; ?>][save_default]" value="1" <?php echo set_checkbox('insert['.$row_id.'][save_default]', '1', FALSE); ?>/>
							</td>
							<td class="align_ctr">
								<input type="hidden" name="insert[<?php echo $row_id; ?>][resave_default]" value="0"/>
								<input type="checkbox" name="insert[<?php echo $row_id; ?>][resave_default]" value="1" <?php echo set_checkbox('insert['.$row_id.'][resave_default]', '1', FALSE); ?>/>
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
							<td colspan="5">
								<input type="submit" name="insert_order_status" value="Introducir Estado de Pedido" class="link_button large"/>
							</td>
						</tr>
					</tbody>
				</table>
			<?php echo form_close();?>						

		</div>
	</div>

</div>

<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 

</body>
</html>