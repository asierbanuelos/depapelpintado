<?php
setlocale(LC_COLLATE, 'es_ES.utf8');

if (!function_exists('my_mb_ucfirst')) {
  function my_mb_ucfirst($str) {
    $fc = mb_strtoupper(mb_substr($str, 0, 1));
    return $fc.mb_substr($str, 1);
  }
}
$parametro_test='';
//if (isset($orden_seleccionado) && $orden_seleccionado!=0)
//  $parametro_test='&orden='.$orden_seleccionado;
/*
if (isset($_REQUEST['test']) && trim($_REQUEST['test'])=='eneko'){
  print '<pre><xmp>';
  print_r($filtros_categorias_seo);
  print '</xmp></pre>';
}
/*
$parametro_test.='&test=eneko';
*/
  echo "    <div class='pl-4 h5'>FILTRAR POR:</div>";

if (isset($_REQUEST['marca']) && trim($_REQUEST['marca'])!=''){
  $parametros_adicionales_marca[0]='marca='.$_REQUEST['marca'];
  $parametros_adicionales_estilo[0]='marca='.$_REQUEST['marca'];
  $parametros_adicionales_colores[0]='marca='.$_REQUEST['marca'];
  $parametros_adicionales_calidad[0]='marca='.$_REQUEST['marca'];
  $parametros_adicionales_limpieza[0]='marca='.$_REQUEST['marca'];
}
if (isset($_REQUEST['estilo']) && trim($_REQUEST['estilo'])!=''){
  $parametros_adicionales_marca[1]='estilo='.$_REQUEST['estilo'];
  $parametros_adicionales_estilo[1]='estilo='.$_REQUEST['estilo'];
  $parametros_adicionales_colores[1]='estilo='.$_REQUEST['estilo'];
  $parametros_adicionales_calidad[1]='estilo='.$_REQUEST['estilo'];
  $parametros_adicionales_limpieza[1]='estilo='.$_REQUEST['estilo'];
}
if (isset($_REQUEST['color']) && trim($_REQUEST['color'])!=''){
  $parametros_adicionales_marca[2]='color='.$_REQUEST['color'];
  $parametros_adicionales_estilo[2]='color='.$_REQUEST['color'];
  $parametros_adicionales_colores[2]='color='.$_REQUEST['color'];
  $parametros_adicionales_calidad[2]='color='.$_REQUEST['color'];
  $parametros_adicionales_limpieza[2]='color='.$_REQUEST['color'];
}
if (isset($_REQUEST['calidad']) && trim($_REQUEST['calidad'])!=''){
  $parametros_adicionales_marca[3]='calidad='.$_REQUEST['calidad'];
  $parametros_adicionales_estilo[3]='calidad='.$_REQUEST['calidad'];
  $parametros_adicionales_colores[3]='calidad='.$_REQUEST['calidad'];
  $parametros_adicionales_calidad[3]='calidad='.$_REQUEST['calidad'];
  $parametros_adicionales_limpieza[3]='calidad='.$_REQUEST['calidad'];
}
if (isset($_REQUEST['limpieza']) && trim($_REQUEST['limpieza'])!=''){
  $parametros_adicionales_marca[4]='limpieza='.$_REQUEST['limpieza'];
  $parametros_adicionales_estilo[4]='limpieza='.$_REQUEST['limpieza'];
  $parametros_adicionales_colores[4]='limpieza='.$_REQUEST['limpieza'];
  $parametros_adicionales_calidad[4]='limpieza='.$_REQUEST['limpieza'];
  $parametros_adicionales_limpieza[4]='limpieza='.$_REQUEST['limpieza'];
}



$enlace_principal='';
if (isset($url_especifica))
  $enlace_principal=$url_especifica;
elseif (isset($categoria_principal))
  $enlace_principal=$categoria_principal;
elseif(isset($categoria_seo)){
  $enlace_principal=$categoria_seo->nueva_categoria_name_url;
} 

