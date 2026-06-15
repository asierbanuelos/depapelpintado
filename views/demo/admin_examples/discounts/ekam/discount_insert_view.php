<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Insertar Descuento </title>
	<meta name="description" content=""/> 
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?> 
</head>

<body id="discount_insert">

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
										
			<h1>Introducir Nuevo Descuento EKAM</h1>
			<p>
				<a href="<?php echo $base_url; ?>admin_library/item_discounts_ekam">Administrar descuestos por artículo EKAM</a> | 
				<a href="<?php echo $base_url; ?>admin_library/summary_discounts_ekam">Administrar Descuentos por Pedido EKAM</a>  
				<?php
				/*
				<a href="<?php echo $base_url; ?>admin_library/discount_groups">Administrar grupos de descuento</a>
				*/
				?>
			</p>
						
			<?php echo form_open(current_url());?>
				<fieldset>
					<legend>Tipo</legend>
					<ul class="position_left">
						<li class="info_req">
							<label for="discount_type">Tipo de descuento:</label>
							<select id="discount_type" name="insert[type]" class="width_200 tooltip_trigger" 
								title="<strong>Campo requerido</strong><br/> Establece cuando el descuento se aplica al articulo, al pedido o si se trata de un vale."
							>
								<option value="0"> - Selecciona el tipo de descuento - </option>
							<?php 
								foreach($discount_types as $type) { 
									$id = $type[$this->flexi_cart_admin->db_column('discount_types', 'id')];
							?>
								<option value="<?php echo $id; ?>" <?php echo set_select('insert[type]', $id); ?>>
									<?php echo $type[$this->flexi_cart_admin->db_column('discount_types', 'type')];?>
								</option>
							<?php } ?>
							</select>
						</li>
						<li class="info_req">
							<label for="discount_method">Metodos de Descuento:</label>
							<select id="discount_method" name="insert[method]" class="width_200 tooltip_trigger" 
								title="<strong>Campo requerido</strong><br/> A que valor se aplicara el descuento."
							>
								<option value="0" class="parent_id_0"> - Selecciona método de descuento - </option>
							<?php 
								foreach($discount_methods as $method) { 
									$id = $method[$this->flexi_cart_admin->db_column('discount_methods', 'id')];
							?>
								<option value="<?php echo $id; ?>" class="parent_id_<?php echo $method[$this->flexi_cart_admin->db_column('discount_methods', 'type')];?>" <?php echo set_select('insert[method]', $id); ?>>
									<?php echo $method[$this->flexi_cart_admin->db_column('discount_methods', 'method')];?>
								</option>
							<?php } ?>
							</select>
						</li>
						<li>
							<label for="discount_tax_method">Aplicación Impuestos:</label>
							<select id="discount_tax_method" name="insert[tax_method]" class="width_200 tooltip_trigger" 
								title="Como se aplican los impuestos a los descuentos."
							>
								<option value="0"> - Selecciona un método - </option>
								<option value="0">Por defecto</option>
							<?php 
								foreach($discount_tax_methods as $tax_method) { 
									$id = $tax_method[$this->flexi_cart_admin->db_column('discount_tax_methods', 'id')];
							?>
								<option value="<?php echo $id; ?>" <?php echo set_select('insert[tax_method]', $id); ?>>
									<?php echo $tax_method[$this->flexi_cart_admin->db_column('discount_tax_methods', 'method')];?>
								</option>
							<?php } ?>
							</select>
						</li>
					</ul>
					<ul class="position_right">
						<li>
							<label for="discount_location">Localización:</label>
							<select id="discount_location" name="insert[location]" class="width_200 tooltip_trigger" 
								title="Donde se aplica el descuento."
							>
								<option value="0"> - Todas las localizaciones - </option>
							<?php 
								foreach($locations_inline as $location) { 
									$id = $location[$this->flexi_cart_admin->db_column('locations', 'id')];
							?>
								<option value="<?php echo $id;?>" <?php echo set_select('insert[location]', $id);?>>
									<?php echo $location[$this->flexi_cart_admin->db_column('locations', 'name')];?>
								</option>
							<?php } ?>
							</select>
						</li>
						<li>
							<label for="discount_zone">Zona:</label>
							<select id="discount_zone" name="insert[zone]" class="width_200 tooltip_trigger" 
								title="Zona donde se aplica el descuento. <br/>Nota: si se ha establecido una localización esta tiene prioridad."
							>
								<option value="0"> - Todas las zonas - </option>
							<?php 
								foreach($zones as $zone) { 
									$id = $zone[$this->flexi_cart_admin->db_column('location_zones', 'id')];
							?>
								<option value="<?php echo $id;?>" <?php echo set_select('insert[zone]', $id);?>>
									<?php echo $zone[$this->flexi_cart_admin->db_column('location_zones', 'name')];?>
								</option>
							<?php } ?>
							</select>
						</li>
					</ul>
					
				<fieldset>
					<legend>Grupo o Articulo</legend>
					<ul class="position_left">
						<li>
							<label for="discount_group">Aplicar decuento a un grupo:</label>
							<select id="discount_group" name="insert[group]" class="width_200 tooltip_trigger" 
								title="Establece el descuento a aplicar si un artículo a  de un gruppo en particular es añadido al carro."
							>
								<option value="0"> - No aplicar a grupos - </option>
							<?php 
								foreach($discount_groups as $group) { 
									$id = $group[$this->flexi_cart_admin->db_column('discount_groups', 'id')];
							?>
								<option value="<?php echo $id; ?>" <?php echo set_select('insert[group]', $id); ?>>
									<?php echo $group[$this->flexi_cart_admin->db_column('discount_groups', 'name')];?>
								</option>
							<?php } ?>
							</select>
						</li>
					</ul>
					<?if(false){?><ul class="position_right">
						<li>
							<label for="discount_item">Aplicar descuento a un artículo:</label>
							<select id="discount_item" name="insert[item]" class="width_200 tooltip_trigger" 
								title="Establece el descuento a aplicar si un artículo en particular es añadido al carro."
							>
								<option value="0"> - No aplicar a artículo - </option>	
							<?php foreach($items as $item) {?>
								<option value="<?php echo $item['item_id']; ?>" <?php echo set_select('insert[item]', $item['item_id']); ?>>
									<?php echo $item['item_ref'];?>
								</option>
							<?php } ?>
							</select>
						</li>
					</ul>
                    <?}else echo form_hidden("insert[item]",0);?>
				</fieldset>
					
				<fieldset>
					<legend>Código / Descripción</legend>						
					<ul class="position_left">
						<li>
							<label for="discount_code">Codigo:</label>
							<input type="text" id="discount_code" name="insert[code]" value="<?php echo set_value('insert[code]');?>" class="width_200 tooltip_trigger" 
								title="Establece el código requerido para aplicar el descuento, dejar en blanco si se activa por artículos, importes o cantidades."
							/>
                                                </li>
                                                <li>
                                                        <label for="discount_code">Mostrar:</label>
							<input type="text" id="discount_code" name="insert[resumen]" value="<?php echo set_value('insert[resumen]');?>" class="width_200 tooltip_trigger" 
								title="Si se establece mostrara este texto en vez el valor descontado"
							/>
						</li>
					</ul>
					<ul class="position_right">
						<li>
							<label for="discount_desc">Descripcion:</label>
							<textarea id="discount_desc" name="insert[description]" class="width_200 tooltip_trigger" 
								title="Breve descripción del descuento que se mostrara a los clientes."
							><?php echo set_value('insert[description]');?></textarea>
						</li>
					</ul>
				</fieldset>
					
				<fieldset>
					<legend>Requisitos / Descuento</legend>						
					<ul class="position_left">
						<li>
							<label for="discount_quantity_required">Cantidad requerida para activar:</label>
							<input type="text" id="discount_quantity_required" name="insert[quantity_required]" value="<?php echo set_value('insert[quantity_required]');?>" class="width_100 validate_integer tooltip_trigger" 
								title="Establece la cantidad de articulos necesaria para activar el descuento.<br/> Por ejemplo: en un 3x2 la cantida debe ser 3."
							/>
						</li>
						<li>
							<label for="discount_quantity_discounted">Cantidad Descontada:</label>
							<input type="text" id="discount_quantity_discounted" name="insert[quantity_discounted]" value="<?php echo set_value('insert[quantity_discounted]');?>" class="width_100  validate_integer tooltip_trigger" 
								title="Establece la cantidad de artículos a la que se aplicará el descuento.<br/> Por ejemplo: en un 3x2 la cantidad debe ser 1."
							/>
						</li>
					</ul>
					<ul class="position_right">
						<li>
							<label for="discount_value_required">Valor requerido para activar:</label>
							<input type="text" id="discount_value_required" name="insert[value_required]" value="<?php echo set_value('insert[value_required]');?>" class="width_100 validate_decimal tooltip_trigger" 
								title="Establece el importe requerido para activar el descuento.<br/> Para descuentos por artículo, el valor es el importe total de los artículos descontados.<br/> Para descuentos por pedido, el valor es el total del carro."
							/>
						</li>
						<li>
							<label for="discount_value_discounted">Valor descontado:</label>
							<input type="text" id="discount_value_discounted" name="insert[value_discounted]" value="<?php echo set_value('insert[value_discounted]');?>" class="width_100 validate_decimal tooltip_trigger" 
								title="Establece el valor del descuento aplicado.<br/> Para descuentos por porcentaje, el valor es utilizado como el porcentaje a descontar.<br/> Para descuentos fijos y nuevo valor es el importe a descontar o el nuevo precio respectivamente."
							/>
						</li>
					</ul>
				</fieldset>
					
				<fieldset >
					<legend>Funcionalidad</legend>						
					<ul class="position_left">
						<li>
							<label for="discount_recursive">Descuento Recursivo:</label>
							<input type="hidden" name="insert[recursive]" value="0"/>
							<input type="checkbox" id="discount_recursive" name="insert[recursive]" value="1" <?php echo set_checkbox('insert[recursive]', '1'); ?> class="tooltip_trigger" 
								title="Si marcado el descuento puede aplicarse multiples veces al mismo carro.<br/> Por ejemplo si es descuento es un 3x2 el descuento sera aplicado si 3, 6, 9 (etc) articulos se añaden al carro.<br/> Si no esta marcado solo se aplicara a los 3 primeros articulos."
							/>
						</li>
						<li>
							<label for="discount_non_combinable">Descuento no combinable:</label>
							<input type="hidden" name="insert[non_combinable]" value="0"/>
							<input type="checkbox" id="discount_non_combinable" name="insert[non_combinable]" value="1" <?php echo set_checkbox('insert[non_combinable]', '1'); ?> class="tooltip_trigger" 
								title="Si marcado el descuento no se aplicará si hay otro descuento activo."
							/>
						</li>
					</ul>
					<ul class="position_right">
						<li>
							<label for="discount_void_reward">Cancelar puntos fidelidad:</label>
							<input type="hidden" name="insert[void_reward]" value="0"/>
							<input type="checkbox" id="discount_void_reward" name="insert[void_reward]" value="1" <?php echo set_checkbox('insert[void_reward]', '1'); ?> class="tooltip_trigger" 
								title="Si marcado, el carro no generará puntos de fidelidad si el descuento es aplicado."
							/>
						</li>
						<li>
							<label for="discount_force_shipping">Aplicar antes de portes:</label>
							<input type="hidden" name="insert[force_shipping]" value="0"/>
							<input type="checkbox" id="discount_force_shipping" name="insert[force_shipping]" value="1" <?php echo set_checkbox('insert[force_shipping]','1'); ?> class="tooltip_trigger" 
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
							<label for="discount_custom_status_1">Estado Personalizado #1:</label>
							<input type="text" id="discount_custom_status_1" name="insert[custom_status_1]" value="<?php echo set_value('insert[custom_status_1]'); ?>" class="width_75"/>
						</li>
						<li>
							<label for="discount_custom_status_2">Estado Personalizado #2:</label>
							<input type="text" id="discount_custom_status_2" name="insert[custom_status_2]" value="<?php echo set_value('insert[custom_status_2]'); ?>" class="width_75"/>
						</li>
						<li>
							<label for="discount_custom_status_3">Estado Personalizado #3:</label>
							<input type="text" id="discount_custom_status_3" name="insert[custom_status_3]" value="<?php echo set_value('insert[custom_status_3]'); ?>" class="width_75"/>
						</li>
					</ul>
				</fieldset>
					
				<fieldset>
					<legend>Estado / Validez</legend>						
					<ul class="position_left">
						<li class="info_req">
							<label for="discount_usage_limit">Numero de usos:</label>
							<input type="text" id="discount_usage_limit" name="insert[usage_limit]" value="<?php echo set_value('insert[usage_limit]');?>" class="width_100 validate_integer tooltip_trigger" 
								title="<strong>Campo requerido</strong><br/>Establece el numero de veces que un descuento puede ser utilizado."
							/>
						</li>
						<li class="info_req">
							<label for="discount_valid_date">De Fecha (yyyy-mm-dd):</label>
							<input type="text" id="discount_valid_date" name="insert[valid_date]" value="<?php echo set_value('insert[valid_date]', date('Y-m-d'));?>" maxlength="10" class="width_100 tooltip_trigger" 
								title="<strong>Campo requerido</strong><br/>Establece el comienzo del periodo de validez."
							/>
						</li>
						<li class="info_req">
							<label for="discount_expire_date">A Fecha (yyyy-mm-dd):</label>
							<input type="text" id="discount_expire_date" name="insert[expire_date]" value="<?php echo set_value('insert[expire_date]', date('Y-m-d', strtotime('3 Month')));?>" maxlength="10" class="width_100 tooltip_trigger" 
								title="<strong>Campo requerido</strong><br/>Establece el fin del periodo de validez del descuento."
							/>
							
						</li>
					</ul>
					<ul class="position_right">
						<li>
							<label for="discount_status">Estado:</label>
							<input type="hidden" name="insert[status]" value="0"/>
							<input type="checkbox" id="discount_status" name="insert[status]" value="1" <?php echo set_checkbox('insert[status]', '1', TRUE); ?> class="tooltip_trigger" 
								title="Si marcado, el descuento esta activo."
							/>
						</li>
						<li>
							<label for="discount_order_by">Orden:</label>
							<input type="text" id="discount_order_by" name="insert[order_by]" value="<?php echo set_value('insert[order_by]');?>" class="width_100 validate_integer tooltip_trigger" 
								title="Establecer el orden en que se aplicarán los descuentos a menor numero, mayor prioridad."
							/>
						</li>
					</ul>
				</fieldset>
					
				<fieldset>
					<legend>Añadir Descuento</legend>
					<input type="submit" name="insert_discount" value="Insert Discount" class="link_button large"/>
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