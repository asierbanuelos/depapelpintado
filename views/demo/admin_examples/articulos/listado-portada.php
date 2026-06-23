<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Listado artículos en portada</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
<?php 
$this->load->view('includes/demo_header');
$a_tipos[0]='Papel Pintado';
$a_tipos[1]='Fotomurales';
$a_tipos[2]='Revestimientos';
$a_tipos[3]='Telas';
$a_tipos[4]='Alfombras';
$a_tipos[5]='Herramientas';
?>
  <div class="container">
    <div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">LISTADO ARTICULOS PORTADA</div>
    <div style="height: 20px"></div>
    <div class="list">
      <div class="sec row">
        <?php 
        foreach ($a_tipos as $id_aux => $txt_aux) {
          if($id_aux!=$idtipo && $id_aux!=5){
          ?>
            <div class="col three" style='text-align:center;margin-bottom:15px;'>
              <a style="font-size:25px;color: #B05380;text-decoration:none;" href='/admin_library/listado_articulos_portada/<?php echo $id_aux; ?>'><?php echo $txt_aux; ?></a>
            </div>
          <?php  
          }
        }
        ?>
      </div>
      <div class="sec row">
        <h1 class="col twelve" style="font-size: 1.2rem;color:#fff;background-color: #B05480;padding:5px;">
          <?php echo $a_tipos[$idtipo]; ?> (<?php echo count($a_articulos); ?>)
        </h1>
      </div>
      <div class="sec row">
        <a style='background-color: #277BF1;' class="btn" href='/admin_library/quitar_todos_portada/<?= $idtipo; ?>'>Quitar todos de portada</a>
      </div>
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
          <div class="col twelve referencia">
          <?php 
          /*
            <input type="checkbox" class='seleccion_items' name="item_seleccionado[<?= $value['item_id'] ?>]" id="item_check_<?= $value['item_id'] ?>" value="<?= $value['item_id'] ?>"/>
            <label for="item_check_<?= $value['item_id'] ?>"><?= $value['item_ref'] ?></label>
          */
          ?>
          </div>
          <div class="col one t-two m-three">
            <span class="imguploader" ref="<?= $value['item_cat_fk'] . ":" . $value['item_ref']. ":" . $value['item_coleccion_id'] ?>" style="background-color: #000;display:block;width:74px;height:74px;cursor:pointer;">
              <? if ($value['img'] != "") { ?>
                <img src="<?php echo $includes_dir . str_replace("../", "", $value['img']); ?>th.jpg" width="74" height="74"/>
              <? } ?>
              <input type="file" accept="image/jpeg,image/jpg,image/png,image/webp" style="display:none" class="img-file-input" data-ref="<?= $value['item_cat_fk'] . ":" . $value['item_ref']. ":" . $value['item_coleccion_id'] ?>" data-type="1"/>
            </span>
          </div>
          <div class="col one t-two m-three">
            <span class="imguploader2" ref="<?= $value['item_cat_fk'] . ":" . $value['item_ref']. ":" . $value['item_coleccion_id'] ?>" style="background-color: #000;display:block;width:74px;height:74px;cursor:pointer;">
              <? if ($value['imgamb'] != "") { ?>
                <img src="<?php echo $includes_dir . str_replace("../", "", $value['imgamb']); ?>th.jpg" width="74" height="74"/>
              <? } ?>
              <input type="file" accept="image/jpeg,image/jpg,image/png,image/webp" style="display:none" class="img-file-input" data-ref="<?= $value['item_cat_fk'] . ":" . $value['item_ref']. ":" . $value['item_coleccion_id'] ?>" data-type="2"/>
            </span>
          </div>
          <div class="col seven t-four m-three">
            <?= $value['cat_name'] ?> - <?= $value['coleccion_name'] ?><br/>
            <?= $value['item_ref'] ?><br/>
            Orden: <?= $value['orden'] ?><br/>
          </div>

          <div class="col two t-two m-three">
            <a style='background-color: #277BF1;' class="btn" href='/admin_library/quitar_portada/<?= $idtipo; ?>/<?= $value['item_id']; ?>'>Quitar</a>
            <a style='background-color: #277BF1;' class="btn" target='_blank' href='/admin_library/editar_articulo/<?= $value['item_id']; ?>'>Editar</a>
          </div>
        </div>
      <?
      }

  $this->load->view('includes/scripts');
  ?>
  <script>
  function sendFileToServer(formData, spanObj, fileObj, endpoint) {
    var uploadURL = "<?= $includes_dir ?>grid/" + endpoint;
    $.ajax({
      url: uploadURL, type: "POST", contentType: false, processData: false,
      cache: false, data: formData, dataType: 'json',
      success: function(data) {
        if (data && data.ok) {
          var reader = new FileReader();
          reader.onload = function(e) {
            spanObj.find('img').remove();
            spanObj.prepend('<img src="' + e.target.result + '" width="74" height="74" style="pointer-events:none"/>');
          };
          reader.readAsDataURL(fileObj);
          spanObj.css('outline', '2px solid #00aa00');
        } else {
          spanObj.css('outline', '2px solid red');
          alert('Error: ' + (data ? data.msg : 'respuesta inesperada'));
        }
      },
      error: function(xhr) {
        spanObj.css('outline', '2px solid red');
        alert('Error de conexión: ' + xhr.status + ' - ' + xhr.responseText);
      }
    });
  }
  $(document).on('click', '.imguploader, .imguploader2', function(e) {
    if (!$(e.target).is('a, button')) $(this).find('.img-file-input').trigger('click');
  });
  $(document).on('change', '.img-file-input', function(e) {
    var ref = $(this).data('ref');
    var type = parseInt($(this).data('type'));
    var files = e.target.files;
    var span = $(this).parent();
    if (!files.length) return;
    var fd = new FormData();
    fd.append('file', files[0]);
    fd.append('fname', ref);
    sendFileToServer(fd, span, files[0], type === 1 ? 'up000uy.php' : 'up001uy.php');
    $(this).val('');
  });
  </script>
</body>
</html>