if(isset($filtros_categorias_seo['colores'])){
  $aux_colores=array();
  if (isset($_REQUEST['color']) && trim($_REQUEST['color'])!='')
    $aux_colores=explode(',',$_REQUEST['color']);
  $a_seleccionadas=array();
  $a_seleccionables=array();
  foreach ($filtros_categorias_seo['colores'] as $color_txt => $ezaugarriak) {
    if (array_search($ezaugarriak['id'], $aux_colores)!==false)
        //$a_seleccionadas[$ezaugarriak['id']]=$color_txt.' ('.$ezaugarriak['cont'].')';
        $a_seleccionadas[$ezaugarriak['id']]=$color_txt;
    else
        //$a_seleccionables[$ezaugarriak['id']]=$color_txt.' ('.$ezaugarriak['cont'].')';
        $a_seleccionables[$ezaugarriak['id']]=$color_txt;
  }
  

  $a_tonalidades[1]['nombre_tonalidad']='Blanco/Negro';
  $a_tonalidades[1]['img_tonalidad']='/includes/images/tonalidades/blancos-negros';
  $a_tonalidades[2]['nombre_tonalidad']='Crudo/Marrón';
  $a_tonalidades[2]['img_tonalidad']='/includes/images/tonalidades/crudos-marrones';
  $a_tonalidades[3]['nombre_tonalidad']='Amarillos';
  $a_tonalidades[3]['img_tonalidad']='/includes/images/tonalidades/amarillos';
  $a_tonalidades[4]['nombre_tonalidad']='Azules/Morados';
  $a_tonalidades[4]['img_tonalidad']='/includes/images/tonalidades/azules-morados';
  $a_tonalidades[5]['nombre_tonalidad']='Rosas/Rojos';
  $a_tonalidades[5]['img_tonalidad']='/includes/images/tonalidades/rosas-rojos';
  $a_tonalidades[6]['nombre_tonalidad']='Verdes';
  $a_tonalidades[6]['img_tonalidad']='/includes/images/tonalidades/verdes';
  $a_tonalidades[7]['nombre_tonalidad']='Multicolor';
  $a_tonalidades[7]['img_tonalidad']='/includes/images/tonalidades/multicolor';
  $a_tonalidades[8]['nombre_tonalidad']='Metalizados';
  $a_tonalidades[8]['img_tonalidad']='/includes/images/tonalidades/metalizados';



  //if (isset($_GET['testing']) && $_GET['testing']=='eneko'){
    if (isset($filtros_categorias_seo['tonalidades']) && count($filtros_categorias_seo['tonalidades'])){
      //echo "    <div class='pl-4 grupo-filtro'>{$familia_producto} por <span>Tonalidades</span></div>";
      //echo "    <div class='pl-4 grupo-filtro'><span>Tonalidades</span> de {$familia_producto}</div>";
      echo "    <div id='filtro-tonalidades' class='pl-4 grupo-filtro'><span>Tonalidades</span></div>";
      if(count($a_seleccionadas)){
        asort($a_seleccionadas, SORT_LOCALE_STRING);
        echo "    <ul class='pl-4 mb-2 filtros-seleccionados'>";
        foreach ($a_seleccionadas as $idseleccionada => $texto_seleccionada) {
          $a_colores=$aux_colores;
          unset($a_colores[array_search($idseleccionada, $a_colores)]);
          
          if (count($a_colores))
            $parametros_adicionales_colores[2]='color='.implode(',',$a_colores);
          else
            unset($parametros_adicionales_colores[2]);

          $parametros_txt='';
          if (count($parametros_adicionales_colores)){
            ksort($parametros_adicionales_colores);
            $parametros_txt='?'.implode('&', $parametros_adicionales_colores);
          }
          echo "    <li class='py-1'><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'> <span>x</span> {$texto_seleccionada}</a></li>";
        }
        echo "    </ul>";
      }
      //echo "    <ul class='pl-4' style='list-style:none;'>";
      echo "    <ul class='pl-4 mb-4'>";
      foreach ($a_tonalidades as $idtonalidad => $ezaugarriak) {
        if (isset($filtros_categorias_seo['tonalidades'][$idtonalidad])){
          $a_colores=$aux_colores;

          foreach($filtros_categorias_seo['tonalidades'][$idtonalidad] as $idseleccionable){
            if (!in_array($idseleccionable, $a_colores))
              $a_colores[]=$idseleccionable;
          }

          $parametros_adicionales_colores[2]='color='.implode(',',$a_colores);
          ksort($parametros_adicionales_colores);
          $parametros_txt='?'.implode('&', $parametros_adicionales_colores);

          //echo "    <li><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'>{$texto_seleccionable}</a></li>";
          
          echo "    <li><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'>";
          echo "    <picture>";
          echo "        <source srcset='{$ezaugarriak['img_tonalidad']}.webp' type='image/webp'>";
          echo "        <source srcset='{$ezaugarriak['img_tonalidad']}.png' type='image/jpeg'>";   
          echo "        <img class='' src='{$ezaugarriak['img_tonalidad']}.png' alt='colores ".strtolower($ezaugarriak['nombre_tonalidad'])."' height='20' width='38'>";
          echo "      </picture>";
          echo "{$ezaugarriak['nombre_tonalidad']}</a></li>";
        }
      }
      echo "    </ul>";
      //echo "    <button class='pl-4 my_collapsible my_collapsible_colores my_collapsible_filtros' aria-label='Ver más'></button>";
    }
  //}

  /*
  echo "    <div class='pl-4 grupo-filtro'>{$familia_producto} por <span>Colores</span></div>";
  if(count($a_seleccionadas)){
    asort($a_seleccionadas, SORT_LOCALE_STRING);
    echo "    <ul class='pl-4 mb-2 filtros-seleccionados'>";
    foreach ($a_seleccionadas as $idseleccionada => $texto_seleccionada) {
      $a_colores=$aux_colores;
      unset($a_colores[array_search($idseleccionada, $a_colores)]);
      
      if (count($a_colores))
        $parametros_adicionales_colores[2]='color='.implode(',',$a_colores);
      else
        unset($parametros_adicionales_colores[2]);

      $parametros_txt='';
      if (count($parametros_adicionales_colores)){
        ksort($parametros_adicionales_colores);
        $parametros_txt='?'.implode('&', $parametros_adicionales_colores);
      }
      echo "    <li class='py-1'><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'> <span>x</span> {$texto_seleccionada}</a></li>";
    }
    echo "    </ul>";
  }

  if(count($a_seleccionables)){
    asort($a_seleccionables, SORT_LOCALE_STRING);
    echo "    <ul class='pl-4' style='list-style:none;'>";
    foreach ($a_seleccionables as $idseleccionable => $texto_seleccionable) {
      $a_colores=$aux_colores;
      $a_colores[]=$idseleccionable;

      $parametros_adicionales_colores[2]='color='.implode(',',$a_colores);
      ksort($parametros_adicionales_colores);
      $parametros_txt='?'.implode('&', $parametros_adicionales_colores);

      echo "    <li><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'>{$texto_seleccionable}</a></li>";
    }
    echo "    </ul>";
    echo "    <button class='pl-4 my_collapsible my_collapsible_colores my_collapsible_filtros' aria-label='Ver más'></button>";
  }
  /*
  echo "    <ul>";
  foreach ($filtros_categorias_seo['colores'] as $color_txt => $ezaugarriak) {
    $a_colores=$aux_colores;
    if (array_search($ezaugarriak['id'], $a_colores)!==false)
      unset($a_colores[array_search($ezaugarriak['id'], $a_colores)]);
    else
      $a_colores[]=$ezaugarriak['id'];

    if (count($a_colores))
      $parametros_adicionales_colores[2]='color='.implode(',',$a_colores);
    else
      unset($parametros_adicionales_colores[2]);

    $parametros_txt='';
    if (count($parametros_adicionales_colores)){
      ksort($parametros_adicionales_colores);
      $parametros_txt='?'.implode('&', $parametros_adicionales_colores);
    }
    //echo "    <li><a href='/{$enlace_principal}?color={$ezaugarriak['id']}{$parametro_test}'>{$color_txt} ({$ezaugarriak['cont']})</a></li>";
    echo "    <li><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}'>{$color_txt} ({$ezaugarriak['cont']})</a></li>";
  }
  echo "    </ul>";
  */
}

