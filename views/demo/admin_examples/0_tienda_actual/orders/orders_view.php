<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>PEDIDOS</title>
	<meta name="description" content=""/> 
	<meta name="keywords" content="orders, flexi cart, shopping cart, codeigniter"/>
    <style>.estado a{color:#000;text-decoration: none;width:100%;height: 100%;display: block}</style>
	<?php $this->load->view('includes/admin_head'); ?> 
</head>

<body id="order_view">

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
										
			<h1 style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">Administrar Pedidos</h1>
			<table>
				<tbody>
					<tr>
                      <td class="estado"><a href="<?=base_url()?>admin_library/orders">Todos</a></td>
                      <td class="estado"><a href="<?=base_url()?>admin_library/orders/1">Esperando Pago</a></td>
                      <td class="estado"><a href="<?=base_url()?>admin_library/orders/2">Nuevo Pedido</a></td>
                      <td class="estado"><a href="<?=base_url()?>admin_library/orders/3">Procesando Pedido</a></td>
                      <td class="estado"><a href="<?=base_url()?>admin_library/orders/4">Pedido Completado</a></td>
                      <td class="estado"><a href="<?=base_url()?>admin_library/orders/5">Pedido Cancelado</a></td>
						
					</tr>
				</tbody>
                
            </table><br>
			<table>
				<thead>
					<tr>
						<th class="spacer_125">nº Pedido</th>
						<th>Nombre Cliente</th>
						<th class="spacer_100 align_ctr">Total Artículos</th>
						<th class="spacer_100 align_ctr">Total Importe</th>
						<th class="spacer_100 align_ctr">Fecha</th>
						<th class="spacer_125 align_ctr">Estado</th>
                                                <th>Factura/Ticket</th>
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
							<?php if($row['ord_demo_bill_name']!="")echo $row['ord_demo_bill_name']; else if($row['ord_demo_ship_name']!="") echo $row['ord_demo_ship_name']; else echo $row['ord_demo_email'];?>
						</td>
						<td class="align_ctr">
							<?php echo number_format($row[$this->flexi_cart_admin->db_column('order_summary', 'total_items')]); ?>
						</td>
						<td class="align_ctr">
							<?php echo $row[$this->flexi_cart_admin->db_column('order_summary', 'total')].' &euro;'; ?>
						</td>
						<td class="align_ctr">
							<?php echo date('jS M Y', strtotime($row[$this->flexi_cart_admin->db_column('order_summary', 'date')])); ?>
						</td>
						<td class="estado align_ctr">
							<?php echo $row[$this->flexi_cart_admin->db_column('order_status', 'status')]; 
                                                        if(($row[$this->flexi_cart_admin->db_column('order_status', 'status')]=="Pedido Enviado" || $row[$this->flexi_cart_admin->db_column('order_status', 'status')]=="Procesando Pedido") && $row['ord_demo_bill_company']!=""){
    if($row['factura']=="0") echo "(Facturable)"; else echo "(Facturado)";                                                       
                                                        } ?>
						</td>
                                                <td>
<? 
if($row['factura']!="0") {echo anchor("admin_library/ver_factura/".$order_number,"FACTURA");}
if($row['factura_rect']!="0") {echo "<br />".anchor("admin_library/ver_factura_rect/".$order_number,"FACTURA RECT");}
else if($row['factura2']!="0") {echo anchor("admin_library/ver_ticket/".$order_number,"TTCKET");}
?>
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
	
</div>

<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 
<script>
$(".estado").each(function(){
    var t=$(this).text();
            t=t.replace("(Facturable)","").replace("(Facturado)","");
  if(t.trim()==="Esperando Pago")$(this).css("background-color","#aa5");
  if(t.trim()==="Nuevo Pedido" || $(this).text().trim()==="Pago recibido")$(this).css("background-color","#5a5");
  if(t.trim()==="Procesando Pedido")$(this).css("background-color","#5aa");
  if(t.trim()==="Pedido Cancelado")$(this).css("background-color","#a55");
  if(t.trim()==="Pedido Completado" || t.trim()==="Pedido Enviado")$(this).css("background-color","#a8a");
})
</script>
</body>
</html>