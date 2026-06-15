<!doctype html>
<!--[if lt IE 7 ]><html lang="es" class="no-js ie6"><![endif]-->
<!--[if IE 7 ]><html lang="es" class="no-js ie7"><![endif]-->
<!--[if IE 8 ]><html lang="es" class="no-js ie8"><![endif]-->
<!--[if IE 9 ]><html lang="es" class="no-js ie9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="es" class="no-js"><!--<![endif]-->
<head>
	<meta charset="utf-8">
	<title>Tipos de producto SEO</title>
	<meta name="description" content=""/>
	<meta name="keywords" content=""/>
	<?php $this->load->view('includes/admin_head'); ?>
</head>
<body>
  <?php $this->load->view('includes/demo_header'); ?>
  <div class="container">
    <div style="height: 40px"></div>
    <div style="font-size:40px;font-weight: 300;color: #B05380;text-align:center;border-bottom: 1px solid #B05380;">LISTADO INFO SEO TIPOS DE PRODUCTOS</div>
    <div style="height: 20px"></div>
    <div class="list">
      <?php
      $a_descripciones=array();
      $a_meta_title=array();
      $a_meta_desc=array();
      $a_descripciones_ekam=array();
      $a_meta_title_ekam=array();
      $a_meta_desc_ekam=array();
      foreach ($a_tipo_productos as $key){
        switch ($key->tipo_producto_id) {
            case 0: $categ = "Papel Pintado";
                break;
            case 1: $categ = "Fotomurales";
                break;
            case 2: $categ = "Revestimientos";
                break;
            case 3: $categ = "Telas";
                break;
            case 4: $categ = "Alfombras";
                break;
            case 5: $categ = "Herramientas";
                break;
            default: break;
        }
        $web_seo=0;
        $estado_texto_ok=false;
        if (trim($key->descripcion_tipo_producto)==''){
          $estado_texto='<span style="color:red;">Sin descripción</span>';
        }
        elseif(str_word_count($key->descripcion_tipo_producto)<900){
          $estado_texto='<span style="color:red;">Descripción con '.str_word_count($key->descripcion_tipo_producto).' palabras</span>';
          $a_descripciones[]=$key->descripcion_tipo_producto;
        }
        elseif(in_array($key->descripcion_tipo_producto, $a_descripciones)){
          $estado_texto='<span style="color:red;">Descripción duplicada</span>';
        }
        else{
          $estado_texto='<span style="color:green;">Descripción OK</span>';
          $a_descripciones[]=$key->descripcion_tipo_producto;
          $estado_texto_ok=true;
        }

        $estado_title='';
        $estado_title_ok=false;
        if(in_array($key->meta_title_tipo_producto, $a_meta_title)){
          $estado_title.="<span style='color:red;'>Metatitle duplicado</span><br />";
        }
        if (trim($key->meta_title_tipo_producto)==''){
          $estado_title.='<span style="color:red;">Sin metatitle</span>';
        }
        elseif(strlen($key->meta_title_tipo_producto)>60){
          $estado_title.='<span style="color:red;">Metatitle > 60 ('.strlen($key->meta_title_tipo_producto).')</span>';
          $a_meta_title[]=$key->meta_title_tipo_producto;
        }
        else{
          $estado_title='<span style="color:green;">Metatitle OK</span>';
          $a_meta_title[]=$key->meta_title_tipo_producto;
          $estado_title_ok=true;
        }

        $estado_desc='';
        $estado_desc_ok=false;
        if(in_array($key->meta_description_tipo_producto, $a_meta_desc)){
          $estado_desc.="<span style='color:red;'>Metadesc duplicado</span><br />";
        }
        if (trim($key->meta_description_tipo_producto)==''){
          $estado_desc.='<span style="color:red;">Sin Metadesc</span>';
        }
        elseif(strlen($key->meta_description_tipo_producto)>150){
          $estado_desc.='<span style="color:red;">Metadesc > 150 ('.strlen($key->meta_description_tipo_producto).')</span>';
          $a_meta_desc[]=$key->meta_description_tipo_producto;
        }
        else{
          $estado_desc='<span style="color:green;">Metadesc OK</span>';
          $a_meta_desc[]=$key->meta_description_tipo_producto;
          $estado_desc_ok=true;
        }

        $a_tipos[$key->tipo_producto_id][$web_seo]['name']=$categ;
        $a_tipos[$key->tipo_producto_id][$web_seo]['descripcion_tipo_producto']=$key->descripcion_tipo_producto;
        $a_tipos[$key->tipo_producto_id][$web_seo]['estado_texto']=$estado_texto;
        $a_tipos[$key->tipo_producto_id][$web_seo]['estado_texto_ok']=$estado_texto_ok;
        $a_tipos[$key->tipo_producto_id][$web_seo]['meta_title']=$key->meta_title_tipo_producto;
        $a_tipos[$key->tipo_producto_id][$web_seo]['estado_title']=$estado_title;
        $a_tipos[$key->tipo_producto_id][$web_seo]['estado_title_ok']=$estado_title_ok;
        $a_tipos[$key->tipo_producto_id][$web_seo]['meta_description']=$key->meta_description_tipo_producto;
        $a_tipos[$key->tipo_producto_id][$web_seo]['estado_desc']=$estado_desc;
        $a_tipos[$key->tipo_producto_id][$web_seo]['estado_desc_ok']=$estado_desc_ok;

        if (isset($a_tipo_productos_ekam[$key->tipo_producto_id])){
          $key_ekam=$a_tipo_productos_ekam[$key->tipo_producto_id];
          $web_seo=1;
          $estado_texto_ok_ekam=false;
          if (trim($key_ekam->descripcion_tipo_producto)==''){
            $estado_texto_ekam='<span style="color:red;">EKAM - Sin descripción</span>';
          }
          elseif(in_array($key_ekam->descripcion_tipo_producto, $a_descripciones)){
            $estado_texto_ekam='<span style="color:red;">EKAM - Descripción duplicada</span>';
          }
          elseif(str_word_count($key_ekam->descripcion_tipo_producto)<900){
            $estado_texto_ekam='<span style="color:red;">EKAM - Descripción con '.str_word_count($key_ekam->descripcion_tipo_producto).' palabras</span>';
            $a_descripciones_ekam[]=$key_ekam->descripcion_tipo_producto;
          }
          else{
            $estado_texto_ekam='<span style="color:green;">EKAM - Descripción OK</span>';
            $a_descripciones_ekam[]=$key_ekam->descripcion_tipo_producto;
            $estado_texto_ok_ekam=true;
          }
        
          $estado_title_ekam='';
          $estado_title_ok_ekam=false;
          if (trim($key_ekam->meta_title_tipo_producto)==''){
            $estado_title_ekam.='<span style="color:red;">EKAM - Sin metatitle</span>';
          }
          elseif(in_array($key_ekam->meta_title_tipo_producto, $a_meta_title)){
            $estado_title_ekam.="<span style='color:red;'>EKAM - Metatitle duplicado</span><br />";
          }
          elseif(strlen($key_ekam->meta_title_tipo_producto)>60){
            $estado_title_ekam.='<span style="color:red;">EKAM - Metatitle > 60 ('.strlen($key_ekam->meta_title_tipo_producto).')</span>';
            $a_meta_title_ekam[]=$key_ekam->meta_title_tipo_producto;
          }
          else{
            $estado_title_ekam='<span style="color:green;">EKAM - Metatitle OK</span>';
            $a_meta_title_ekam[]=$key_ekam->meta_title_tipo_producto;
            $estado_title_ok_ekam=true;
          }

          $estado_desc_ekam='';
          $estado_desc_ok_ekam=false;
          if (trim($key_ekam->meta_description_tipo_producto)==''){
            $estado_desc_ekam.='<span style="color:red;">EKAM - Sin Metadesc</span>';
          }
          elseif(in_array($key_ekam->meta_description_tipo_producto, $a_meta_desc)){
            $estado_desc_ekam.="<span style='color:red;'>EKAM - Metadesc duplicado</span><br />";
          }
          elseif(strlen($key_ekam->meta_description_tipo_producto)>150){
            $estado_desc_ekam.='<span style="color:red;">EKAM - Metadesc > 150 ('.strlen($key_ekam->meta_description_tipo_producto).')</span>';
            $a_meta_desc_ekam[]=$key_ekam->meta_description_tipo_producto;
          }
          else{
            $estado_desc_ekam='<span style="color:green;">EKAM - Metadesc OK</span>';
            $a_meta_desc_ekam[]=$key_ekam->meta_description_tipo_producto;
            $estado_desc_ok_ekam=true;
          }

          $a_tipos[$key_ekam->tipo_producto_id][$web_seo]['name']=$categ.' EKAM';
          $a_tipos[$key_ekam->tipo_producto_id][$web_seo]['descripcion_tipo_producto']=$key_ekam->descripcion_tipo_producto;
          $a_tipos[$key_ekam->tipo_producto_id][$web_seo]['estado_texto']=$estado_texto_ekam;
          $a_tipos[$key_ekam->tipo_producto_id][$web_seo]['estado_texto_ok']=$estado_texto_ok_ekam;
          $a_tipos[$key_ekam->tipo_producto_id][$web_seo]['meta_title']=$key_ekam->meta_title_tipo_producto;
          $a_tipos[$key_ekam->tipo_producto_id][$web_seo]['estado_title']=$estado_title_ekam;
          $a_tipos[$key_ekam->tipo_producto_id][$web_seo]['estado_title_ok']=$estado_title_ok_ekam;
          $a_tipos[$key_ekam->tipo_producto_id][$web_seo]['meta_description']=$key_ekam->meta_description_tipo_producto;
          $a_tipos[$key_ekam->tipo_producto_id][$web_seo]['estado_desc']=$estado_desc_ekam;
          $a_tipos[$key_ekam->tipo_producto_id][$web_seo]['estado_desc_ok']=$estado_desc_ok_ekam;


        }

      }
      ksort($a_tipos);
      /*
      print '<pre><xmp>';
      print_r($a_tipos);
      print '</xmp></pre>';
      */
      foreach ($a_tipos as $id=>$a_datos){
        foreach ($a_datos as $web_seo=>$datos){
          ?>
          <div style="border-bottom:dotted 1px #aaa" class="sec row" id='registro_<?php echo $id; ?>'>
            <div class="col two">
              <strong>
                <?php 
                if($web_seo ==0) echo $datos['name']; 
                else echo "&nbsp;"
                ?>
              </strong>
            </div>
            <div class="col three ">
              <?php 
              if ($datos['estado_texto_ok'])
                echo $datos['estado_texto'];
              else
                echo '<span style="color:red;">'.$datos['estado_texto'].'</span>';
              /*
              if(trim($datos['descripcion_tipo_producto'])!='')
                echo " <a href='#' class='ver-texto' data-texto-id='texto_$id'>Ver</a>\n";
              
              echo "<div style='display:none;' id='texto_$id' class='ctex'>{$datos['descripcion_tipo_producto']}</div> \n";
              */
              ?>
            </div>
            <div class="col three ">
              <?php 
              echo $datos['estado_title'];
              echo "<div id='meta_title_$id' class='cmtitle'>{$datos['meta_title']}</div> \n";
              /*
              if ($datos['estado_title_ok']){
                echo "<div id='meta_title_$id' class='cmtitle'>{$datos['meta_title']}</div> \n";
              }
              else{
                if(trim($datos['meta_title'])!='')
                  echo " <a href='#' class='ver-meta-title' data-meta-title-id='meta_title_$id'>Ver</a>\n";
                echo "<div style='display:none;' id='meta_title_$id' class='cmtitle'>{$datos['meta_title']}</div> \n";
              }
              */
              ?>
            </div>
            <div class="col three ">
              <?php 
              echo $datos['estado_desc'];
              echo "<div id='meta_desc_$id' class='cmdesc'>{$datos['meta_description']}</div> \n";
              /*
              if ($datos['estado_desc_ok']){
                echo "<div id='meta_desc_$id' class='cmdesc'>{$datos['meta_description']}</div> \n";
              }
              else{
                if(trim($datos['meta_description'])!='')
                  echo " <a href='#' class='ver-meta-desc' data-meta-desc-id='meta_desc_$id'>Ver</a>\n";
                echo "<div style='display:none;' id='meta_desc_$id' class='cmdesc'>{$datos['meta_description']}</div> \n";
              }
              */
              ?>
            </div>
            <div class="col one">
              <?php /*<span class="edit btn" id="<?php echo $id; ?>" style='width: 100%;'>Editar</span>*/ ?>
              <span class="edit btn" id="<?php echo $id; ?>" style='width: 100%;'>
                <a style="color: #fff;text-decoration: none;" href='/admin_library/editar_tipo_producto_seo/<?php echo $id; ?>'>Editar</a>
              </span>
            </div>
          </div>
          <?php
        }
      }
      /*
      print '<pre><xmp>';
      print_r($a_datos);
      print '</xmp></pre>';
      exit;
      */
      ?>
    </div>
  </div>
  <?php 
  $this->load->view('includes/scripts'); 
  ?> 
</body>
</html>