if(isset($filtros_categorias_seo['marcas']) && !isset($productos_coleccion) && !isset($ocultar_marcas)){
  $aux_marcas=array();
  if (isset($_REQUEST['marca']) && trim($_REQUEST['marca'])!='')
    $aux_marcas=explode(',',$_REQUEST['marca']);
  $a_seleccionadas=array();
  $a_seleccionables=array();
  foreach ($filtros_categorias_seo['marcas'] as $marca_txt => $ezaugarriak) {
    if (array_search($ezaugarriak['id'], $aux_marcas)!==false)
        //$a_seleccionadas[$ezaugarriak['id']]=$marca_txt.' ('.$ezaugarriak['cont'].')';
        $a_seleccionadas[$ezaugarriak['id']]=$marca_txt;
    else
        //$a_seleccionables[$ezaugarriak['id']]=$marca_txt.' ('.$ezaugarriak['cont'].')';
        $a_seleccionables[$ezaugarriak['id']]=$marca_txt;
  }

  if(count($filtros_categorias_seo['marcas'])){
    //echo "    <div class='pl-4 grupo-filtro'>{$familia_producto} por Marcas</div>";
    //echo "    <div class='pl-4 grupo-filtro'>{$familia_producto} por <span>Marcas</span></div>";
    //echo "    <div class='pl-4 grupo-filtro'><span>Marcas</span> de {$familia_producto}</div>";
    echo "    <div id='filtro-marcas' class='pl-4 grupo-filtro'><span>Marcas</span></div>";
    if(count($a_seleccionadas)){
      asort($a_seleccionadas, SORT_LOCALE_STRING);
      echo "    <ul class='pl-4 mb-2 filtros-seleccionados'>";
      foreach ($a_seleccionadas as $idseleccionada => $texto_seleccionada) {
        $a_marcas=$aux_marcas;
        unset($a_marcas[array_search($idseleccionada, $a_marcas)]);
        
        if (count($a_marcas))
          $parametros_adicionales_marca[0]='marca='.implode(',',$a_marcas);
        else
          unset($parametros_adicionales_marca[0]);

        $parametros_txt='';
        if (count($parametros_adicionales_marca)){
          ksort($parametros_adicionales_marca);
          $parametros_txt='?'.implode('&', $parametros_adicionales_marca);
        }
        echo "    <li class='py-1'><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'> <span>x</span> {$texto_seleccionada}</a></li>";
      }
      echo "    </ul>";
    }

    if(count($a_seleccionables)){
      asort($a_seleccionables, SORT_LOCALE_STRING);
      echo "    <ul class='pl-4' style='list-style:none;'>";
      foreach ($a_seleccionables as $idseleccionable => $texto_seleccionable) {
        $a_marcas=$aux_marcas;
        $a_marcas[]=$idseleccionable;

        $parametros_adicionales_marca[0]='marca='.implode(',',$a_marcas);
        ksort($parametros_adicionales_marca);
        $parametros_txt='?'.implode('&', $parametros_adicionales_marca);

        echo "    <li><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'>{$texto_seleccionable}</a></li>";
      }
      echo "    </ul>";
      echo "    <button class='pl-4 my_collapsible my_collapsible_marcas my_collapsible_filtros' aria-label='Ver más'></button>";
    }
  }
}

