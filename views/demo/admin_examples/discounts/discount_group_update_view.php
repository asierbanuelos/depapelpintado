<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Actualizar grupo de descuento</title>
	<meta name="description" content=""/> 
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?> 
</head>

<body id="discount_group_update">

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
				<h1>Grupos de descuento y artículos</h1>
				<p>
					<a href="<?php echo $base_url; ?>admin_library/discount_groups">Administrar grupos de descuento</a> | 
					<a href="<?php echo $base_url; ?>admin_library/insert_discount_group_items/<?php echo $group_data[$this->flexi_cart_admin->db_column('discount_groups', 'id')]; ?>">Añadir artículos al grupo de descuento</a>
				</p>	
				
				<table>
					<caption>Grupo de descuento</caption>
					<thead>
						<tr>
							<th class="info_req tooltip_trigger"
								title="<strong>Campo requerido</strong><br/>Nombre del grupo.">
								Nombre
							</th>
							<th class="spacer_100 align_ctr tooltip_trigger" 
								title="Si esta marcado, el grupo está activo.">
								Estado
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<input type="text" name="update_group[name]" value="<?php echo set_value('update_group[name]', $group_data[$this->flexi_cart_admin->db_column('discount_groups', 'name')]); ?>" class="width_250"/>
							</td>
							<td class="align_ctr">
								<?php $status = (bool) $group_data[$this->flexi_cart_admin->db_column('discount_groups', 'status')]; ?>
								<input type="hidden" name="update_group[status]" value="0"/>
								<input type="checkbox" name="update_group[status]" value="1" <?php echo set_checkbox('update_group[status]','1', $status); ?>/>
							</td>
						</tr>
					</tbody>
				</table>
				
				<table>
					<caption>Arctículos del grupo</caption>
					<thead>
						<tr>
							<th>Nombre del Artículo</th>
							<th class="spacer_100 align_ctr tooltip_trigger" 
								title="Si marcado , sera borrado al actualizar.">
								Delete
							</th>
						</tr>
					</thead>
				<?php if (! empty($group_item_data)) { ?>	
					<tbody>
					<?php 
						foreach($group_item_data as $item) { 
							$item_id = $item['item_id'];
					?>
						<tr>
							<td>
								<input type="hidden" name="delete_item[<?php echo $item_id;?>][id]" value="<?php echo $item[$this->flexi_cart_admin->db_column('discount_group_items', 'id')]; ?>"/>
								<?php echo $item['item_ref']; ?>
							</td>
							<td class="align_ctr">
								<input type="hidden" name="delete_item[<?php echo $item_id;?>][delete]" value="0"/>
								<input type="checkbox" name="delete_item[<?php echo $item_id;?>][delete]" value="1"/>
							</td>
						</tr>
					<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="2">
								<input type="submit" name="update_discount_group_items" value="Actualizar Grupo y artículos" class="link_button large"/>
							</td>
						</tr>
					</tfoot>
				<?php } else { ?>
					<tbody>
						<tr>
							<td colspan="2">
								No hay artículos para mostrar en este grupo.<br/>
								<a href="<?php echo $base_url; ?>admin_library/insert_discount_group_items/<?php echo $group_data[$this->flexi_cart_admin->db_column('discount_groups', 'id')]; ?>">Insert Items to Discount Item Group</a>								
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