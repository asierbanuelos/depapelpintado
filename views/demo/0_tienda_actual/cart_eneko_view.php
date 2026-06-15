
<?php $this->load->view('frontend/header'); ?> 

<body id="cart">

 <div class="units-row units-padding">
 <div class="unit-centered unit-80 cuerpocentral blancobg estatica sombra">
	
	<!-- Main Content -->
		<div class="clearfix">
			<div id="cart_content">
				<div id="ajax_content">
                  <?php echo form_open(current_url());?>

            	<!--<input onclick="history.back(-1)" type="button" name="update" value="Volver a la tienda" class="link_button2"/>-->
            	<button onclick="javascript:location.href='http://www.depapelpintado.es/'" type="button" name="update" value="Volver a la tienda" class="link_button2">Volver a la tienda <i class="fa fa-desktop"></i></button>
                <button type="submit" name="update" value="Actualizar Carro" class="link_button large">Actualizar Carro <i class="fa fa-refresh "></i></button>
                <button type="submit" name="clear" value="Vaciar Carro" class="link_button large">Vaciar Carro <i class="fa fa-times-circle "></i></button>
<?php if (! empty($cart_items)) {?>
                <button type="submit" name="checkout" value="Compra Ahora" class="link_button large red">Compra Ahora <i class="fa fa-shopping-cart"></i></button>
<?}?>
              </li> 
              
            </ul>

        <div style="display:block;height: 75px;"></div>
					
				<?php 
				if (! empty($message)) { 
				?>
					<div id="message">
						<?php echo $message; ?>
					</div>
				<?php 
				} 
					print '<pre><xmp>';
					print_r($cart_items);
					print '</xmp></pre>';
				//~ $gaur=date('Y-m-d');
				//~ $gaur='2015-07-24';
				//~ $gaur='2015-07-24';
				$hilabete_eguna=date('m-d');
				//~ $hilabete_eguna='08-31';
				//~ if ($gaur>=date('Y').'-07-25' && $gaur<=date('Y').'-08-31')
				if ($hilabete_eguna>='07-25' && $hilabete_eguna<='08-24')
					echo "			<p style='background-color:#87004B;color:#fff;text-align:center;font-size: 16px;padding:10px 5px;'><strong>Dado que algunos fabricantes cierran por vacaciones, los pedidos pueden sufrir un ligero retraso.</strong</p>\n";
				?>
				
					
				
					
						<table id="cart_items">
							<thead>
								<tr>
									
									<th>Artículo</th>
                                    <th>Descripción</th>
									<th class="c100 align_ctr">Precio</th>
									<th class="c100 align_ctr">Cantidad</th>
									<th class="c100 align_ctr">Total</th>
									<th class="c75">Eliminar</th>
								</tr>
							</thead>
							<tbody>
							<?php 
								if(isset($_GET['proba']) && $_GET['proba']=='eneko'){
							        print '<pre><xmp>';
							        print_r($cart_items);
							        print '</xmp></pre>';
								}
								if (! empty($cart_items)) {
									$i = 0;
									foreach($cart_items as $row) { $i++;
 //print_r($row);
							?>
								<tr>
                                  <td>
                                    <span style="overflow:hidden;height:75px;width:75px;display:inline-block"><img style="height:75px" src="<?php echo $includes_dir.str_replace("../", "", $row['thumb'])."th.jpg";?>"/></span>
                                  </td>
									<td>
                                      <strong><?php echo $row['name'];?></strong><br/>

									<?php 
										if ($this->flexi_cart->item_option_status($row['row_id']) && isset($row['option_data'])) { 
											foreach($row['option_data'] as $option_column => $option_data) {
									?>
										<!-- 
											Example of displaying an items options if they exist, as an editable field, 
											this example uses a custom field ('option_data') containing an array of option data. 
											To activate this example, add item #202 on the 'Add an item with options via a form' page.
										-->
										<label class="c50"><?php echo $option_column; ?>:</label> 
										<select name="items[<?php echo $i;?>][options][<?php echo $option_column; ?>]" class="width_100">
										<?php foreach($option_data as $data) { ?>
											<option value="<?php echo $data; ?>" <?php echo set_select('items['.$i.'][options]['.$option_column.']', $data, ($data == $row['options'][$option_column]));?>>
												<?php echo $data; ?>
											</option>
										<?php } ?>
										</select><br/>
										
									<?php } } else if ($this->flexi_cart->item_option_status($row['row_id'])) { ?>
									
										<!-- Example of displaying an items options if they exist, but as text, rather than an editable field. -->
										<?php echo $this->flexi_cart->item_options($row['row_id'], TRUE).'<br/>';?>
										
									<?php }?>
										
										<!-- 
											Example of displaying any item status messages.
											Status messages are generated if an item cannot be shipped to the current shipping location, or if there is insufficient stock.
											A css style ('highlight_red') can be submitted to the function to format messages.
										-->
									<?php 
										$item_status_message = $this->flexi_cart->item_status_message($row['row_id'], 'highlight_red');
										//echo (! empty($item_status_message)) ? $item_status_message.'<br/>' : NULL;
									?>
									<?php 	/*	
										<!-- 
											Example of indicating an items stock level - (Example only displays on item example #112) 
											If TRUE is submited to the 2nd parameter of 'item_stock_quantity()', it returns remaining quantity available once current quantity it deducted.
										-->
									
										if ($row['id'] == 112)
										{
											echo '<span class="highlight_green">There are <strong>'.$this->flexi_cart->item_stock_quantity($row['row_id']).'</strong> items in-stock.</span><br/>';
										}
									
										
										<!-- 
											Example of how to update a custom column defined via the config file var $config['cart']['items']['custom_columns'].
											Ensure the input name is the same as the custom column you wish to update.
											Note: Only custom columns that are defined as 'updatable' can be updated once set.											
										-->
										Note: <input type="text" name="items[<?php echo $i;?>][user_note]" value="<?php echo $row['user_note'];?>" maxlength="50" class="width_175"/>
									*/?></td>
									<td class="align_ctr">
									<?php 
										// If an item discount exists.
										if ($this->flexi_cart->item_discount_status($row['row_id'])) 
										{
/*											// If the quantity of non discounted items is zero, strike out the standard price.
											if ($row['non_discount_quantity'] == 0)
											{
												echo '<span class="strike">'.$row['price'].'</span><br/>';
											}
											// Else, display the quantity of items that are at the standard price.
											else
											{
												echo $row['non_discount_quantity'].' @ '.$row['price'].'<br/>';
											}
											
											// If there are discounted items, display the quantity of items that are at the discount price.
											if ($row['discount_quantity'] > 0)
											{
												echo $row['discount_quantity'].' @ '. $row['discount_price'];
											}
 */
                                          if ($row['discount_quantity'] > 0) {
                                              echo '<span style="text-decoration:line-through;">' . $row['price'] . '</span><br/>';
                                              echo $row['discount_price'];
                                            }
										}
										// Else, display price as normal.
										else
										{
											echo $row['price'];
										}
									?>
									</td>
									<td class="align_ctr">
										<!-- 
											The input name 'quantity' must be the same as the item array column that it is updating.
											In this example, it is defined via the config file var $config['cart']['items']['columns']['item_quantity'] = 'quantity'
										-->
										<input type="text" data-prev="<?php echo $row['quantity'];?>" name="items[<?php echo $i;?>][quantity]" value="<?php echo $row['quantity'];?>" maxlength="3" class="c50 cte align_ctr validate_decimal formulario2"/>
										<?//<input type="submit" name="update" value="&plusmn;" title="Actualizar cantidades" class="link_button grey"/>?>
									</td>
									<td class="align_ctr">
									<?php 
										// If an item discount exists, strike out the standard item total and display the discounted item total.
										if ($row['discount_quantity'] > 0)
										{
											echo '<span  style="text-decoration:line-through;">'.$row['price_total'].'</span><br/>';
											echo $row['discount_price_total'].'<br/>';
										}
										// Else, display item total as normal.
										else
										{
											echo $row['price_total'];
										}
									?>
									</td>
									<td>									
										<!-- 
											The name of each input field is structured as a multi-dimensional array, using the looped '$i' value to group each rows data together.
											When submitting input data to the 'update_cart()' function, the id of the cart row being updated must also be submitted.
											An example of this is done below by including a hidden field with the carts row id.
										-->
										<input type="hidden" name="items[<?php echo $i;?>][row_id]" value="<?php echo $row['row_id'];?>"/>
										
										<a href="<?php echo $base_url; ?>tienda/delete_item/<?php echo $row['row_id'];?>" title="Pincha para eliminar el artículo del carro">Eliminar</a>
									</td>
								</tr>
								
							<?php 
								// To display a description of the discount, this example submits a 2nd parameter to the item_discount_status() function.
								// This sets the function to show item shipping discounts as well as the standard item price discounts. 
								if ($this->flexi_cart->item_discount_status($row['row_id'], FALSE)) { 
							?>
								<tr class="discount">
									<td colspan="6">
										Descuentos: <?php echo $this->flexi_cart->item_discount_description($row['row_id']);?>
										<!--: <a href="<?php echo $base_url; ?>tienda/unset_discount/<?php echo $this->flexi_cart->item_discount_id($row['row_id']);?>">Eliminar</a>-->
									</td>
								</tr>
								
							<?php } ?>
								
                                  <?/*
                                   <tr>
									<td colspan="5" class="hidden_vars">
										<!-- This row is only intended to show some of the internal values of the cart-->
										<span class="toggle">View Hidden Item Data</span>
										<small class="hide_toggle">
											<strong>Hidden item values:</strong> 
											Weight: <em><?php echo $row['weight'];?></em>, 
											Tax Rate: <em><?php echo $row['tax_rate'];?></em>, 
											Tax: <em>
												<?php 
													// If a discount is set, the tax of the discounted items is shown in brackets.
													// Note: The $row data does not include the item tax including the discount, instead use the function $this->flexi_cart->item_tax($row['row_id'], TRUE).
													echo $row['tax'];
													echo ($this->flexi_cart->item_discount_status($row['row_id'])) ? ' ('.$this->flexi_cart->item_tax($row['row_id'], TRUE).')' : NULL; 
												?></em>,
											Reward Points: <em><?php echo $row['reward_points'];?></em>, 
											Shipping: <em><?php echo (is_numeric($row['shipping_rate'])) ? $row['shipping_rate'] : 'Default Rate';?></em><br/>

											<strong>Hidden item totals:</strong> 
											Total Weight: <em><?php echo $row['weight_total'];?></em>, 
											Total Tax: <em><?php 
													// If a discount is set, the discounted tax total is shown in brackets.
													// Note: The $row data does not include the item tax total including the discount, instead use the function $this->flexi_cart->item_tax_total($row['row_id'], TRUE).
													echo $row['tax_total'];
													echo ($this->flexi_cart->item_discount_status($row['row_id'])) ? ' ('.$this->flexi_cart->item_tax_total($row['row_id'], TRUE).')' : NULL; 
												?></em>, 
											Total Reward Points: <em><?php echo $row['reward_points_total'];?></em>
										</small>	
									</td>
                                   </tr>
                                   */?>
								
							<?php } } else { ?>
								<tr>
									<td colspan="5" class="empty">
										<h4>¡ Tu carro está vacio !</h4>
										<a href="javascript:window.history.back(-1)">Volver a la tienda</a>
									</td>
								</tr>
							<?php } ?>
							</tbody>
							<tfoot>
							<?php 
								// Ensure the 'item_summary_savings_total()' functions format argument is set to 'FALSE' to prevent comparing a formatted STRING against an INT of '0'.
								if ($this->flexi_cart->item_summary_savings_total(FALSE) > 0) { 
							?>
								<tr class="discount">
									<th colspan="4">Total Descuentos por artículo</th> 
									<td><?php echo $this->flexi_cart->item_summary_savings_total();?></td>
								</tr>
							<?php } ?>
								<tr>
									<th colspan="4">Total Artículos</th>
									<td><?php echo $this->flexi_cart->item_summary_total();?></td>
								</tr>
								
							</tfoot>
						</table>

					<?php 
						// Example on how to display how much more needs to be spent, or how many more items need to be added to activate a discount.
						// The function can work on both item and summary discounts.
						// Note: Ensure '$free_shipping_discount' contains no formatted currency strings by submitting FALSE as the 2nd argument to 'get_discount_requirements'.
						$free_shipping_discount = $this->flexi_cart->get_discount_requirements(5, FALSE);
						if ($free_shipping_discount['value'] > 0) { 
					?>
						<div class="frame align_ctr">
							<h3>Si gastas otros <?php echo $this->flexi_cart->get_currency_value($free_shipping_discount['value']);?> ¡Los portes te salen gratis!</h3>
						</div>
					<?php } ?>
												
					<?php if (isset($countries)) { ?>
						<table id="cart_shipping">
							<thead>
								<tr>
									<td colspan="5">
										<div style="font-size: 16px;float:left;"><a href="http://www.depapelpintado.es/tienda/herramientas"><img src="http://www.depapelpintado.es/includes/cola.jpg" width="100px"></a></div><div style="font-size: 16px; padding-top:40px; float:left;">! No se olvide de la cola ! . Pase por la sección de <a href="http://www.depapelpintado.es/tienda/herramientas">herramientas</a> y complemente su compra.</span></div>
									</td>
								</tr>
								<tr>
									<th>Envio</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>
										El coste de los gastos de envio para pedidos inferiores a 50€ sera de 6,95 por pedido.<br>
										<b><span style="font-size:16px;">Para pedidos superiores a los 50€ los gastos de envio son gratuitos.</span></b><br>
										Excepcionalmente las alfombras Brita siempre que no superen los 300€ llevan gastos de transporte.<br>
										Si lo necesita, disponemos de envios urgentes, consúltanos. 
									</td>	
								</tr>
                                                                <tr>
									<?php /*<td>
                                                                            <div id="avisoretraso"><b>DURANTE EL MES DE AGOSTO ALGUNOS PEDIDOS PUEDEN EXPERIMENTAR RETRASOS DADO QUE CIERTOS FABRICANTES CERRARÁN POR VACACIONES.<br> Para más información ponganse en contacto con nosotros.</b></div>
									</td>*/?>	
								</tr>
								<tr  >
									<td>
										<label class="spacer_250">País:
											<select name="shipping[country]">
												<option value="0"> - País - </option>
											<?php foreach($countries as $country) { ?>
												<option value="<?php echo $country['loc_id'];?>" <?php echo ($this->flexi_cart->match_shipping_location_id($country['loc_id'])) ? 'selected="selected"' : NULL;?>>
													<?php echo $country['loc_name'];?>
												</option>
											<?php } ?>
											</select>
										</label>
										
										<label class="spacer_200">Zona:
											<select id="zonaid" name="shipping[state]" <?php if (empty($states)) { echo 'disabled="disabled"'; }?>>
												<option value="0"> - Zona - </option>
											<?php foreach($states as $state) { ?>
												<option value="<?php echo $state['loc_id'];?>" <?php echo ($this->flexi_cart->match_shipping_location_id($state['loc_id'])) ? 'selected="selected"' : NULL;?>>
													<?php echo $state['loc_name'];?>
												</option>
											<?php } ?>
											</select>
										</label>
										<?php
										/*
										<label>Codigo Postal:
											<!-- The value '3' in the 'shipping_location_name()' function requests the location name for the 3rd location tier - in this example, postal/zip code -->
											<input type="text" name="shipping[postal_code]" value="<?php echo $this->flexi_cart->shipping_location_name(3);?>" <?php if (empty($postal_codes)) { echo 'disabled="disabled"'; }?> placeholder="00000" class="width_75"/>
										</label>
										*/
										?>
									</td>
								</tr>
								<tr>
									<td>
										<label class="spacer_125">Opciones de envio:</label>
										<select name="shipping[db_option]">
											<option value="0"> - Opciones de envio - </option>
										<?php 
											if (! empty($shipping_options)) {
												foreach($shipping_options as $shipping) { 
										?>
											<option value="<?php echo $shipping['id'];?>" <?php echo ($shipping['id'] == $this->flexi_cart->shipping_id()) ? 'selected="selected"' : NULL; ?>>
												<?php echo $shipping['name']." : ".$shipping['description'];?>
											</option>
										<?php } } else { ?>
											<option value="0">
												Te cotizaremos antes de despachar la mercancia.
											</option>
										<?php } ?>
										</select>
									</td>
								</tr>
							</tbody>
						</table>
					<?php } else { ?>					
						<!-- Manually set shipping option example -->
						<table id="cart_shipping">
							<thead>
								<tr>
									<th>Envio</th>
								</tr>
							</thead>
							<tbody>
								<tr>
								</tr>
								<tr>
									<td>
										<label>Opciones de envio:
											<select name="shipping[manual_option]">
												<option value="0"> - Opciones de envio - </option>
											<?php 
												if (! empty($shipping_options)) {
													foreach($shipping_options as $shipping) { 
											?>
												<option value="<?php echo $shipping['id'];?>" <?php echo ($shipping['id'] == $this->flexi_cart->shipping_id()) ? 'selected="selected"' : NULL; ?>>
													<?php echo $shipping['name']." : ".$shipping['description'];?>
												</option>
											<?php } } else { ?>
												<option value="0">
													Te cotizaremos antes de despachar la mercancia.
												</option>
											<?php } ?>
											</select>
										</label>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<td>&nbsp;</td>
								</tr>
							</tfoot>
						</table>
					<?php } ?>
					
						<table id="cart_summary">
							<thead>
								<tr>
									<th colspan="2">Resumen</th>
								</tr>
							</thead>
							<tbody>
								
								<tr>
									<td>
										Total Artículos
									</td>
									<td>
										<?php echo $this->flexi_cart->item_summary_total();?>
									</td>
								</tr>
                                
								<tr>
									<td>
										Portes
									</td>
									<td>
										<?php echo $this->flexi_cart->shipping_total();?>
									</td>
								</tr>
								<?php
								if (isset($portes_especiales) && ($portes_especiales)>0){
										?>
											<tr>
												<td>
													Portes Especiales
												</td>
												<td>
													<?php 
													echo $portes_especiales."&euro;";
													?>
												</td>
											</tr>
										<?php
								}
								?>
																
							<?php if ($this->flexi_cart->summary_discount_status()) { ?>
								<tr class="discount">
									<th>Resumen Descuentos</th>
									<td>&nbsp;</td>
								</tr>
								
							<?php if ($this->flexi_cart->item_summary_discount_status()) { ?>
								<!-- 
									Rather than repeating the descriptions of each item discount listed via the cart, 
									this example summarises the discount totals of all items.
								-->
								<tr class="discount">
									<th>
										<span class="pad_l_20">
											&raquo; Descuentos por artículo
										</span>
									</th>
									<td>
										<?php echo $this->flexi_cart->item_summary_savings_total();?>
									</td>
								</tr>
							<?php } ?>
								
								<!-- 
									This example uses the 'summary_discount_data()' function to return an array of summary discount values and descriptions.
									An alternative to using a custom loop to return this discount array, is to call the 'summary_discount_description()' function,
									which will return a formatted string of all summary discounts. 
								-->
							<?php foreach($discounts as $discount) { ?>
								<tr class="discount">
									<th>
										<span class="pad_l_20">
											&raquo; <?php echo $discount['description'];?>
										<?php 
										/*
										if (! empty($discount['id'])) { ?>
											: <a href="<?php echo $base_url; ?>tienda/unset_discount/<?php echo $discount['id']; ?>">Eliminar</a>
										<?php 
										} 
										*/
										?>
										</span>
									</th>
									<td><?php echo $discount['value'];?></td>
								</tr>
							<?php } ?>
								<tr class="discount">
									<th>Total Descuentos</th>
									<td><?php echo $this->flexi_cart->cart_savings_total();?></td>
								</tr>
							<?php } ?>

								
							<?php if ($this->flexi_cart->surcharge_status()) { ?>
								<tr class="surcharge">
									<th>Resumen Sobrecostos</th>
									<td>&nbsp;</td>
								</tr>
								
								<!-- 
									This example uses the 'surcharge_data()' function to return an array of surcharge values and descriptions.
									An alternative to using a custom loop to return this surcharge array, is to call the 'surcharge_description()' function,
									which will return a formatted string of all surcharges.
								-->
							<?php foreach($surcharges as $surcharge) { ?>
								<tr class="surcharge">
									<th>
										<span class="pad_l_20">
											&raquo; <?php echo $surcharge['description'];?>
											: <a href="<?php echo $base_url; ?>tienda/unset_surcharge/<?php echo $surcharge['id']; ?>">Eliminar</a>
										</span>
									</th>
									<td><?php echo $surcharge['value'];?></td>
								</tr>
							<?php } ?>
								<tr class="surcharge">
									<th>Total Sobrecostos</th>
									<td><?php echo $this->flexi_cart->surcharge_total();?></td>
								</tr>
							<?php } ?>

							<?php if ($this->flexi_cart->reward_voucher_status()) { ?>
								<tr class="voucher">
									<th>Resumen Vales</th>
									<td>&nbsp;</td>
								</tr>
								
								<!-- This example uses the 'reward_voucher_data()' function to return an array of reward voucher values and descriptions. -->
							<?php foreach($reward_vouchers as $voucher) { ?>
								<tr class="voucher">
									<th>
										<span class="pad_l_20">
											&raquo; <?php echo $voucher['description'];?>
											: <a href="<?php echo $base_url; ?>tienda/unset_discount/<?php echo $voucher['id']; ?>">Eliminar</a>
										</span>
									</th>
									<td><?php echo $voucher['value'];?></td>
								</tr>
							<?php } ?>
								<tr class="voucher">
									<th>Total Vales</th>
									<td><?php echo $this->flexi_cart->reward_voucher_total();?></td>
								</tr>
							<?php } ?>

							</tbody>
							<tfoot>
								<tr>
									<td>
										Sub Total
									</td>
									<td>
										<?php echo $this->flexi_cart->sub_total();?>
									</td>
								</tr>
								<tr>
									<td>
										<?php echo $this->flexi_cart->tax_name()." ".$this->flexi_cart->tax_rate(); ?>
									</td>
									<td>
										<?php echo $this->flexi_cart->tax_total();?>
									</td>
								</tr>							
								<tr class="grand_total">
									<th>Gran Total</th>
									<td><?php echo $this->flexi_cart->total();?></td>
								</tr>
							</tfoot>
						</table>
						<table id="cart_codes">
							<thead>
								<tr>
									<th>Vales descuento</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td> <input class="formulario2" type="text" name="discount[0]" value=""/> 
									<button type="submit" name="update_discount" value="Añadir código de descuento" class="link_button">Añadir código de descuento <i class="fa fa-barcode"></i></button>
									<button type="submit" name="remove_all_discounts" value="Eliminar todos los descuentos" class="link_button tooltip_trigger">Eliminar todos los descuentos <i class="fa fa-exclamation-circle"></i></button>

                                     
                        </td>
                        </tr><tr>
                        <td> <?php 
								// Get an array of all discount codes. The returned array keys are 'id', 'code' and 'description'.
								if ($discount_data = $this->flexi_cart->discount_codes()) {
									foreach($discount_data as $discount_codes) {
							?>
									<input type="text" name="discount[<?php echo $discount_codes['code']; ?>]" value="<?php echo $discount_codes['code']; ?>"/> 
									<input type="submit" name="update_discount" value="Actualizar" class="link_button grey"/>
									<input type="submit" name="remove_discount_code[<?php echo $discount_codes['code']; ?>]" value="Eliminar" class="link_button grey"/>
									<small class="inline">* <?php echo $discount_codes['description'];?></small><br/>
							<?php
									}
								}
							?>
                                                 </td>
                        </tr>
                        </tbody>
                        </table>
						
					
					<?php if (! $this->flexi_cart->location_shipping_status()) { ?>
						<div class="warning">
							<h3>Aviso!</h3>
							<p> Hay artículos en tu carro que no pueden ser enviados al destino seleccionado.</p>
						</div>
					<?php } ?>

					<button type="submit" name="checkout" value="Compra Ahora" class="total">Compra Ahora <i class="fa fa-shopping-cart"></i></button>		
					<?php echo form_close();?>
				</div>
			</div>
		</div>
	</div>	
	
	<!-- Footer -->  
	<?php //$this->load->view('includes/footer'); ?> 