if(isset($filtros_categorias_seo['estilos']) && isset($mostrar_estilos_viejos)){
  $aux_estilos=array();
  if (isset($_REQUEST['estilo']) && trim($_REQUEST['estilo'])!='')
    $aux_estilos=explode(',',$_REQUEST['estilo']);
  $a_seleccionadas=array();
  $a_seleccionables=array();
  foreach ($filtros_categorias_seo['estilos'] as $estilo_txt => $ezaugarriak) {
    if (array_search($ezaugarriak['id'], $aux_estilos)!==false)
        //$a_seleccionadas[$ezaugarriak['id']]=$estilo_txt.' ('.$ezaugarriak['cont'].')';
        $a_seleccionadas[$ezaugarriak['id']]=$estilo_txt;
    else
        //$a_seleccionables[$ezaugarriak['id']]=$estilo_txt.' ('.$ezaugarriak['cont'].')';
        $a_seleccionables[$ezaugarriak['id']]=$estilo_txt;
  }

  //echo "    <div class='pl-4 grupo-filtro'>{$familia_producto} por <span>Estilos</span></div>";
  //echo "    <div class='pl-4 grupo-filtro'><span>Estilos</span> de {$familia_producto}</div>";
  echo "    <div id='filtro-estilos' class='pl-4 grupo-filtro'><span>Estilos</span></div>";
  if(count($a_seleccionadas)){
    asort($a_seleccionadas, SORT_LOCALE_STRING);
    echo "    <ul class='pl-4 mb-2 filtros-seleccionados'>";
    foreach ($a_seleccionadas as $idseleccionada => $texto_seleccionada) {
      $a_estilos=$aux_estilos;
      unset($a_estilos[array_search($idseleccionada, $a_estilos)]);
      
      if (count($a_estilos))
        $parametros_adicionales_estilo[1]='estilo='.implode(',',$a_estilos);
      else
        unset($parametros_adicionales_estilo[1]);

      $parametros_txt='';
      if (count($parametros_adicionales_estilo)){
        ksort($parametros_adicionales_estilo);
        $parametros_txt='?'.implode('&', $parametros_adicionales_estilo);
      }
      echo "    <li class='py-1'><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'> <span>x</span> {$texto_seleccionada}</a></li>";
    }
    echo "    </ul>";
  }

  if(count($a_seleccionables)){
    asort($a_seleccionables, SORT_LOCALE_STRING);
    echo "    <ul class='pl-4' style='list-style:none;'>";
    foreach ($a_seleccionables as $idseleccionable => $texto_seleccionable) {
      $a_estilos=$aux_estilos;
      $a_estilos[]=$idseleccionable;

      $parametros_adicionales_estilo[1]='estilo='.implode(',',$a_estilos);
      ksort($parametros_adicionales_estilo);
      $parametros_txt='?'.implode('&', $parametros_adicionales_estilo);

      echo "    <li><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'>".my_mb_ucfirst(mb_strtolower($texto_seleccionable))."</a></li>";
    }
    echo "    </ul>";
    echo "    <button class='pl-4 my_collapsible my_collapsible_estilos my_collapsible_filtros' aria-label='Ver más'></button>";
 }
}

