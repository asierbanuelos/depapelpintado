<?php
if(is_array($summary_data)){
  if(count($summary_data)>0){
    $summary_data=$summary_data[0];
  }
  else{
    redirect("tienda/mis_pedidos");
  }
}
?>
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
				<div class="row">
					<div class="col-xl-6 col-12 mb-4">
						<h2 class="h5 mt-2">Pedido</h2>
						<section class="page-content card card-block p-4 mt-2">
							<table>
								<tr>
									<th>Nº Pedido:</th><td colspan='2'><?php echo $summary_data[$this->flexi_cart_admin->db_column('order_summary', 'order_number')];?></td>
								</tr>
								<tr>
									<th>Fecha:</th><td colspan='2'><?php echo date('d-m-Y', strtotime($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'date')]));?></td>
								</tr>
								<tr>
									<th>Estado:</th>
									<td>
										<?php
											if ($summary_data[$this->flexi_cart_admin->db_column('order_status', 'cancelled')] == 1)
											{
												echo '<strong class="highlight_red">'.$summary_data[$this->flexi_cart_admin->db_column('order_status', 'status')].'</strong>';
											}
											else{
												echo $summary_data[$this->flexi_cart_admin->db_column('order_status', 'status')];									
											}
										?>
									</td>
									<td class='text-right'>
										<?php
											if ($summary_data[$this->flexi_cart_admin->db_column('order_status', 'id')]==1){
												echo " <a href='/tienda/checkout_compra_ya/".$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'order_number')]."' class='boton-opciones m-0'>Pagar</a>";
											}
										?>
									</td>
								</tr>
							</table>
						</section>
					</div>

					<div class="col-xl-6 col-12 mb-4">
						<h2 class="h5 mt-2">Detalles de Contacto</h2>
						<section class="page-content card card-block p-4 mt-2">
							<table>
								<tr>
									<th>Email:</th><td><?php echo $summary_data['ord_demo_email'];?></td>
								</tr>
								<tr>
									<th>Teléfono:</th><td><?php echo $summary_data['ord_demo_phone'];?></td>
								</tr>
								<?php
								if (! empty($summary_data['ord_demo_comments'])){
								?>
									<tr>
										<th>Comentarios:</th><td><?php echo $summary_data['ord_demo_comments'];?></td>
									</tr>
								<?php
								}
								?>
							</table>
						</section>
					</div>
				</div>

				<div class="row">
					<div class="col-xl-6 col-12 mb-4">
						<h2 class="h5 mt-2">Detalles de Envio</h2>
						<section class="page-content card card-block p-4 mt-2">
							<table>
								<tr><th>Nombre:</th><td><?php echo $summary_data['ord_demo_ship_name'];?></td></tr>
								<tr><th>Dirección:</th><td><?php echo $summary_data['ord_demo_ship_address_01'];?></td></tr>
								<tr><th>Población:</th><td><?php echo $summary_data['ord_demo_ship_city'];?></td></tr>
								<tr><th>Provincia:</th><td><?php echo $summary_data['ord_demo_ship_state'];?></td></tr>
								<tr><th>CP:</th><td><?php echo $summary_data['ord_demo_ship_post_code'];?></td></tr>
								<tr><th>País:</th><td><?php echo $summary_data['ord_demo_ship_country'];?></td></tr>
							</table>
						</section>
					</div>

					<div class="col-xl-6 col-12 mb-4">
						<h2 class="h5 mt-2">Detalles de Facturación</h2>
						<section class="page-content card card-block p-4 mt-2">
							<table>
								<tr><th>Nombre:</th><td><?php echo $summary_data['ord_demo_bill_name'];?></td></tr>
								<tr><th>Dirección:</th><td><?php echo $summary_data['ord_demo_bill_address_01'];?></td></tr>
								<tr><th>Población:</th><td><?php echo $summary_data['ord_demo_bill_city'];?></td></tr>
								<tr><th>Provincia:</th><td><?php echo $summary_data['ord_demo_bill_state'];?></td></tr>
								<tr><th>CP:</th><td><?php echo $summary_data['ord_demo_bill_post_code'];?></td></tr>
								<?php
								/*
								<tr><th>País:</th><td><?php echo $summary_data['ord_demo_bill_country'];?></td></tr>
								*/
								?>
							</table>
						</section>
					</div>
				</div>
				<?php
				/*
				echo '<pre>';
				print_r($summary_data);
				echo '</pre>';
				echo '<pre>';
				print_r($countries);
				echo '</pre>';
				*/
				?>
				<div class="row">
					<div class="col-12 mb-4">
						<h2 class="h5 mt-2">Detalles del Pedido</h2>
						<section class="page-content card card-block p-4 mt-2">
							<table id="cart_items">
								<thead>
									<tr>
										<th>Articulos</th>
										<th class="text-right">Precio</th>
										<th class="text-right" title="Número total de unidades pedida.">Usd</th>
										<th class="text-right" title="Numero de unidades que han sido servidas">Uds Enviadas</th>
										<th class="text-right" title="Número de unidades canceladas">Uds Canceladas</th>
										<th class="text-right">Total</th>
									</tr>
								</thead>
								<tbody>
									<?php 
									if (! empty($item_data)){
										foreach($item_data as $row) {
											/*
					            echo '<pre>';
					            print_r($row);
					            echo '</pre>';
					            echo "<br />".$this->flexi_cart_admin->db_column('order_details', 'id');
					            echo "<br />".$this->flexi_cart_admin->db_column('order_details', 'item_name');
					            echo "<br />".$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity');
											*/
											$order_detail_id = $row[$this->flexi_cart_admin->db_column('order_details', 'id')];
											?>
											<tr>
												<td>
													<!-- Item Name -->
													<?php echo $row[$this->flexi_cart_admin->db_column('order_details', 'item_name')];?>
													<!-- Display an item status message if it exists -->
													<!-- 
														Display an items user note if it exists
														Note: This is a optional custom field added to this cart demo and is not defined via the cart config file.
													-->										
													<?php echo (! empty($row['ord_det_demo_user_note'])) ? '<br/>Note: '.$row['ord_det_demo_user_note'] : NULL; ?>
												</td>
												<td class="text-right">
												<?php 
													// If an item discount exists.
													if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0){
														//if (isset($row['discount_quantity']) && $row['discount_quantity'] > 0) {
		                          echo '<span style="text-decoration:line-through;">' . number_format($row[$this->flexi_cart_admin->db_column('order_details', 'item_price')], 2, ',', '.')."&euro; </span><br/>";
		                          echo number_format($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_price')], 2, ',', '.')."&euro;";
		                        //}
													}
													// Else, display price as normal.
													else{
														//echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price')], TRUE, 2, TRUE);
		                        echo number_format($row[$this->flexi_cart_admin->db_column('order_details', 'item_price')], 2, ',', '.')."&euro;";
													}
												?>
												</td>
												<td class="text-right"><?php echo round($row[$this->flexi_cart_admin->db_column('order_details', 'item_quantity')], 2); ?></td>
												<td class="text-right">
													<!-- 
														If the status of the order is 'Cancelled', flexi cart functions will not update any submitted 'shipped' and 'cancelled' quantities, until the order is un-cancelled. 
														This demo includes a user interface tweak to disable the select input fields if they cannot be updated.
													-->
													<? echo number_format($row[$this->flexi_cart_admin->db_column('order_details', 'item_quantity_shipped')]); ?>
															
												</td>
												<td class="text-right">
													<!-- 
														If the status of the order is 'Cancelled', flexi cart functions will not update any submitted 'shipped' and 'cancelled' quantities, until the order is un-cancelled. 
														This demo includes a user interface tweak to disable the select input fields if they cannot be updated.
													-->
													<? echo number_format($row[$this->flexi_cart_admin->db_column('order_details', 'item_quantity_cancelled')]); ?>
													
												</td>
												<td class="text-right">
												<?php 
													// If an item discount exists, strike out the standard item total and display the discounted item total.
													if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0){
														echo '<span class="strike">'.$this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price_total')], TRUE, 2, TRUE).'</span><br/>';
														echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_price_total')], TRUE, 2, TRUE);
													}
													// Else, display item total as normal.
													else{
														echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price_total')], TRUE, 2, TRUE);
													}
												?>
												</td>
											</tr>
											<?php 
											// If an item discount exists.
											if (! empty($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_description')])) { 
												?>
												<tr class="discount">
													<td colspan="6">
														Descuento: <?php echo $row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_description')];?>
													</td>
												</tr>
												<?php 
											} 
										} 
									}
									else { 
										?>
										<tr>
											<td colspan="6" class="empty">
												<h4>! No hay articulos asociados con este pedido !</h4>
											</td>
										</tr>
									<?php 
									} 
									?>
								</tbody>
								<tfoot>
									<?php 
									if ($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')] > 0) { 
									?>
										<tr class="discount">
											<th colspan="5">Descuento Total</th> 
											<td class="text-right">
												<?php 
												//echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')], TRUE, 2, TRUE);
												echo number_format($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')], 2, ',','.')."&euro;";
												?>
											</td>
										</tr>
									<?php 
									} 
									?>
									<tr>
										<th colspan="5">Total</th>
										<td class="text-right">
											<?php 
											//echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_total')], TRUE, 2, TRUE);
											echo number_format($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_total')], 2, ',','.')."&euro;";
											?>
										</td>
									</tr>
								</tfoot>
							</table>
						</section>
					</div>
				</div>

				<div class="row">
					<div class="col-12 mb-4">
						<h2 class="h5 mt-2">Resumen del Pedido</h2>
						<section class="page-content card card-block p-4 mt-2">
							<table id="cart_summary">
								<tbody>
									<tr>
										<td>Envio: <?php echo $summary_data[$this->flexi_cart_admin->db_column('order_summary', 'shipping_name')];?></td>
										<td class="text-right">
											<?php 
											//echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'shipping_total')], TRUE, 2, TRUE);
											echo number_format($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'shipping_total')], 2, ',','.')."&euro;";
											?> 
										</td>
									</tr>

									<!-- Display discounts -->
									<?php 
									if ($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'savings_total')] > 0) { 
										?>
										<tr class="discount"><th>Resumen de descuentos</th><td>&nbsp;</td></tr>
										
										<!-- Item discounts -->
										<?php 
										if ($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')] > 0) { 
											?>
											<tr class="discount">
												<td>Descuentos por artículos:</td>
												<td class="text-right">
													<?php 
													//echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')], TRUE, 2, TRUE);
													echo number_format($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')], 2, ',','.')."&euro;";
													?> 
												</td>
											</tr>
											<?php 
										} 
									
										//<!-- Summary discounts -->
										if ($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'summary_savings_total')] > 0) { 
											?>
											<tr class="discount">
												<td>Descuentos adicionales:</td>
												<td class="text-right">
													<?php echo $summary_data[$this->flexi_cart_admin->db_column('order_summary', 'summary_discount_description')];?>
												</td>
											</tr>
											<?php 
										} 
										?>
									
										<!-- Total of all discounts -->
										<tr class="discount">
											<td>Total descuentos:</td>
											<td class="text-right">
												<?php 
												//echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'savings_total')], TRUE, 2, TRUE);
												echo number_format($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'savings_total')], 2, ',','.')."&euro;";
												?> 
											</td>
										</tr>
										<?php 
									} 
									?>

									<!-- Display summary of all surcharges -->
									<?php 
									if ($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'surcharge_total')] > 0) { ?>
										<tr class="surcharge">
											<th>Resumen Recargos</th>
											<td>&nbsp;</td>
										</tr>
										<tr class="surcharge">
											<td class="pad_l_20">
												<?php echo $summary_data[$this->flexi_cart_admin->db_column('order_summary', 'surcharge_description')];?>
											</td>
											<td>&nbsp;</td>
										</tr>
										<tr class="surcharge">
											<td>Total Recargos</td>
											<td><?php echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'surcharge_total')], TRUE, 2, TRUE);?></td>
										</tr>
									<?php 
									} 
									?>
							
									<!-- Display summary of all reward vouchers -->
									<?php 
									if ($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'reward_voucher_total')] > 0) { ?>
										<tr class="voucher">
											<th>Resumen vales descuento</th>
											<td>&nbsp;</td>
										</tr>
										<tr class="voucher">
											<td class="pad_l_20">
												<?php echo $summary_data[$this->flexi_cart_admin->db_column('order_summary', 'reward_voucher_description')];?>
											</td>
											<td>&nbsp;</td>
										</tr>
										<tr class="voucher">
											<td>Total vales descuento</td>
											<td><?php echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'reward_voucher_total')], TRUE, 2, TRUE);?></td>
										</tr>
										<?php 
									} 
									?>								
							
									<!-- Display refund summary -->
									<?php 
									if (isset($refund_data[$this->flexi_cart_admin->db_column('order_details', 'item_price')])&&$refund_data[$this->flexi_cart_admin->db_column('order_details', 'item_price')] > 0) { ?>
										<tr class="refund">
											<td>
												Reembolsos Articulos Cancelados 
												<small>
													Este valor es una <em class="uline">estimación</em>  del valor total de reembolso, sin embargo, no incluye, ningun porcentaje basado en sobrecargos o descuentos que puedan ser aplicados sobre los valores totales del pedido, <b>el valor Total que se muestra a continuación NO computa esta partida</b>.
												</small>
											</td>
											<td>
											<?php
												if ($refund_data[$this->flexi_cart_admin->db_column('order_details', 'item_discount_price')] > 0)
												{
													echo $this->flexi_cart_admin->format_currency($refund_data[$this->flexi_cart_admin->db_column('order_details', 'item_discount_price')], TRUE, 2, TRUE);
												}
												else
												{
													echo $this->flexi_cart_admin->format_currency($refund_data[$this->flexi_cart_admin->db_column('order_details', 'item_price')], TRUE, 2, TRUE);
												}
											?>
											</td>
										</tr>
										<?php 
									} 
									?>
								</tbody>
								<tfoot>
									<tr>
										<th>Sub Total</th>
										<td class="text-right">
											<?php 
											//echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'sub_total')], TRUE, 2, TRUE);
											echo number_format($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'sub_total')], 2, ',','.')."&euro;";
											?> 
										</td>
									</tr>
									<tr>
										<th>
											<?php echo 'IVA '.$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'tax_rate')].'%';?>
										</th>
										<td class="text-right">
											<?php 
											//echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'tax_total')], TRUE, 2, TRUE);
											echo number_format($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'tax_total')], 2, ',','.')."&euro;";
											?>
										</td>
									</tr>
									<tr class="grand_total">
										<th>Gran Total</th>
										<td class="text-right">
											<?php 
											//echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'total')], TRUE, 2, TRUE);
											echo number_format($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'total')], 2, ',','.')."&euro;";
											?>
										</td>
									</tr>
								</tfoot>
							</table>
						</section>
						<?php
						if ($summary_data[$this->flexi_cart_admin->db_column('order_status', 'id')]==1){
							echo "<div class='text-center mt-4'>";
							echo " <a href='/tienda/checkout_compra_ya/".$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'order_number')]."' class='boton-opciones m-0'>Pagar</a>";
							echo "</div>";
						}
						?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
