<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Manage Orders | flexi cart | A Shopping Cart Library for CodeIgniter</title>
	<meta name="description" content="A live working demo of flexi carts order management functions."/> 
	<meta name="keywords" content="orders, flexi cart, shopping cart, codeigniter"/>
	<?php $this->load->view('includes/head'); ?> 
</head>

<body id="order_view">

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
										
			<h1>Manage Orders</h1>
			
			<table>
				<thead>
					<tr>
						<th class="spacer_125">nº Pedido</th>
						<th>Nombre Cliente</th>
						<th class="spacer_100 align_ctr">Total Artículos</th>
						<th class="spacer_100 align_ctr">Total Importe</th>
						<th class="spacer_100 align_ctr">Fecha</th>
						<th class="spacer_125 align_ctr">Estado</th>
					</tr>
				</thead>
				<tbody>
			<?php if (! empty($order_data)) { ?>	
				<?php 
					foreach ($order_data as $row) { 
						$order_number = $row[$this->flexi_cart_admin->db_column('order_summary', 'order_number')];
				?>
					<tr>
						<td>
							<a href="<?php echo $base_url; ?>admin_library/order_details/<?php echo $order_number; ?>"><?php echo $order_number; ?></a>
						</td>
						<td>
							<?php echo $row['ord_demo_bill_name']; ?>
						</td>
						<td class="align_ctr">
							<?php echo number_format($row[$this->flexi_cart_admin->db_column('order_summary', 'total_items')]); ?>
						</td>
						<td class="align_ctr">
							<?php echo '&pound;'.$row[$this->flexi_cart_admin->db_column('order_summary', 'total')]; ?>
						</td>
						<td class="align_ctr">
							<?php echo date('jS M Y', strtotime($row[$this->flexi_cart_admin->db_column('order_summary', 'date')])); ?>
						</td>
						<td class="align_ctr">
							<?php echo $row[$this->flexi_cart_admin->db_column('order_status', 'status')]; ?>
						</td>
					</tr>
				<?php } } else { ?>
					<tr>
						<td colspan="6">
							No hay pedidos para ver.
						</td>
					</tr>
				<?php } ?>
				</tbody>
			</table>				

		</div>
	</div>
	
	<!-- Footer -->  
	<?php $this->load->view('includes/footer'); ?> 
</div>

<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 

</body>
</html>