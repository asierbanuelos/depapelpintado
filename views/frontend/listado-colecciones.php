<?php 
if (isset($col['null']))
  unset($col['null']);

if (isset($_GET['test']) && $_GET['test']=='eneko'){
  print '<pre><xmp>';
  print_r($col);
  print '</xmp></pre>';
}

// ---- SEO marca (PILOTO gated con ?preview_seo=1). Para activar en TODAS las marcas: poner true. ----
$preview_seo_marca = isset($_GET['preview_seo']);
$marca_nombre_seo  = isset($fab->cat_name) ? trim($fab->cat_name) : '';
$marca_slug_seo    = $marca_nombre_seo!=='' ? urlenc($marca_nombre_seo) : '';
$marca_id_seo      = isset($id_marca_seo) ? (int)$id_marca_seo : (isset($fab->cat_id)?(int)$fab->cat_id:0);
$tipos_marca_seo   = array(); // seg-url => etiqueta
if (isset($fab->cats) && trim($fab->cats)!==''){
  $map_seg_seo = array('papel pintado'=>'papel-pintado','foto murales'=>'murales','fotomurales'=>'murales','murales'=>'murales','revestimientos'=>'revestimientos','telas'=>'telas','alfombras'=>'alfombras');
  foreach (explode(',', $fab->cats) as $t){
    $t = trim($t); $k = mb_strtolower($t, 'UTF-8');
    if (isset($map_seg_seo[$k])) $tipos_marca_seo[$map_seg_seo[$k]] = $t;
  }
}
?>
<?php if ($preview_seo_marca): ?>
<style>
.marca-seo-intro .texto-seo{max-width:820px;margin:0 auto 6px;color:#555;line-height:1.6}
.marca-seo-links{display:flex;flex-wrap:wrap;gap:8px;justify-content:center;align-items:center}
.marca-seo-links .lbl{color:#888;font-size:.9rem}
.btn-marca-seo{display:inline-block;padding:7px 14px;border:1px solid #d9c2ce;border-radius:24px;color:#8f3a63;font-size:.9rem;text-decoration:none;transition:.15s}
.btn-marca-seo:hover{background:#8f3a63;color:#fff}
.marca-seo-faqs{padding:24px 0 8px}
.marca-seo-faqs .faq-item{max-width:820px;margin:0 auto 10px;border:1px solid #eee;border-radius:8px;padding:4px 16px;background:#fff}
.marca-seo-faqs summary{cursor:pointer;font-weight:600;padding:12px 0;list-style:none}
.marca-seo-faqs summary::-webkit-details-marker{display:none}
.marca-seo-faqs summary::after{content:"+";float:right;color:#8f3a63;font-size:1.2rem}
.marca-seo-faqs details[open] summary::after{content:"\2212"}
.marca-seo-faqs .faq-respuesta{padding:0 0 14px;color:#555;line-height:1.6}
</style>
<?php endif; ?>

<div class="categ-breadcrumb-bar">
  <div class="container">
    <?php $this->load->view('frontend/migas_nuevas_small', $this->data); ?>
  </div>
</div>
<div class="wrapper">
  <h1 class="titulo-1-grande pt-2 pb-4 text-center"><?php echo $texto_h1_seccion; ?></h1>
  <div class="container">
    <?php if ($preview_seo_marca): ?>
      <?php if (trim($fab->cat_text)==='' && $marca_nombre_seo!==''): ?>
        <div class="col-12 marca-seo-intro">
          <p class="text-center texto-seo">En <strong>depapelpintado.es</strong> encontrarás toda la colección de <strong><?php echo htmlspecialchars($marca_nombre_seo, ENT_QUOTES, 'UTF-8'); ?></strong><?php if(count($tipos_marca_seo)):?> en <?php echo htmlspecialchars(implode(', ', array_values($tipos_marca_seo)), ENT_QUOTES, 'UTF-8');?><?php endif;?>. Diseños originales con envío a toda España; explora sus colecciones y encuentra el tuyo.</p>
        </div>
      <?php endif; ?>
      <?php if (count($tipos_marca_seo) && $marca_id_seo && $marca_slug_seo!==''): ?>
        <div class="col-12 marca-seo-links pb-3">
          <span class="lbl">Explorar:</span>
          <?php foreach ($tipos_marca_seo as $seg=>$label): ?>
            <a class="btn-marca-seo" href="/<?php echo $seg;?>/marca/<?php echo $marca_id_seo;?>/<?php echo $marca_slug_seo;?>">Ver <?php echo htmlspecialchars(mb_strtolower($label,'UTF-8').' '.$marca_nombre_seo, ENT_QUOTES, 'UTF-8');?></a>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
    <?php
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
            <div class="subcategory-description"><?php if($preview_seo_marca && $marca_nombre_seo!==''){ echo 'Colección de '.htmlspecialchars($marca_nombre_seo, ENT_QUOTES, 'UTF-8'); } ?></div>
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

<?php if ($preview_seo_marca): ?>
  <?php if (!empty($faqs_marca)): ?>
  <div class="wrapper marca-seo-faqs">
    <div class="container">
      <h2 class="titulo-1 text-center pb-4">Preguntas frecuentes sobre <?php echo htmlspecialchars($marca_nombre_seo, ENT_QUOTES, 'UTF-8'); ?></h2>
      <?php foreach ($faqs_marca as $f): ?>
        <details class="faq-item">
          <summary><?php echo htmlspecialchars($f->pregunta, ENT_QUOTES, 'UTF-8'); ?></summary>
          <div class="faq-respuesta"><?php echo $f->respuesta; ?></div>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>
  <?php
  // Datos estructurados: Brand (+ FAQPage si hay preguntas)
  $ld_blocks = array();
  $ld_blocks[] = '{"@context":"https://schema.org","@type":"Brand","name":'.json_encode($marca_nombre_seo, JSON_UNESCAPED_UNICODE).',"url":'.json_encode(base_url().'marcas/'.$marca_slug_seo, JSON_UNESCAPED_UNICODE).'}';
  if (!empty($faqs_marca)){
    $qs = array();
    foreach ($faqs_marca as $f){
      $qs[] = '{"@type":"Question","name":'.json_encode(trim(strip_tags($f->pregunta)), JSON_UNESCAPED_UNICODE).',"acceptedAnswer":{"@type":"Answer","text":'.json_encode(trim(strip_tags($f->respuesta)), JSON_UNESCAPED_UNICODE).'}}';
    }
    $ld_blocks[] = '{"@context":"https://schema.org","@type":"FAQPage","mainEntity":['.implode(',', $qs).']}';
  }
  foreach ($ld_blocks as $blk) echo '<script type="application/ld+json">'.$blk.'</script>'."\n";
  ?>
<?php endif; ?>

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