<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 
<script>
$(document).ready(function() {
	$('button[name="checkout"]').click(function(e){
		if($('#zonaid').val()=="0"){
			alert("Debes seleccionar una zona de envio.");
			e.preventDefault();
			return false;
		} 
	});
	var btnhtml=$('button[name^="checkout"]').html();
	// Ajax Cart Update Example
	// Submit the cart form if a shipping option select or input element is changed.
	$('select[name^="shipping"], input[name^="shipping"]').live('change', function(){
		// Loop through shipping select and input fields creating object of their names and values that will then be submitted via 'post'
		var data = new Object();
		$('select[name^="shipping"], input[name^="shipping"]').each(function(){
			data[$(this).attr('name')] = $(this).val();
		});

		// Set 'update' so controller knows to run update method.
		data['update'] = true;

		// !IMPORTANT NOTE: As of CI 2.0, if csrf (cross-site request forgery) protection is enabled via CI's config, this must be included to submit the token.
		data['csrf_test_name'] = $('input[name="csrf_test_name"]').val();
		$('button[name^="checkout"]').attr('disabled','disabled');
		$('button[name^="checkout"]').html("Actualizando...");
		$('#cart_content').load('<?php echo current_url();?> #ajax_content', data,function() {
			$('button[name^="checkout"]').removeAttr('disabled');
			$('button[name^="checkout"]').html(btnhtml);
			$('button[name="checkout"]').click(function(e){
				if($('#zonaid').val()=="0"){
					alert("Debes seleccionar una zona de envio.");
					e.preventDefault();
					return false;
				} 
			});
		});
	});
    $('.cte').live('change', function()
	{
      var valor=$(this);
      if(valor.val()==0){
        var c= confirm("Está seguro de querer eliminar este artículo");
        if(c==true){
          var data = valor.closest("form").serializeArray()
          data[data.length]={name:"csrf_test_name",value:$('input[name="csrf_test_name"]').val()};
          data[data.length]={name:"update",value:"true"};
          $('#cart_content').load('<?php echo current_url();?> #ajax_content', data);
        }
        else{
          valor.val(valor.attr("data-prev"));
        }
//        $("#dialog-confirm").dialog({
//          resizable: false,
//          height:140,
//         width:400,
//         modal: true,
//          buttons: {
//            "Si": function() {
//                  $( this ).dialog( "close" );
//                  var data = valor.closest("form").serializeArray()
//                  data[data.length]={name:"csrf_test_name",value:$('input[name="csrf_test_name"]').val()};
//                  data[data.length]={name:"update",value:"true"};
//                  $('#cart_content').load('<?php echo current_url();?> #ajax_content', data);
//          },
//            "No": function() {
//                  $( this ).dialog( "close" );
//                  valor.val(valor.attr("data-prev"));
//          }
//        }
//      });
    }
    else{
      var data = $(this).closest("form").serializeArray()
      data[data.length]={name:"csrf_test_name",value:$('input[name="csrf_test_name"]').val()};
      data[data.length]={name:"update",value:"true"};

      $('#cart_content').load('<?php echo current_url();?> #ajax_content', data);
    }
	});
});
</script>


</div>
</div>
<div style="display:none" id="dialog-confirm" title="Está seguro de querer eliminar este artículo">
<p><span>Esta acción no puede deshacerse</span></p>
</div>
</body>
</html>