if(isset($filtros_categorias_seo['calidades'])){
$aux_calidades=array();
  if (isset($_REQUEST['calidad']) && trim($_REQUEST['calidad'])!='')
    $aux_calidades=explode(',',$_REQUEST['calidad']);
  $a_seleccionadas=array();
  $a_seleccionables=array();
  foreach ($filtros_categorias_seo['calidades'] as $calidad_txt => $ezaugarriak) {
    if (array_search($ezaugarriak['id'], $aux_calidades)!==false)
        //$a_seleccionadas[$ezaugarriak['id']]=$estilo_txt.' ('.$ezaugarriak['cont'].')';
        $a_seleccionadas[$ezaugarriak['id']]=$calidad_txt;
    else
        //$a_seleccionables[$ezaugarriak['id']]=$estilo_txt.' ('.$ezaugarriak['cont'].')';
        $a_seleccionables[$ezaugarriak['id']]=$calidad_txt;
  }
  /*
  print '<pre><xmp>';
  print_r($a_seleccionadas);
  print '</xmp></pre>';
  */
  //echo "    <div class='pl-4 grupo-filtro'>{$familia_producto} por <span>Estilos</span></div>";
  //echo "    <div class='pl-4 grupo-filtro'><span>Estilos</span> de {$familia_producto}</div>";
  echo "    <div id='filtro-calidad' class='pl-4 grupo-filtro'><span>Calidad</span></div>";
  if(count($a_seleccionadas)){
    asort($a_seleccionadas, SORT_LOCALE_STRING);
    echo "    <ul class='pl-4 mb-2 filtros-seleccionados'>";
    foreach ($a_seleccionadas as $idseleccionada => $texto_seleccionada) {
      $a_calidades=$aux_calidades;
      unset($a_calidades[array_search($idseleccionada, $a_calidades)]);
      
      if (count($a_calidades))
        $parametros_adicionales_calidad[3]='calidad='.implode(',',$a_calidades);
      else
        unset($parametros_adicionales_calidad[3]);

      $parametros_txt='';
      if (count($parametros_adicionales_calidad)){
        ksort($parametros_adicionales_calidad);
        $parametros_txt='?'.implode('&', $parametros_adicionales_calidad);
      }
      echo "    <li class='py-1'><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'> <span>x</span> {$texto_seleccionada}</a></li>";
    }
    echo "    </ul>";
  }

  if(count($a_seleccionables)){
    asort($a_seleccionables, SORT_LOCALE_STRING);
    echo "    <ul class='pl-4' style='list-style:none;'>";
    foreach ($a_seleccionables as $idseleccionable => $texto_seleccionable) {
      $a_calidades=$aux_calidades;
      $a_calidades[]=$idseleccionable;

      $parametros_adicionales_calidad[3]='calidad='.implode(',',$a_calidades);
      ksort($parametros_adicionales_calidad);
      $parametros_txt='?'.implode('&', $parametros_adicionales_calidad);

      echo "    <li><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'>".my_mb_ucfirst(mb_strtolower($texto_seleccionable))."</a></li>";
    }
    echo "    </ul>";
 }
}

