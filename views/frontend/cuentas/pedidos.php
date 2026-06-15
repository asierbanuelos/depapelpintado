<div class="wrapper mi-cuenta">
  <div class="container">
    <div class="row ">
      <div class="col-xl-3 col-lg-3 col-md-4 d-none d-md-block">
      </div>
      <div class="col-xl-9 col-lg-9 col-md-8 col-12">
      	<h1 class='titulo-1 border-bottom border-dark pb-2 mb-4'>
					Hola, 
					<?php echo ($this->data['usuario']->ord_demo_ship_name!='')?$this->data['usuario']->ord_demo_ship_name:$this->data['usuario']->ord_demo_bill_name; ?>
					-
					<?php echo $this->data['usuario']->email; ?>
				</h1>
      </div>
		</div>
		<?php 
    $margin_top='mt-2';
    //if (trim($texto_descripcion)!='')
    //  $margin_top='';
		?>
    <div class="row ">
      <div class="col-xl-3 col-lg-3 col-md-4 d-none d-md-block">
        <div class='columna-filtros <?php echo $margin_top; ?>'>
          <?php 
					$this->load->view('frontend/cuentas/menu25', $this->data);
          ?>
        </div>
      </div>
      
      <div class="col-xl-9 col-lg-9 col-md-8 col-12">
				<table>
					<thead>
						<tr>
							<th class="">Nº Pedido</th>
							<th class="text-right">Total Artículos</th>
							<th class="text-right">Total Importe</th>
							<th class="text-center">Fecha</th>
							<th class="" colspan='2'>Estado</th>
						</tr>
					</thead>
					<tbody>
						<?php 
						if (! empty($order_data)) { 
							foreach ($order_data as $row) { 
								$order_number = $row[$this->flexi_cart_admin->db_column('order_summary', 'order_number')];
								?>
								<tr>
									<td>
										<a href="/tienda/mis_pedidos/<?php echo $order_number; ?>"><?php echo $order_number; ?></a>
									</td>
									<td class="text-right">
										<?php echo number_format($row[$this->flexi_cart_admin->db_column('order_summary', 'total_items')]); ?>
									</td>
									<td class="text-right">
										<?php echo number_format($row[$this->flexi_cart_admin->db_column('order_summary', 'total')], 2, ',','.').' &euro;'; ?>
									</td>
									<td class="text-center">
										<?php echo date('d-m-Y', strtotime($row[$this->flexi_cart_admin->db_column('order_summary', 'date')])); ?>
									</td>
									<td class="">
										<?php 
										echo $row[$this->flexi_cart_admin->db_column('order_status', 'status')]; 
										?>
									</td>
									<td class="text-right">
										<?php 
										if ($row[$this->flexi_cart_admin->db_column('order_status', 'id')]==1){
											echo " <a href='/tienda/checkout_compra_ya/".$order_number."' class='boton-opciones m-0'>Pagar</a>";
										}
										?>
									</td>
								</tr>
							<?php 
							} 
						}
						else {
						?>
							<tr>
								<td colspan="6">
									No hay pedidos para ver.
								</td>
							</tr>
						<?php 
						} 
						?>
					</tbody>
				</table>	
      </div>
    </div>		
	</div>
</div>
