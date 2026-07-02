<?php if (!function_exists('urlenc')):
function urlenc($str){
  $search  = explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,Á,É,Í,Ó,Ú,Ñ,%,!,(,)");
  $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,n,,,,");
  return str_replace($search,$replace,strtolower(str_replace(',','',str_replace('+','-plus-',str_replace('#','number-',str_replace('&','and',str_replace(' ','-',rawurldecode($str))))))));
}
endif; ?>
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
	<div id='articulo_<?php echo $value['item_id']; ?>' class="sec row" <? echo $back_color; ?>>
		<div class="col twelve referencia">
			<input type="checkbox" class='seleccion_items' name="item_seleccionado[<?= $value['item_id'] ?>]" id="item_check_<?= $value['item_id'] ?>" value="<?= $value['item_id'] ?>"/>
			<label for="item_check_<?= $value['item_id'] ?>"><?= $value['item_ref'] ?></label>
		</div>
		<div class="col one t-two m-three">
			<span class="imguploader" ref="<?= $value['item_cat_fk'] . ":" . $value['item_ref']. ":" . $value['item_coleccion_id'] ?>" style="background-color:#000;display:block;width:74px;height:74px;cursor:pointer;overflow:hidden;position:relative" title="Clic o arrastra imagen JPG aquí">
				<input type="file" accept="image/jpeg,image/jpg" style="display:none" class="img-file-input" data-ref="<?= $value['item_cat_fk'] . ":" . $value['item_ref']. ":" . $value['item_coleccion_id'] ?>" data-type="1"/>
				<? if ($value['img'] != "") { ?>
					<img src="<?php echo $includes_dir . str_replace("../", "", $value['img']); ?>th.jpg" width="74" height="74" style="pointer-events:none"/>
				<? } else { ?>
					<span style="color:#aaa;font-size:9px;display:block;text-align:center;padding-top:20px;pointer-events:none">Clic o<br>arrastra</span>
				<? } ?>
			</span>
		</div>
		<div class="col one t-two m-three">
			<span class="imguploader2" ref="<?= $value['item_cat_fk'] . ":" . $value['item_ref']. ":" . $value['item_coleccion_id'] ?>" style="background-color:#000;display:block;width:74px;height:74px;cursor:pointer;overflow:hidden;position:relative" title="Clic o arrastra imagen JPG aquí (ambiente)">
				<input type="file" accept="image/jpeg,image/jpg" style="display:none" class="img-file-input" data-ref="<?= $value['item_cat_fk'] . ":" . $value['item_ref']. ":" . $value['item_coleccion_id'] ?>" data-type="2"/>
				<? if ($value['imgamb'] != "") { ?>
					<img src="<?php echo $includes_dir . str_replace("../", "", $value['imgamb']); ?>th.jpg" width="74" height="74" style="pointer-events:none"/>
				<? } else { ?>
					<span style="color:#aaa;font-size:9px;display:block;text-align:center;padding-top:20px;pointer-events:none">Clic o<br>arrastra<br>(amb)</span>
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
			<?php 
			if (isset($value['item_price_aux']) && trim($value['item_price_aux'])!='' && is_numeric($value['item_price_aux']))
				echo "<strong>Precio aux.: {$value['item_price_aux']}</strong><br />";
			?>
		</div>

		<div class="col two t-two m-three">
			<span class="del btn" id="<?= $value['item_id'] ?>"
				data-name="<?= htmlspecialchars($value['item_name'] ?: $value['item_ref']) ?>"
				data-url="/tienda/articulo/<?= urlenc($value['cat_name']) ?>/<?= urlenc($value['coleccion_name']) ?>/id/<?= $value['item_id'] ?>">Del</span>
			<span data-publico="<?if($value['publico3']==1)echo "0";else echo "1";?>" class="publicar btn" id="<?= $value['item_id'] ?>">
				<?if($value['publico3']==1)echo "Ocultar";else echo "Publicar";?>
			</span>
			<?php 
			/*
			<span class="edit btn" id="<?= $value['item_id'] ?>">Edit</span>
			*/
			?>
			<a style='background-color: #277BF1;' class="btn" href='/admin_library/editar_articulo/<?= $value['item_id']; ?>'>Editar</a>
			<a style='background-color: #5cb85c;' class="btn" href='/tienda/articulo/<?= urlenc($value['cat_name']) ?>/<?= urlenc($value['coleccion_name']) ?>/id/<?= $value['item_id'] ?>?test' target='_blank'>Ver</a>
		</div>
	</div>
<?
}
// $this->load->view('demo/paginador'); ?>