//if(isset($filtros_categorias_seo['limpiezas']) && isset($_GET['testing'])){
if(isset($filtros_categorias_seo['limpiezas'])){
  $aux_limpiezas=array();
  if (isset($_REQUEST['limpieza']) && trim($_REQUEST['limpieza'])!='')
    $aux_limpiezas=explode(',',$_REQUEST['limpieza']);
  $a_seleccionadas=array();
  $a_seleccionables=array();
  foreach ($filtros_categorias_seo['limpiezas'] as $limpieza_txt => $ezaugarriak) {
    if (stripos($limpieza_txt, 'esponjable') !== false) continue;
    if (array_search($ezaugarriak['id'], $aux_limpiezas)!==false)
        $a_seleccionadas[$ezaugarriak['id']]=$limpieza_txt;
    else
        $a_seleccionables[$ezaugarriak['id']]=$limpieza_txt;
  }
  /*
  print '<pre><xmp>';
  print_r($filtros_categorias_seo['limpiezas']);
  print '</xmp></pre>';
  */
  echo "    <div id='filtro-limpieza' class='pl-4 grupo-filtro'><span>Limpieza</span></div>";
  if(count($a_seleccionadas)){
    asort($a_seleccionadas, SORT_LOCALE_STRING);
    echo "    <ul class='pl-4 mb-2 filtros-seleccionados'>";
    foreach ($a_seleccionadas as $idseleccionada => $texto_seleccionada) {
      $a_limpiezas=$aux_limpiezas;
      unset($a_limpiezas[array_search($idseleccionada, $a_limpiezas)]);
      
      if (count($a_limpiezas))
        $parametros_adicionales_limpieza[4]='limpieza='.implode(',',$a_limpiezas);
      else
        unset($parametros_adicionales_limpieza[4]);

      $parametros_txt='';
      if (count($parametros_adicionales_limpieza)){
        ksort($parametros_adicionales_limpieza);
        $parametros_txt='?'.implode('&', $parametros_adicionales_limpieza);
      }
      echo "    <li class='py-1'><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'> <span>x</span> {$texto_seleccionada}</a></li>";
    }
    echo "    </ul>";
  }

  if(count($a_seleccionables)){
    asort($a_seleccionables, SORT_LOCALE_STRING);
    echo "    <ul class='pl-4' style='list-style:none;'>";
    foreach ($a_seleccionables as $idseleccionable => $texto_seleccionable) {
      $a_limpiezas=$aux_limpiezas;
      $a_limpiezas[]=$idseleccionable;

      $parametros_adicionales_limpieza[4]='limpieza='.implode(',',$a_limpiezas);
      ksort($parametros_adicionales_limpieza);
      $parametros_txt='?'.implode('&', $parametros_adicionales_limpieza);

      echo "    <li><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'>".my_mb_ucfirst(mb_strtolower($texto_seleccionable))."</a></li>";
    }
    echo "    </ul>";
    echo "    <button class='pl-4 my_collapsible my_collapsible_categorias my_collapsible_filtros ver-mas-limpieza' aria-label='Ver más'></button>";
 }
}

