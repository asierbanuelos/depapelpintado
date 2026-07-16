<?php 
if (isset($col['null']))
  unset($col['null']);

if (isset($_GET['test']) && $_GET['test']=='eneko'){
  print '<pre><xmp>';
  print_r($col);
  print '</xmp></pre>';
}

?>

<div class="wrapper">
  <h1 class="titulo-1-grande pt-4 pb-4 text-center"><?php echo $texto_h1_seccion; ?></h1>
  <div class="container">
    <?php 
    $this->load->view('frontend/migas_nuevas_small', $this->data);
    if (trim($fab->cat_text)!=''){
      ?>
      <div class='col-12'>
        <div class="contenido-colapsable texto-seo"><?php echo $fab->cat_text;?></div>
        <button class="my_collapsible " aria-label="Ver más"></button>
      </div>
      <?php
    }
    ?>
    <h2 class='titulo-1 text-center pb-4 '><?php echo $texto_h2_seccion; ?></h2> 
    
    <?php

    echo "<div class='row listado prefichas prefichas prefichas-nuevas'> \n";
    $count=0;

    // ---- Pagina de marca (todos los tipos): UNA sola lista de colecciones, sin agrupar por tipo ----
    if ($categ==-1 && isset($col_flat)){
      foreach($col_flat as $c){
        if ($c['ccats']=='null') continue;
        $url_coleccion='/marcas/'.urlenc($fab->cat_name).'/'.urlenc($c['coleccion_name']);
        ?>
        <div class="subcategory-block col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 col-sp-12">
          <div class="preficha subcategory-image">
            <a href="<?php echo $url_coleccion;?>" title="<?php echo $c['coleccion_name']; ?>" >
              <img class="img-fluid" height="316" width="316" src="/includes/<?php echo str_replace('../', '', $c['col_img'].'th.jpg'); ?>" alt="<?php echo $c['coleccion_name']; ?>" title='<?php echo $c['coleccion_name']; ?>' />
            </a>
          </div>
          <div class="subcategory-meta tit-centrado-imagen text-center">
            <h4>
              <a href="<?php echo $url_coleccion;?>" title="<?php echo $c['coleccion_name']; ?>" >
                <?php echo $c['coleccion_name']; ?>
              </a>
            </h4>
            <div class="subcategory-description"></div>
          </div>
        </div>
        <?php
      }
    }
    else
    foreach($col as $tipo_producto_aux => $colecciones_tipo_producto){
      if ($categ==-1){
        switch ($tipo_producto_aux) {
          case 0: $categ_aux = "Papel Pintado";
                  $seccionbase="papel_pintado";
                  break;
          case 1: $categ_aux = "Murales";
                  $seccionbase="murales";
                  break;
          case 2: $categ_aux = "Revestimientos";
                  $seccionbase="revestimientos";
                  break;
          case 3: $categ_aux = "Telas";
                  $seccionbase="telas";
                  break;
          case 4: $categ_aux = "Alfombras";
                  $seccionbase="alfombras";
                  break;
          case 5: $categ_aux = "Herramientas";
                  $seccionbase="Herramientas";
                  break;
          default: break;
        }
        $url_marca = '/tienda/'.$seccionbase.'/marca/'.$url_marca_aux;
        echo "<div class='col-12'><h3 class='h4 mb-4'>Colecciones de $categ_aux </h3></div>  \n";
      }
      foreach($colecciones_tipo_producto as $c){

        if($c['ccats']!='null' && ($categ==-1 || $categ==$tipo_producto_aux)){
          //$url_coleccion='colecciones-'.$url_categoria_principal.'/'.urlenc($fab->cat_name).'/'.urlenc($c['coleccion_name']).'/'.urlenc($c['coleccion_id']);
          $url_coleccion=$url_marca.'/'.urlenc($c['coleccion_id']).'/'.urlenc($c['coleccion_name']);
          ?>
          <div class="subcategory-block col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-12 col-sp-12">
            <div class="preficha subcategory-image">
              <a href="<?php echo $url_coleccion;?>" title="<?php echo $c['coleccion_name']; ?>" >
                <img class="img-fluid" height="316" width="316" src="/includes/<?php echo str_replace('../', '', $c['col_img'].'th.jpg'); ?>" alt="<?php echo $c['coleccion_name']; ?>" title='<?php echo $c['coleccion_name']; ?>' />
              </a>
            </div>
            <div class="subcategory-meta tit-centrado-imagen text-center">
              <?php
              if (count($col)>1){
              ?>
              <h4>
                <a href="<?php echo $url_coleccion;?>" title="<?php echo $c['coleccion_name']; ?>" >
                  <?php echo $c['coleccion_name']; ?>
                </a>
              </h4>
              <?php
              }
              else{
              ?>
              <h3>
                <a href="<?php echo $url_coleccion;?>" title="<?php echo $c['coleccion_name']; ?>" >
                  <?php echo $c['coleccion_name']; ?>
                </a>
              </h3>
              <?php
              }
              ?>
              <div class="subcategory-description"></div>
            </div>
          </div>
          <?php
          /*
          <li <?if($count%4==0) echo 'style="clear:both"; ';$count++;?>>
          <div class="preficha">
          <?php if(isset($c['novedad_bool']) && $c['novedad_bool']==1):?>
          <div style="position:absolute;top:0px;right:0;z-index: 1000;width:90px"><img class="novedad" alt="novedad" src="<?=$includes_dir?>images/novedad_der.png"></div>      
          <?php endif;?>
          <?if($c['cdisc']==1){?>
          <div style="position:absolute;right:0px;top:0px;z-index: 1000;width:75px"><img src="<?=$includes_dir?>images/descuento.png"></div>
          <div style="position:absolute;right:0px;top:0px;z-index: 1001;width:75px;height:75px;text-align: center;color: #fff;font-weight: bold;padding-top:25px;font-size: 10px;">Descuento</div>
          <?}?>
          <a href="<?php echo $url_coleccion;?>">
          <img data-id="<?=$c['coleccion_id']?>" class="colecc" alt="<?php echo $c['coleccion_name']; ?>" title="<?php echo $c['coleccion_name']; ?>" src="<?php echo $includes_dir.  str_replace("../", "", $c['col_img']); ?>th.jpg"/></span>
          </a>
          </div>
          <br/>     
          <a href="<?php echo $url_coleccion;?>">
          <span><strong><?=$c['coleccion_name'];?></strong></span>
          </a>
          </li>
          <?php
          */
        }
      }
    }

        /*
      foreach ($a_categorias as $idcategoria=>$datos_categoria){
        ?>
        <div class="subcategory-block col-xl-4 col-lg-4 col-md-4 col-sm-6 col-xs-12 col-sp-12">
          <div class="preficha subcategory-image">
            <a href="<?php echo $datos_categoria['url'];?>" title="<?php echo $datos_categoria['nombre']; ?>" >
              <img class="img-fluid" src="/includes/<?php echo str_replace('../', '', $datos_categoria['img'].'th.jpg'); ?>" alt="<?php echo $datos_categoria['nombre']; ?>" title='<?php echo $datos_categoria['nombre']; ?>' />
            </a>
          </div>
          <div class="subcategory-meta tit-centrado-imagen text-center">
            <h2>
              <a href="<?php echo $datos_categoria['url'];?>" title="<?php echo $datos_categoria['nombre']; ?>" >
                <?php echo $datos_categoria['nombre']; ?>
              </a>
            </h2>
            <div class="subcategory-description"></div>
          </div>
        </div>
        <?php 
      }
      */
      ?>
  </div>
</div>

<script>
  var botones_collapse = document.getElementsByClassName("my_collapsible");
  var i;
  for (i = 0; i < botones_collapse.length; i++) {
    var content = botones_collapse[i].previousElementSibling;
    if(content.scrollHeight<50)
      botones_collapse[i].style.display = "none";
  }
  
  for (i = 0; i < botones_collapse.length; i++) {
    botones_collapse[i].addEventListener("click", function() {
      this.classList.toggle("active");
      var content = this.previousElementSibling;
      if (content.style.maxHeight){
        content.style.maxHeight = null;
      } else {
        content.style.maxHeight = content.scrollHeight + "px";
      } 
    });
  }
</script>
<?php
/*
<div class="unit-100"><p><?=$fab->cat_text2;?></p></div>
*/
?>
