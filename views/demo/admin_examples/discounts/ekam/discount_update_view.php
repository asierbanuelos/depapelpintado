<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Actualizar descuento EKAM</title>
	<meta name="description" content=""/> 
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?> 
</head>

<body id="discount_update">
<?php $this->load->view('includes/demo_header'); ?> 
<div id="body_wrap">
	<!-- Demo Navigation -->
	
	
	<!-- Main Content -->
	<div class="container">
		<div class="content clearfix">
			
		<?php if (! empty($message)) { ?>
			<div id="message">
				<?php echo $message; ?>
			</div>
		<?php } ?>
										
			<h1>Actualizar descuento EKAM</h1>
			<p>
				<a href="<?php echo $base_url; ?>admin_library/item_discounts_ekam">Administrar descuentos EKAM por artículo</a> | 
				<a href="<?php echo $base_url; ?>admin_library/summary_discounts_ekam">Administrar descuentos EKAM por pedido</a> | 
				<?php
				/*
				<a href="<?php echo $base_url; ?>admin_library/discount_groups_ekam">Administrar grupos de descuento EKAM</a>
				*/
				?>
			</p>
						
			<?php echo form_open(current_url());?>
				<fieldset>
					<legend>Tipo</legend>
					<ul class="position_left">
						<li class="info_req">
							<label for="discount_type">Tipo de descuento:</label>
							<select id="discount_type" name="update[type]" class="width_200 tooltip_trigger" 
								title="<strong>Campo requerido</strong><br/> Establece cuando el descuento se aplica al articulo, al pedido o si se trata de un vale."
							>
								<option value="0"> - Selecciona el tipo de descuento - </option>
							<?php 
								foreach($discount_types as $type) { 
									$id = $type[$this->flexi_cart_admin->db_column('discount_types', 'id')];
									$select_type = ($discount_data[$this->flexi_cart_admin->db_column('discounts', 'type')] == $id);
							?>
								<option value="<?php echo $id;?>" <?php echo set_select('update[type]', $id, $select_type);?>>
									<?php echo $type[$this->flexi_cart_admin->db_column('discount_types', 'type')];?>
								</option>
							<?php } ?>
							</select>
						</li>
						<li class="info_req">
							<label for="discount_method">Metodo de descuento:</label>
							<select id="discount_method" name="update[method]" class="width_200 tooltip_trigger" 
								title="<strong>Campo requerido</strong><br/> A que valor se aplicara el descuento."
							>
								<option value="0" class="parent_id_0"> - Select Discount Method - </option>
							<?php 
								foreach($discount_methods as $method) { 
									$id = $method[$this->flexi_cart_admin->db_column('discount_methods', 'id')];
									$select_method = ($discount_data[$this->flexi_cart_admin->db_column('discounts', 'method')] == $id);
							?>
								<option value="<?php echo $id;?>" class="parent_id_<?php echo $method[$this->flexi_cart_admin->db_column('discount_methods', 'type')];?>" <?php echo set_select('update[method]', $id, $select_method);?>>
									<?php echo $method[$this->flexi_cart_admin->db_column('discount_methods', 'method')];?>
								</option>
							<?php } ?>
							</select>
						</li>
						<li>
							<label for="discount_tax_method">Aplicación Impuestos:</label>
							<select id="discount_tax_method" name="update[tax_method]" class="width_200 tooltip_trigger" 
								title="Como se aplican los impuestos a los descuentos."
							>
								<option value="0"> - Selecciona un método - </option>
								<option value="0">Por defecto</option>
							<?php 
								foreach($discount_tax_methods as $tax_method) { 
									$id = $tax_method[$this->flexi_cart_admin->db_column('discount_tax_methods', 'id')];
									$select_tax_method = ($discount_data[$this->flexi_cart_admin->db_column('discounts', 'tax_method')] == $id);
							?>
								<option value="<?php echo $id;?>" <?php echo set_select('update[tax_method]', $id, $select_tax_method);?>>
									<?php echo $tax_method[$this->flexi_cart_admin->db_column('discount_tax_methods', 'method')];?>
								</option>
							<?php } ?>
							</select>
						</li>
					</ul>
					<ul class="position_right">
						<li>
							<label for="discount_location">Localización:</label>
							<select id="discount_location" name="update[location]" class="width_200 tooltip_trigger" 
								title="Donde se aplica el descuento."
							>
								<option value="0"> - Todas las localizaciones - </option>
							<?php 
								foreach($locations_inline as $location) { 
									$id = $location[$this->flexi_cart_admin->db_column('locations', 'id')];
									$select_location = ($discount_data[$this->flexi_cart_admin->db_column('discounts', 'location')] == $id);
							?>
								<option value="<?php echo $id;?>" <?php echo set_select('update[location]', $id, $select_location);?>>
									<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'name')];?>
								</option>
							<?php } ?>
							</select>
						</li>
						<li>
							<label for="discount_zone">Zona:</label>
							<select id="discount_zone" name="update[zone]" class="width_200 tooltip_trigger" 
								title="Zona donde se aplica el descuento. <br/>Nota: si se ha establecido una localización esta tiene prioridad."
							>
								<option value="0"> - Todas las zonas - </option>
							<?php 
								foreach($zones as $zone) { 
									$id = $zone[$this->flexi_cart_admin->db_column('location_zones', 'id')];
									$select_zone = ($discount_data[$this->flexi_cart_admin->db_column('discounts', 'zone')] == $id);
							?>
								<option value="<?php echo $id;?>" <?php echo set_select('update[zone]', $id, $select_zone);?>>
									<?php echo $zone[$this->flexi_cart_admin->db_column('location_zones', 'name')];?>
								</option>
							<?php } ?>
							</select>
						</li>
					</ul>
				</fieldset>
					
				<fieldset>
					<legend>Objetivo Grupo / Artículo</legend>
					<ul class="position_left">
						<li>
							<label for="discount_group">Aplicar descuento a un grupo:</label>
							<select id="discount_group" name="update[group]" class="width_200 tooltip_trigger" 
								title="Establece el descuento a aplicar si un artículo a  de un gruppo en particular es añadido al carro."
							>
								<option value="0"> - No aplicar a grupos - </option>
							<?php 
								foreach($discount_groups as $group) { 
									$id = $group[$this->flexi_cart_admin->db_column('discount_groups', 'id')];
									$select_group = ($discount_data[$this->flexi_cart_admin->db_column('discounts', 'group')] == $id);
							?>
								<option value="<?php echo $id;?>" <?php echo set_select('update[group]', $id, $select_group);?>>
									<?php echo $group[$this->flexi_cart_admin->db_column('discount_groups', 'name')];?>
								</option>
							<?php } ?>
							</select>
						</li>
					</ul>
					<?if(false){?><ul class="position_right">
						<li>
							<label for="discount_item">Aplicar descuento a un artículo:</label>
							<select id="discount_item" name="update[item]" class="width_200 tooltip_trigger" 
								title="Establece el descuento a aplicar si un artículo en particular es añadido al carro."
							>
								<option value="0"> - No aplicar a artículo - </option>	
							<?php 
								foreach($items as $item) { 
									$id = $item['item_id'];
									$select_item = ($discount_data[$this->flexi_cart_admin->db_column('discounts', 'item')] == $id);
							?>
								<option value="<?php echo $id;?>" <?php echo set_select('update[item]', $id, $select_item);?>>
									<?php echo $item['item_name'];?>
								</option>
							<?php } ?>
							</select>
						</li>
                    </ul><?}else echo form_hidden("update[item]",0);?>
				</fieldset>
					
				<fieldset>
					<legend>Código / Descripción</legend>						
					<ul class="position_left">
						<li>
							<label for="discount_code">Código de descuento:</label>
							<input type="text" id="discount_code" name="update[code]" value="<?php echo set_value('update[code]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'code')]);?>" class="width_200 tooltip_trigger" 
								title="Establece el código requerido para aplicar el descuento, dejar en blanco si se activa por artículos, importes o cantidades."
							/>
						</li>
                                                <li>
                                                <label for="discount_code">Mostrar:</label>
							<input type="text" id="discount_code" name="update[resumen]" value="<?php echo set_value('update[resumen]',$discount_data["disc_resumen"]);?>" class="width_200 tooltip_trigger" 
								title="Si se establece mostrara este texto en vez el valor descontado"
							/>
                                                </li>
					</ul>
					<ul class="position_right">
						<li>
							<label for="discount_description">Descripción del descuento:</label>
							<textarea id="discount_description" name="update[description]" class="width_200 tooltip_trigger" 
								title="Breve descripción del descuento que se mostrara a los clientes."
							><?php echo set_value('update[description]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'description')]);?></textarea>
						</li>
					</ul>
				</fieldset>
					
				<fieldset>
					<legend>Requisitos / Descuento</legend>						
					<ul class="position_left">
						<li>
							<label for="discount_quantity_required">Cantidad requerida para activar:</label>
							<input type="text" id="discount_quantity_required" name="update[quantity_required]" value="<?php echo set_value('update[quantity_required]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'quantity_required')]);?>" class="width_100 validate_integer tooltip_trigger" 
								title="Establece la cantidad de articulos necesaria para activar el descuento.<br/> Por ejemplo: en un 3x2 la cantida debe ser 3."
							/>
						</li>
						<li>
							<label for="discount_quantity_discounted">Cantidad Descontada:</label>
							<input type="text" id="discount_quantity_discounted" name="update[quantity_discounted]" value="<?php echo set_value('update[quantity_discounted]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'quantity_discounted')]);?>" class="width_100  validate_integer tooltip_trigger" 
								title="Establece la cantidad de artículos a la que se aplicará el descuento.<br/> Por ejemplo: en un 3x2 la cantidad debe ser 1."
							/>
						</li>
					</ul>
					<ul class="position_right">
						<li>
							<label for="discount_value_required">Valor requerido para activar:</label>
							<input type="text" id="discount_value_required" name="update[value_required]" value="<?php echo set_value('update[value_required]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'value_required')]);?>" class="width_100 validate_decimal tooltip_trigger" 
								title="Establece el importe requerido para activar el descuento.<br/> Para descuentos por artículo, el valor es el importe total de los artículos descontados.<br/> Para descuentos por pedido, el valor es el total del carro."
							/>
						</li>
						<li>
							<label for="discount_value_discounted">Valor descontado:</label>
							<input type="text" id="discount_value_discounted" name="update[value_discounted]" value="<?php echo set_value('update[value_discounted]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'value_discounted')]);?>" class="width_100 validate_decimal tooltip_trigger" 
								title="Establece el valor del descuento aplicado.<br/> Para descuentos por porcentaje, el valor es utilizado como el porcentaje a descontar.<br/> Para descuentos fijos y nuevo valor es el importe a descontar o el nuevo precio respectivamente."
							/>
						</li>
					</ul>
				</fieldset>
					
				<fieldset>
					<legend>Funcionalidad</legend>						
					<ul class="position_left">
						<li>
							<label for="discount_recursive">Descuento recursivo:</label>
							<?php $recursive = (bool) $discount_data[$this->flexi_cart_admin->db_column('discounts', 'recursive')]; ?>
							<input type="hidden" name="update[recursive]" value="0"/>
							<input type="checkbox" id="discount_recursive" name="update[recursive]" value="1" <?php echo set_checkbox('update[recursive]','1', $recursive); ?> class="tooltip_trigger" 
								title="Si marcado el descuento puede aplicarse multiples veces al mismo carro.<br/> Por ejemplo si es descuento es un 3x2 el descuento sera aplicado si 3, 6, 9 (etc) articulos se añaden al carro.<br/> Si no esta marcado solo se aplicara a los 3 primeros articulos."
							/>
						</li>
						<li>
							<label for="discount_non_combinable">Descuento no combinable:</label>
							<?php $non_combinable = (bool) $discount_data[$this->flexi_cart_admin->db_column('discounts', 'non_combinable')]; ?>
							<input type="hidden" name="update[non_combinable]" value="0"/>
							<input type="checkbox" id="discount_non_combinable" name="update[non_combinable]" value="1" <?php echo set_checkbox('update[non_combinable]','1', $non_combinable); ?> class="tooltip_trigger" 
								title="Si marcado el descuento no se aplicará si hay otro descuento activo."
							/>
						</li>
					</ul>
					<ul class="position_right">
						<li>
							<label for="discount_void_reward">Cancelar puntos fidelidad:</label>
							<?php $void_reward = (bool) $discount_data[$this->flexi_cart_admin->db_column('discounts', 'void_reward_points')]; ?>
							<input type="hidden" name="update[void_reward]" value="0"/>
							<input type="checkbox" id="discount_void_reward" name="update[void_reward]" value="1" <?php echo set_checkbox('update[void_reward]','1', $void_reward); ?> class="tooltip_trigger" 
								title="Si marcado, el carro no generará puntos de fidelidad si el descuento es aplicado."
							/>
						</li>
						<li>
							<label for="discount_force_shipping">Aplicar antes de portes:</label>
							<?php $force_shipping = (bool) $discount_data[$this->flexi_cart_admin->db_column('discounts', 'force_shipping_discount')]; ?>
							<input type="hidden" name="update[force_shipping]" value="0"/>
							<input type="checkbox" id="discount_force_shipping" name="update[force_shipping]" value="1" <?php echo set_checkbox('update[force_shipping]','1', $force_shipping); ?> class="tooltip_trigger" 
								title="Si marcado, el valor de descuento será aplicado antes de aplicar las opciones de envio."
							/>
						</li>
					</ul>
				</fieldset>

				
				<fieldset>
					<legend>Estados personalizados</legend>						
					<ul>
						<li>
							<small>
								Pueden establecerse hasta 3 estados personalizados para acrivar el descuento.<br/>
								los estados personalizados pueden contener cualquier texto o numero entero , si el valor coincide con el estado personalizado del descuento este se aplicará.
							</small>
							<small>
								Por ejemplo, si el estado personalizado mira si el usuario esta logeado el valor por defecto es 0 (no) , cuando el usuario se loguea este valor pasa a 1 y por tanto el descuento se aplica.
							</small>
						</li>
						<li>
							<label for="discount_custom_status_1">Estado personalizado #1:</label>
							<input type="text" id="discount_custom_status_1" name="update[custom_status_1]" value="<?php echo set_value('update[custom_status_1]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'custom_status_1')]); ?>" class="width_75"/>
						</li>
						<li>
							<label for="discount_custom_status_2">Estado personalizado #2:</label>
							<input type="text" id="discount_custom_status_2" name="update[custom_status_2]" value="<?php echo set_value('update[custom_status_2]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'custom_status_2')]); ?>" class="width_75"/>
						</li>
						<li>
							<label for="discount_custom_status_3">Estado personalizado #3:</label>
							<input type="text" id="discount_custom_status_3" name="update[custom_status_3]" value="<?php echo set_value('update[custom_status_3]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'custom_status_3')]); ?>" class="width_75"/>
						</li>
					</ul>
				</fieldset>
					
				<fieldset>
					<legend>Limites / Validez</legend>						
					<ul class="position_left">
						<li class="info_req">
							<label for="discount_usage_limit">Limite de uso:</label>
							<input type="text" id="discount_usage_limit" name="update[usage_limit]" value="<?php echo set_value('update[usage_limit]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'usage_limit')]);?>" class="width_100 validate_integer tooltip_trigger" 
								title="<strong>Campo requerido</strong><br/>Establece el numero de veces que un descuento puede ser utilizado."
							/>
						</li>
						<li class="info_req">
							<?php 
								// Crop MYSQL 'datetime' data to just display the date, not the time.
								$valid_date = substr($discount_data[$this->flexi_cart_admin->db_column('discounts', 'valid_date')], 0, 10); 
							?>
							<label for="discount_valid_date">Fecha inicio:</label>
							<input type="text" id="discount_valid_date" name="update[valid_date]" value="<?php echo set_value('update[valid_date]', $valid_date);?>" maxlength="10" class="width_100 tooltip_trigger" 
								title="<strong>Campo requerido</strong><br/>Establece el comienzo del periodo de validez."
							/>
						</li>
						<li class="info_req">
							<?php 
								// Crop MYSQL 'datetime' data to just display the date, not the time.
								$expire_date = substr($discount_data[$this->flexi_cart_admin->db_column('discounts', 'expire_date')], 0, 10); 
							?>
							<label for="discount_expire_date">Fecha Fin:</label>
							<input type="text" id="discount_expire_date" name="update[expire_date]" value="<?php echo set_value('update[expire_date]', $expire_date);?>" maxlength="10" class="width_100 tooltip_trigger" 
								title="<strong>Campo requerido</strong><br/>Establece el fin del periodo de validez del descuento."
							/>
						</li>
					</ul>
					<ul class="position_right">
						<li>
							<label for="discount_status">Estado:</label>
							<?php $status = (bool) $discount_data[$this->flexi_cart_admin->db_column('discounts', 'status')]; ?>
							<input type="hidden" name="update[status]" value="0"/>
							<input type="checkbox" id="discount_status" name="update[status]" value="1" <?php echo set_checkbox('update[status]','1', $status); ?> class="tooltip_trigger" 
								title="Si marcado, el descuento esta activo."
							/>
						</li>
						<li>
							<label for="discount_order_by">Ordenar Por:</label>
							<input type="text" id="discount_order_by" name="update[order_by]" value="<?php echo set_value('update[order_by]', $discount_data[$this->flexi_cart_admin->db_column('discounts', 'order_by')]);?>" class="width_100 validate_integer tooltip_trigger" 
								title="Establecer el orden en que se aplicarán los descuentos a menor numero, mayor prioridad."
							/>
						</li>
					</ul>
				</fieldset>
					
				<fieldset>
					<legend>Actualizar descuento</legend>
					<input type="submit" name="update_discount" value="Actualizar descuento" class="link_button large"/>
				</fieldset>
			<?php echo form_close();?>						

		</div>
	</div>
	
	<!-- Footer -->  
	<?php $this->load->view('includes/footer'); ?> 
</div>

<!-- Scripts -->  
<?php $this->load->view('includes/scripts'); ?> 
<script>
$(function() {
	dependent_menu('discount_type', 'discount_method', false, true);
});
</script>

</body>
</html>