/*
if(isset($filtros_categorias_seo['mostrar_estilos_viejos']) && isset($filtros_categorias_seo['estilos_secundarios'])){
  $aux_estilos=array();
  if (isset($_REQUEST['estilo']))
    $aux_estilos=explode(',',$_REQUEST['estilo']);
  $a_seleccionadas=array();
  $a_seleccionables=array();
  foreach ($filtros_categorias_seo['estilos_secundarios'] as $estilo_txt => $ezaugarriak) {
    if (array_search($ezaugarriak['id'], $aux_estilos)!==false)
        $a_seleccionadas[$ezaugarriak['id']]=$estilo_txt.' ('.$ezaugarriak['cont'].')';
    else
        $a_seleccionables[$ezaugarriak['id']]=$estilo_txt.' ('.$ezaugarriak['cont'].')';
  }
  
  echo "    <div class='pl-4 grupo-filtro'>Estilos avanzados</div>";
  if(count($a_seleccionadas)){
    echo "    <ul class='pl-4 mb-2 filtros-seleccionados'>";
    foreach ($a_seleccionadas as $idseleccionada => $texto_seleccionada) {
      $a_estilos=$aux_estilos;
      unset($a_estilos[array_search($idseleccionada, $a_estilos)]);
      
      if (count($a_estilos))
        $parametros_adicionales_estilo[1]='estilo='.implode(',',$a_estilos);
      else
        unset($parametros_adicionales_estilo[1]);

      $parametros_txt='';
      if (count($parametros_adicionales_estilo)){
        ksort($parametros_adicionales_estilo);
        $parametros_txt='?'.implode('&', $parametros_adicionales_estilo);
      }
      echo "    <li class='py-1'><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'> X {$texto_seleccionada}</a></li>";
    }
    echo "    </ul>";
  }

  if(count($a_seleccionables)){
    echo "    <ul class='pl-4' style='list-style:none;'>";
    foreach ($a_seleccionables as $idseleccionable => $texto_seleccionable) {
      $a_estilos=$aux_estilos;
      $a_estilos[]=$idseleccionable;

      $parametros_adicionales_estilo[1]='estilo='.implode(',',$a_estilos);
      ksort($parametros_adicionales_estilo);
      $parametros_txt='?'.implode('&', $parametros_adicionales_estilo);

      echo "    <li><a href='/{$enlace_principal}{$parametros_txt}{$parametro_test}' rel='nofollow'>{$texto_seleccionable}</a></li>";
    }
    echo "    </ul>";
    echo "    <button class='pl-4 my_collapsible my_collapsible_estilos my_collapsible_estilos_2' aria-label='Ver más'></button>";
  }
}
*/
if (!function_exists('urlenc_aux_2')) { function urlenc_aux_2($str){
    $search =  explode(",","ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,e,i,ø,u,Á,É,Í,Ó,Ú,Ñ,!,(,)");
    $replace = explode(",","c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,ñ,,,");

    return str_replace($search,$replace,strtolower(str_replace(',','', str_replace('+','-plus-',str_replace('#','number-',str_replace('&','and',str_replace(' ','-',rawurldecode($str))))))));
} }
/*
if (isset($_GET['testing'])){
  print '<pre><xmp>';
  print_r($menu_categorias_seo);
  print '</xmp></pre>';
}
*/
$menu_categorias_seo_filtro=array();
if (isset($menu_categorias_seo) && is_array($menu_categorias_seo) && count($menu_categorias_seo)>0)
  $menu_categorias_seo_filtro=$menu_categorias_seo;
elseif (isset($filtros_categorias_seo['menu_categorias_seo']) && is_array($filtros_categorias_seo['menu_categorias_seo']) && count($filtros_categorias_seo['menu_categorias_seo'])>0)
  $menu_categorias_seo_filtro=$filtros_categorias_seo['menu_categorias_seo'];

