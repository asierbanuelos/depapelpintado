<!doctype html>
<!--[if lt IE 7 ]><html lang="en" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="en" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="en" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="en" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="en" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Insertar Grupo de descuentos</title>
	
	<?php $this->load->view('includes/admin_head'); ?> 
</head>

<body id="discount_group_insert">

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
				<h1>Añadir Descuentos para Grupos de Artículos</h1>
				<p>
					<a href="<?php echo $base_url; ?>admin_library/discount_groups">Administrar Descuentos para Grupos de Artículos</a>
				</p>	

				<table>
					<captionDescuentos para Grupos de Artículos</caption>
					<thead>
						<tr>
							<th class="info_req tooltip_trigger"
								title="<strong>Campo Requerido</strong><br/>Nombre del Descuento para Grupos de Artículos.">
								Nombre del grupo
							</th>
							<th class="spacer_100 align_ctr tooltip_trigger" 
								title="Si se marca, El grupo de descuento será marcado como activo.">
								Estado
							</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>
								<input type="text" name="insert_group[name]" value="<?php echo set_value('insert_group[name]');?>" class="width_250"/>
							</td>
							<td class="align_ctr">
								<input type="hidden" name="insert_group[status]" value="0"/>
								<input type="checkbox" name="insert_group[status]" value="1" <?php echo set_checkbox('insert_group[status]', '1', TRUE); ?>/>
							</td>
						</tr>
					</tbody>
				</table>
				
				<table>
					<caption>Añadir artículos a grupo</caption>
					<thead>
						<tr>
							<th class="info_req tooltip_trigger"
								title="">
								Operador
							</th>
							<th class="info_req tooltip_trigger"
								title="">
								Columna
							</th>
							<th class="info_req tooltip_trigger"
								title="">
								Método
							</th>
							<th class="tooltip_trigger"
								title="Set the value to be compared against the 'filter column'.<br/> For methods requiring multiple values (WHERE x BETWEEN y AND z), separate values using a comma (y,z).">
								Valor del filtro
							</th>
							<th class="spacer_150 align_ctr tooltip_trigger" 
								title="">
								Copiar / Borrar
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
								<select name="insert_item[<?php echo $row_id; ?>][logic_operator]" class="width_100">
									<option value="AND">AND</option>
									<option value="OR" <?php echo set_select('insert_item['.$row_id.'][logic_operator]', 'OR'); ?>>OR</option>
								</select>
							</td>
							<td>
								<select name="insert_item[<?php echo $row_id; ?>][column_name]" class="width_150">
									<option value="item_id" <?php echo set_select('insert_item['.$row_id.'][column_name]', 'item_id'); ?>>ID Articulo</option>
									<option value="item_name" <?php echo set_select('insert_item['.$row_id.'][column_name]', 'item_name'); ?>>Nombre Articulo</option>
									<option value="item_price" <?php echo set_select('insert_item['.$row_id.'][column_name]', 'item_price'); ?>>Precio</option>
									<option value="cat_name" <?php echo set_select('insert_item['.$row_id.'][column_name]', 'cat_name'); ?>>Nombre Marca</option>
                                    <option value="coleccion_name" <?php echo set_select('insert_item['.$row_id.'][column_name]', 'coleccion_name'); ?>>Nombre Coleccion</option>
                                    <option value="item_tipo" <?php echo set_select('insert_item['.$row_id.'][item_tipo]', 'item_tipo'); ?>>Categoría</option>
								</select>
							</td>
							<td>
								<select name="insert_item[<?php echo $row_id; ?>][comparison_operator]" class="width_200">
									<option value="=">Is equal to ( = )</option>
									<option value="!=" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', '!='); ?>>Is not equal to ( != )</option>
									<option value="<" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', '<'); ?>>Is less than ( < )</option>
									<option value="<=" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', '<='); ?>>Is less than or equal to ( <= )</option>
									<option value=">" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', '>'); ?>>Is more than ( > )</option>
									<option value=">=" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', '>='); ?>>Is more than or equal to( >= )</option>
									<option value="like" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', 'like'); ?>>Contains ( LIKE '%xxx%' )</option>
									<option value="not_like" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', 'not_like'); ?>>Does not contain ( NOT LIKE '%xxx%' )</option>
									<option value="begin_lik" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', 'begin_lik'); ?>>Begins with ( LIKE 'xxx%' )</option>
									<option value="not_begin_like" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', 'not_begin_like'); ?>>Does not begin with ( NOT LIKE 'xxx%' )</option>
									<option value="end_like" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', 'end_like'); ?>>Ends with ( LIKE '%xxx' )</option>
									<option value="not_end_like" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', 'not_end_like'); ?>>Does not end with ( NOT LIKE '%xxx' )</option>
									<option value="null" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', 'null'); ?>>Is null ( IS NULL )</option>
									<option value="not_null" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', 'not_null'); ?>>Is not null ( IS NOT NULL )</option>
									<option value="empty" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', 'empty'); ?>>Is empty ( = '' )</option>
									<option value="not_empty" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', 'not_empty'); ?>>Is not empty ( != '' )</option>
									<option value="between" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', 'between'); ?>>Is between ( BETWEEN X AND X )</option>
									<option value="not_between" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', 'not_between'); ?>>Is not between ( NOT BETWEEN X AND X )</option>
									<option value="in" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', 'in'); ?>>Is in list ( IN ('x', 'xx', 'xxx') )</option>
									<option value="not_in" <?php echo set_select('insert_item['.$row_id.'][comparison_operator]', 'not_in'); ?>>Is not in list ( NOT IN ('x', 'xx', 'xxx') )</option>
								</select>
							</td>
							<td>
								<input type="text" name="insert_item[<?php echo $row_id; ?>][value]" value="<?php echo set_value('insert_item['.$row_id.'][value]');?>" class="width_150"/>
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
								<input type="submit" name="insert_discount_group" value="Insert New Discount Item Group" class="link_button large"/>
							</td>
						</tr>
					</tbody>
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