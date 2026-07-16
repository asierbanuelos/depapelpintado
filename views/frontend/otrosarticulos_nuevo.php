<?php
/* 
print '<pre><xmp>';
print_r($otro);
print '</xmp></pret>';
print '<pre><xmp>';
print_r($key);
print '</xmp></pret>';

*/
if(isset($otro)){
	foreach ($otro as $i_otro => $producto_alternativo) {
		if ($key['item_id']==$producto_alternativo['item_id']){
			unset($otro[$i_otro]);
			break;
		}
	}
}
if(isset($otro) && count($otro)){
	// Más productos del mismo tipo y coleccióm
  switch ($key['item_tipo']) {
    case 0: $categ = "Papel Pintado";
            $texto_intro= "Otros papeles pintados de la colección <span>".$key['coleccion_name']."</span>";
            $seccionbase="papel_pintado";
            break;
    case 1: $categ = "Murales";
            $texto_intro= "Otros murales de la colección <span>".$key['coleccion_name']."</span>";
            $seccionbase="murales";
            break;
    case 2: $categ = "Revestimientos";
            $texto_intro= "Otros revestimientos de la colección <span>".$key['coleccion_name']."</span>";
            $seccionbase="revestimientos";
            break;
    case 3: $categ = "Telas";
            $texto_intro= "Otras telas de la colección <span>".$key['coleccion_name']."</span>";
            $seccionbase="telas";
            break;
    case 4: $categ = "Alfombras";
            $texto_intro= "Otras alfombras de la colección <span>".$key['coleccion_name']."</span>";
            $seccionbase="alfombras";
            break;
    case 5: $categ = "Herramientas";
            $texto_intro= "Otras herramientas ";
            $seccionbase="Herramientas";
            break;
    default: break;
  }

  $items_scroll = array_slice($otro, 0, 30);
  $url_coleccion='/marcas/'.urlenc($key['cat_name']).'/'.urlenc($key['coleccion_name']);
  echo "<h3 class='col-12 text-center pb-3 mb-0'>$texto_intro</h3> \n";
  echo "<div class='col-12 px-2'>";
  echo "<div class='otros-articulos-wrap'>";
  echo "<button class='otros-scroll-btn otros-scroll-left' onclick='scrollOtrosArticulos(-1)' aria-label='Anterior'>&#8249;</button>";
  echo "<div class='otros-articulos-scroll' id='otros-articulos-scroll'>";
  foreach ($items_scroll as $p) {
    $url_p='/'.urlenc($p['cat_name']).'/'.urlenc($p['coleccion_name']).'/'.urlenc((isset($p['item_name']) && trim($p['item_name'])!='')?$p['item_name']:$p['item_ref']).'-'.$p['item_id'];
    $img_p='/includes/'.str_replace('../', '', $p['img']).'th.jpg';
    echo "<a class='otro-art-card' href='".htmlspecialchars($url_p)."'>";
    echo "<img src='".htmlspecialchars($img_p)."' alt='".htmlspecialchars($p['item_ref'])."' loading='lazy' />";
    echo "<span>".htmlspecialchars($p['item_ref'])."</span>";
    echo "</a>";
  }
  echo "</div>";
  echo "<button class='otros-scroll-btn otros-scroll-right' onclick='scrollOtrosArticulos(1)' aria-label='Siguiente'>&#8250;</button>";
  echo "</div>";
  echo "</div>";
  echo "<div class='col-12 text-center mt-4'>\n";
  echo "<p class='link_button2 nomargin'><a href='$url_coleccion'>Ver todos los productos</a></p>\n";
  echo "</div>\n";
} 

