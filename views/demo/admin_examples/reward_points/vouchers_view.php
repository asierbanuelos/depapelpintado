<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Administrar Vales descuento</title>
	<meta name="description" content=""/> 
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?> 
</head>

<body id="vouchers">
<?php $this->load->view('includes/demo_header'); ?> 
<div class="container">
	
	<!-- Demo Navigation -->
	
	
	<!-- Intro Content -->
	<div class="container">
		<div class="content clearfix">
			<div class="intro_text">
				<h1>Vales descuento</h1>
				
			</div>		
		</div>
	</div>
	
	<!-- Main Content -->
	<div class="container">
		<div class="content clearfix">
		
		<?php if (! empty($message)) { ?>
			<div id="message">
				<?php echo $message; ?>
			</div>
		<?php } ?>
										
			<?php echo form_open(current_url());?>
				<?/*<p><a href="<?php echo $base_url; ?>admin_library/user_reward_points">Manage Reward Points</a></p>*/?>
				
				<table>
					<thead>
						<tr>
							<th class="tooltip_trigger"
								title="El codigo para aplicar el descuento.">
								Código
							</th>
							<th class="spacer_225 tooltip_trigger"
								title="Usuario al que pertenece el codigo.">
								Usuario
							</th>
							<th class="spacer_100 align_ctr tooltip_trigger"
								title="Indica si ha sido Utilizado.">
								Disponibilidad
							</th>
							<th class="spacer_100 align_ctr tooltip_trigger"
								title="El valor monetario del vale.">
								Valor
							</th>
							<th class="spacer_100 align_ctr tooltip_trigger"
								title="Fecha de expiración.">
								Valido Hasta
							</th>
							<th class="spacer_100 align_ctr tooltip_trigger" 
								title="Si esta marcado el vale esta disponible.">
								Estado
							</th>
						</tr>
					</thead>
				<?php if (! empty($voucher_data)) { ?>	
					<tbody>
					<?php 
						foreach ($voucher_data as $row) {
							$voucher_id = $row[$this->flexi_cart_admin->db_column('discounts', 'id')];
					?>
						<tr>
							<td>
								<input type="hidden" name="update[<?php echo $voucher_id; ?>][id]" value="<?php echo $row[$this->flexi_cart_admin->db_column('discounts', 'id')]?>"/>
								<?php echo $row[$this->flexi_cart_admin->db_column('discounts', 'code')]; ?>
							</td>
							<td>
								<?php echo $row['email']; ?>
							</td>
							<td class="align_ctr">
							<?php if ($row[$this->flexi_cart_admin->db_column('discounts', 'usage_limit')] > 0) { ?>
								Disponible
							<?php } else { ?>
								Usado
							<?php } ?>
							</td>
							<td class="align_ctr">
								<?php echo $row[$this->flexi_cart_admin->db_column('discounts', 'value_discounted')]; ?> &euro;
							</td>
							<td class="align_ctr">
								<?php echo date('jS M Y', strtotime($row[$this->flexi_cart_admin->db_column('discounts', 'expire_date')])); ?>
							</td>
							<td class="align_ctr">
								<?php $status = (bool)$row[$this->flexi_cart_admin->db_column('discounts', 'status')]; ?>
								<input type="hidden" name="update[<?php echo $voucher_id; ?>][status]" value="0"/>
								<input type="checkbox" name="update[<?php echo $voucher_id; ?>][status]" value="1" <?php echo set_checkbox('update['.$voucher_id.'][status]','1', $status); ?>/>
							</td>
						</tr>
					<?php } ?>
					</tbody>
					<tfoot>
						<tr>
							<td colspan="6">
								<input type="submit" name="update_vouchers" value="Guardar Cambios" class="link_button large"/>
							</td>
						</tr>
					</tfoot>
				<?php } else { ?>
					<tbody>
						<tr>
							<td colspan="6">
								No hay vales disponibles.
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