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
?>
  <div class="container">
    <div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">Listado colecciones para META</div>
    <div style="height: 20px"></div>
    <div class="list">
      <?php
      /*
      <div class="sec row">
        <h1 class="col twelve" style="font-size: 1.2rem;color:#fff;background-color: #B05480;padding:5px;">
          <?php echo count($colecciones); ?> colecciones
        </h1>
      </div>
      <div class="sec row">
        <a style='background-color: #277BF1;' class="btn" href='/admin_library/quitar_todos_portada/<?= $idtipo; ?>'>Quitar todos del XML</a>
      </div>
      print '<pre><xmp>';
      print_r($categorias_ekam);
      print '</xmp></pre>';
      */
      $bg = false;
      foreach ($colecciones as $key => $value) {
        $bg = !$bg;
        $back_color="";
        if ($bg)
          $back_color=" style='background-color:#f1f1f1' ";
        ?>
        <div  id='coleccion_<?php echo $value->coleccion_id; ?>' class="sec row" <?php echo $back_color; ?> >
          <div class="col one t-two m-three">
            <span style="background-color: #000;display:block;width:74px;height:74px">
              <? if ($value->col_img != "") { ?>
                <img src="<?php echo $includes_dir . str_replace("../", "", $value->col_img); ?>th.jpg" width="74" height="74"/>
              <? } ?>
            </span>
          </div>
          <div class="col one t-two m-three">
            <span style="background-color: #000;display:block;width:74px;height:74px">
              <? if ($value->col_ambimg != "") { ?>
                <img src="<?php echo $includes_dir . str_replace("../", "", $value->col_ambimg); ?>th.jpg" width="74" height="74"/>
              <? } ?>
            </span>
          </div>
          <div class="col seven t-four m-three">
            <?= $value->cat_name ?> - <?= $value->coleccion_name ?><br/>
          </div>

          <div class="col two t-two m-three">
            <a style='background-color: #277BF1;' class="btn" href='/admin_library/quitar_meta/<?= $value->coleccion_id; ?>'>Quitar</a>
          </div>
        </div>
      <?
      }

      $this->load->view('includes/scripts'); 
      ?> 
    </div>
    <div style="height: 20px"></div>
  </div>
</body>
</html>