if(isset($todas_las_colecciones) && count($todas_las_colecciones)>1){
  if (isset($datos_item_ko['item_tipo'])){
    switch ($datos_item_ko['item_tipo']) {
      case 0: $categ = "Papel Pintado";
              $texto_intro= "Otras colecciones de papeles pintado de <span>".$fabricante->cat_name."</span>";
              $seccionbase="papel_pintado";
              break;
      case 1: $categ = "Murales";
              $texto_intro= "Otras colecciones de murales de <span>".$fabricante->cat_name."</span>";
              $seccionbase="murales";
              break;
      case 2: $categ = "Revestimientos";
              $texto_intro= "Otras colecciones de revestimientos de <span>".$fabricante->cat_name."</span>";
              $seccionbase="revestimientos";
              break;
      case 3: $categ = "Telas";
              $texto_intro= "Otras colecciones de telas de <span>".$fabricante->cat_name."</span>";
              $seccionbase="telas";
              break;
      case 4: $categ = "Alfombras";
              $texto_intro= "Otras colecciones de alfombras de <span>".$fabricante->cat_name."</span>";
              $seccionbase="alfombras";
              break;
      case 5: $categ = "Herramientas";
              $texto_intro= "Otras herramientas ";
              $seccionbase="Herramientas";
              break;
      default: break;
    }
    $cuantas_mostrar=8; // cogemos 8 elementos
    echo "<h2>$texto_intro</h2> \n";
    ?>
    <ul class="blocks-4">
      <?php
      $cuantas_llevamos=0;
      foreach($todas_las_colecciones as $c){
        if ($c['coleccion_id']!=$datos_item_ko['item_coleccion_id']){
          $url_coleccion='/marcas/'.urlenc($fabricante->cat_name).'/'.urlenc($c['coleccion_name']);
          ?>
          <li >
            <div class="preficha">
              <?php if(isset($c['novedad_bool']) && $c['novedad_bool']==1):?>
                <div style="position:absolute;top:0px;right:0;z-index: 1000;width:90px"><img class="novedad" alt="novedad" src="<?=$includes_dir?>images/novedad_der.png"></div>      
              <?php endif;?>
              <?if($c['cdisc']==1){?>
                <div style="position:absolute;right:0px;top:0px;z-index: 1000;width:75px"><img src="<?=$includes_dir?>images/descuento.png"></div>
                <div style="position:absolute;right:0px;top:0px;z-index: 1001;width:75px;height:75px;text-align: center;color: #fff;font-weight: bold;padding-top:25px;font-size: 10px;">Descuento</div>
              <?}?>
              <a href="<?php echo $url_coleccion; ?>">
                <img data-id="<?=$c['coleccion_id']?>" class="colecc" alt="" src="<?php echo $includes_dir.  str_replace("../", "", $c['col_img']); ?>th.jpg"/></span>
            </div>
            <br/>
            <a href="<?php echo $url_coleccion; ?>"><span><strong><?=$c['coleccion_name'];?></strong></span></a>
          </li>
          <?
          $cuantas_llevamos++;
          if ($cuantas_llevamos>=$cuantas_mostrar)
            break;
        }
      }
      ?>
    </ul>
    <?php
  }
  else{
    $a_colecciones=array();
    foreach($todas_las_colecciones as $c){
      $a_tipos=explode(',', $c['ccats']);
      foreach ($a_tipos as $item_tipo){
        if ($c['activo']==1 && $c['publico2']==1)
          $a_colecciones[$item_tipo][$c['coleccion_id']]=$c;
      }
    }

    foreach ($a_colecciones as $item_tipo=>$colecciones_tipo){
      switch ($item_tipo) {
        case 0: $categ = "Papel Pintado";
                $seccionbase="papel_pintado";
                break;
        case 1: $categ = "Murales";
                $seccionbase="murales";
                break;
        case 2: $categ = "Revestimientos";
                $seccionbase="revestimientos";
                break;
        case 3: $categ = "Telas";
                $seccionbase="telas";
                break;
        case 4: $categ = "Alfombras";
                $seccionbase="alfombras";
                break;
        case 5: $categ = "Herramientas";
                $seccionbase="Herramientas";
                break;
        default: break;
      }

      //$texto_intro= "Catálogos de $categ <span>".$fabricante->cat_name."</span>";
      $texto_intro= "$categ <span>".$fabricante->cat_name."</span>";
      $cuantas_mostrar=4; // cogemos 8 elementos
      echo "<h2>$texto_intro</h2> \n";
      ?>
      <ul class="blocks-4">
        <?php
        $cuantas_llevamos=0;
        foreach($colecciones_tipo as $c){
          $url_coleccion='/marcas/'.urlenc($fabricante->cat_name).'/'.urlenc($c['coleccion_name']);
          ?>
          <li >
            <div class="preficha">
              <?php if(isset($c['novedad_bool']) && $c['novedad_bool']==1):?>
                <div style="position:absolute;top:0px;right:0;z-index: 1000;width:90px"><img class="novedad" alt="novedad" src="<?=$includes_dir?>images/novedad_der.png"></div>      
              <?php endif;?>
              <?if($c['cdisc']==1){?>
                <div style="position:absolute;right:0px;top:0px;z-index: 1000;width:75px"><img src="<?=$includes_dir?>images/descuento.png"></div>
                <div style="position:absolute;right:0px;top:0px;z-index: 1001;width:75px;height:75px;text-align: center;color: #fff;font-weight: bold;padding-top:25px;font-size: 10px;">Descuento</div>
              <?}?>
              <a href="<?php echo $url_coleccion; ?>">
                <img data-id="<?=$c['coleccion_id']?>" class="colecc" alt="" src="<?php echo $includes_dir.  str_replace("../", "", $c['col_img']); ?>th.jpg"/></span>
            </div>
            <br/>
            <a href="<?php echo $url_coleccion; ?>"><span><strong><?=$c['coleccion_name'];?></strong></span></a>
          </li>
          <?php
          $cuantas_llevamos++;
          if ($cuantas_llevamos>=$cuantas_mostrar)
            break;
        }
        ?>
      </ul>
      <?php

      if(count($colecciones_tipo) > $cuantas_llevamos){
        $url_marca='/marcas/'.urlenc($fabricante->cat_name);
        echo "<div class='unit-100 text-centered'>\n ";
        echo "<h3 class='link_button2'><a href='$url_marca' class=''>Ver todas las colecciones de $categ</a></h3> \n";
        echo "</div> \n";
      }
    }
  }
}
?>
