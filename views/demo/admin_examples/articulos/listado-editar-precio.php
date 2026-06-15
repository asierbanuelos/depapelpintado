<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Listado artículos colección</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
<?php 
$this->load->view('includes/demo_header');
$a_tipos[0]='Papel Pintado';
$a_tipos[1]='Fotomural';
$a_tipos[2]='Revestimiento';
$a_tipos[3]='Tela';
$a_tipos[4]='Alfombra';
$a_tipos[5]='Herramienta';
?>
  <div class="container">
    <?php 
    echo form_open('admin_library/update_precios_coleccion');
    ?>
    <input type="hidden" id="idcoleccion" name="idcoleccion" value="<?php echo $coleccion->coleccion_id;?>"/>
    <div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">LISTADO ARTICULOS</div>
    <div class="sec row">
      <h1 class="col twelve" style="font-size: 1.2rem;color:#fff;background-color: #B05480;padding:5px;">
        <?php echo $coleccion->cat_name; ?> - <?php echo $coleccion->coleccion_name; ?>
      </h1>
    </div>
    <div style="height: 20px"></div>
    <div class="list">
      <?php
      /*
      print '<pre><xmp>';
      print_r($categorias_ekam);
      print '</xmp></pre>';
      */
      $bg = false;
      foreach ($a_articulos as $key => $value) {
        $bg = !$bg;
        $back_color="";
        if ($bg)
          $back_color=" style='background-color:#f1f1f1' ";
        ?>
        <div id='articulo_<?php echo $value['item_id']; ?>' class="sec row" <? echo $back_color; ?>>
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
          <div class="col four t-four m-three"  style='padding-top: 30px;'>
             <label for="precio_<?php echo $value['item_id']; ?>"><?php echo $value['item_ref'];?> (<?php echo $a_tipos[$value['item_tipo']];?>)</label>
          </div>

          <div class="col two t-two m-three" style='padding-top: 30px;'>
            <label for="precio_<?php echo $value['item_id']; ?>"><strong><?php echo $value['item_price'];?>&euro; </strong></label>
          </div>
          <div class="col one t-two m-three" style='padding-top: 30px;'>
            <strong> --> </strong>
          </div>
          <div class="col two t-two m-three" style='padding-top: 30px; text-align:left;'>
            <?php 
            $item_id=$value["item_id"];
            echo form_input("nuevo_precio[$item_id]", '', 'id="precio_'.$item_id.'" class="six" style="text-align:right;"'); ?>
          </div>
        </div>
      <?
      }

      $this->load->view('includes/scripts'); 
      ?> 
    </div>
    <div style="height: 20px"></div>
    <div style="text-align:center">
      <?php 
      echo form_submit("test", "Actualizar precios",'class="button orange-button six t-full m-full send"');
      echo form_close();
      ?>
    </div>
    <div style="height: 20px"></div>
  </div>
</body>
</html>
