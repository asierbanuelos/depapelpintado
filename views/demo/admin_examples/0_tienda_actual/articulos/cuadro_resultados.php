<?
$bg = false;
foreach ($all as $key => $value) {
	$bg = !$bg;
	$back_color="";
	if ($bg)
		$back_color=" style='background-color:#f1f1f1' ";
	if (!$value['item_activo'])
		$back_color=" style='background-color:#FDBBBB' ";
	?>
	<div class="sec row" <? echo $back_color; ?>>
		<div class="col twelve referencia">
			<input type="checkbox" class='seleccion_items' name="item_seleccionado[<?= $value['item_id'] ?>]" id="item_check_<?= $value['item_id'] ?>" value="<?= $value['item_id'] ?>"/>
			<label for="item_check_<?= $value['item_id'] ?>"><?= $value['item_ref'] ?></label>
		</div>
		<div class="col one t-two m-three">
			<span class="imguploader" ref="<?= $value['item_cat_fk'] . ":" . $value['item_ref']. ":" . $value['item_coleccion_id'] ?>" style="background-color: #000;display:block;width:74px;height:74px">
				<? if ($value['img'] != "") { ?>
					<img src="<?php echo $includes_dir . str_replace("../", "", $value['img']); ?>th.jpg" width="74" height="74"/>
				<? } ?>
			</span>
		</div>
		<div class="col one t-two m-three">
			<span class="imguploader2" ref="<?= $value['item_cat_fk'] . ":" . $value['item_ref']. ":" . $value['item_coleccion_id'] ?>" style="background-color: #000;display:block;width:74px;height:74px">
				<? if ($value['imgamb'] != "") { ?>
					<img src="<?php echo $includes_dir . str_replace("../", "", $value['imgamb']); ?>th.jpg" width="74" height="74"/>
				<? } ?>
			</span>
		</div>
		<div class="col five t-four m-three">
			<?= ($value['item_name']=="")?"Este artículo no tiene nombre":$value['item_name'] ?><br/>
			<?= $value['cat_name'] ?><br/>
			<?= $value['coleccion_name'] ?><br/>
			<?= $value['modelo_name'] ?><br/>
			<b>Color: </b><?= $value['color'] ?><br/>
		</div>
		<div class="col two t-three m-three">
			Ancho:<?= $value['item_ancho'] ?><br/>
			Largo:<?= $value['item_largo'] ?><br/>
			Case: <?= $value['item_case'] ?><br/>
			<?= ($value['item_lavable'] == 1) ? "L" : "l" ?> - <?= ($value['item_sol'] == 1) ? "S" : "s" ?> - <?= ($value['item_vinilo'] == 1) ? "V" : "v" ?><br/>
			<b>Precio: <?= $value['item_price'] ?></b><br/>
		</div>

		<div class="col two t-two m-three">
			<span class="del btn" id="<?= $value['item_id'] ?>">Del</span>
			<span data-publico="<?if($value['publico3']==1)echo "0";else echo "1";?>" class="publicar btn" id="<?= $value['item_id'] ?>">
				<?if($value['publico3']==1)echo "Ocultar";else echo "Publicar";?>
			</span>
			<span class="edit btn" id="<?= $value['item_id'] ?>">Edit</span>
		</div>
	</div>
<?
}
// $this->load->view('demo/paginador'); ?>