if (count($menu_categorias_seo_filtro)>0){
    foreach ($menu_categorias_seo_filtro as $txt_familia_categoria => $a_categorias_familia) {
      // Saltar calidad si ya se muestra desde filtros_categorias_seo['calidades']
      $txt_check = strpos($txt_familia_categoria, '__')!==false ? explode('__',$txt_familia_categoria,2)[1] : $txt_familia_categoria;
      if (isset($filtros_categorias_seo['calidades']) && stripos($txt_check, 'calidad') !== false) continue;
      if (isset($filtros_categorias_seo['limpiezas']) && stripos($txt_check, 'limpieza') !== false) continue;
      if (isset($filtros_categorias_seo['estilos']) && stripos($txt_check, 'estilo') !== false) continue;

      if (strpos($txt_familia_categoria, '__')!==false){
        $zatiak_orden=explode('__', $txt_familia_categoria, 2);
        $txt_familia_categoria=$zatiak_orden[1];
      }
      $zatiak=explode(' por ', $txt_familia_categoria);
      $class_ver_mas='';
      if (count($zatiak)>1){
        //$txt_familia_categoria=implode(' por <span>', $zatiak).'</span>';
        //$txt_familia_categoria='<span>'.$zatiak[1].'</span> de '.$zatiak[0];
        $txt_familia_categoria='<span>'.$zatiak[1].'</span>';
        $class_ver_mas='ver-mas-'.urlenc_aux_2($zatiak[1]);
      }
      
      $zatiak_2=explode(' según ', $txt_familia_categoria);
      if (count($zatiak_2)>1){
        //$txt_familia_categoria=implode(' según <span>', $zatiak_2).'</span>';
        $txt_familia_categoria='<span>'.$zatiak_2[1].'</span>';
        $class_ver_mas='ver-mas-'.urlenc_aux_2($zatiak_2[1]);
      }
      echo "    <div class='pl-4 grupo-filtro'>$txt_familia_categoria</div>";
      echo "    <ul class='pl-4' style='list-style:none;'>";
      foreach ($a_categorias_familia as $id => $datos_categorias_familia) {
        if (isset($datos_categorias_familia['nombre_filtro']) && trim($datos_categorias_familia['nombre_filtro'])!=''){
          $nombre_negrita=trim($datos_categorias_familia['nombre_filtro']);
        }
        else{
          if (strpos($datos_categorias_familia['nombre'], ' para ')!==false){
            $zatiak_3=explode(' para ', $datos_categorias_familia['nombre']);
            $nombre_negrita=strtolower($zatiak_3[0]).' para <span>'.$zatiak_3[1].'</span>';
            //$nombre_negrita=str_replace(strtolower($familia_producto), strtolower($familia_producto).' <span>', strtolower($datos_categorias_familia['nombre'])).'</span>';
          }
          elseif (strpos($datos_categorias_familia['nombre'], ' de ')!==false){
            $zatiak_3=explode(' de ', $datos_categorias_familia['nombre']);
            $nombre_negrita=strtolower($zatiak_3[0]).' de <span>'.$zatiak_3[1].'</span>';
            //$nombre_negrita=str_replace(strtolower($familia_producto), strtolower($familia_producto).' <span>', strtolower($datos_categorias_familia['nombre'])).'</span>';
          }
          else{
            $ultimo_char=substr($familia_producto, -1);
            $ultimos_chars=substr($familia_producto, -2);
            $nombre_negrita=$datos_categorias_familia['nombre'];
            if ($ultimos_chars=='es'){
              $familia_producto_sin_s=ucfirst(strtolower(substr($familia_producto, 0, -2).' '));
              $nombre_negrita=str_replace($familia_producto_sin_s, $familia_producto_sin_s.' <span>', $nombre_negrita).'</span>';
            }
            elseif ($ultimo_char=='s'){
              $familia_producto_sin_s=ucfirst(strtolower(substr($familia_producto, 0, -1).' '));
              $nombre_negrita=str_replace($familia_producto_sin_s, $familia_producto_sin_s.' <span>', $nombre_negrita).'</span>';
            }
            $familia_producto=ucfirst(strtolower($familia_producto));
            $nombre_negrita=str_replace($familia_producto, $familia_producto.' <span>', $nombre_negrita).'</span>';
          }
        }
        //$nombre_negrita=str_replace(strtolower($familia_producto), strtolower($familia_producto).' <span>', strtolower($datos_categorias_familia['nombre'])).'</span>';
        //echo "    <li><a href='/{$datos_categorias_familia['url']}'>{$datos_categorias_familia['nombre']}</a></li>";
        echo "    <li><a href='/{$datos_categorias_familia['url']}'>".ucfirst($nombre_negrita)."</a></li>";
      }
      echo "    </ul>";
      echo "    <button class='pl-4 my_collapsible my_collapsible_categorias my_collapsible_filtros $class_ver_mas' aria-label='Ver más'></button>";
    }
}

?>
