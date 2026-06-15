<?php
$ant=0;
$sig=0;
for($i=0;$i<count($otro);$i++){
  if($otro[$i]['item_id']==$key['item_id'] || $otro[$i]['item_id']==$key['variante_de']){
    if($i==0) 
      $ant=$otro[(count($otro)-1)]['item_id'];
    else 
      $ant=$otro[($i-1)]['item_id'];
    if($i==(count($otro)-1))
      $sig=$otro[0]['item_id'];
    else 
      $sig=$otro[($i+1)]['item_id'];
  }
}
?>

<div id='inicio' class="wrapper">
  <div class="container">
    <div class='row heading-producto'>
      <h1 class="titulo-1 mb-0 pt-4 pb-2 text-left col-xl-9 col-lg-9 col-md-9 col-sm-12 col-xs-12 col-sp-12"><?php echo $texto_h1_seccion; ?></h1>
      <?php
      $nombre_completo=$texto_h1_seccion;
      if($key['item_tipo']!=5){
      ?>
        <div class="mb-0 pt-4 pb-2 text-right col-xl-3 col-lg-3 col-md-3 col-sm-12 col-xs-12 col-sp-12">
          <a class='valign-sub' href='<?php echo $url_coleccion; ?>' aria-label='Ver colección completa'>Ver colección completa</a>
        </div>
      <?php
      }
      ?>
    </div>
    <?php
    $texto_descripcion=$key['col_text'];
    if (trim($key['item_text'])!='')
      $texto_descripcion=$key['item_text'];

    /*
    */
    if (trim($texto_descripcion)!='' && $key['item_tipo']!=5){
    //echo "<p>$texto_descripcion</p>";
      ?>
      <div class="unit-100" style='clear: both;'>
        <div class="contenido-colapsable contenido-colapsable-articulo texto-seo"><?php echo $texto_descripcion;?></div>
        <button class="my_collapsible" aria-label="Ver más"></button>
      </div>
      <?php
    }
    /*
    if (trim($key['imgambtitle'])=='')
      $key['imgambtitle']=$key['meta_title'].' - 2';
    if (trim($key['imgambalt'])=='')
      $key['imgambalt']=$key['meta_title'].' - 2';

    ?>
    <div class="unit-50">
        <div class="cajacaja">
          <p> <a href="<?=$includes_dir.str_replace("../", "", $key['imgamb'])?>med.jpg" rel="shadowbox">  <img class="mainimg2" title="<?=$key['imgambtitle']?>" alt="<?=$key['imgambalt']?>" src="<?=$includes_dir.str_replace("../", "", $key['imgamb'])?>med.jpg"></a></p>
        </div>
    </div>
    */
    ?>




    <?php
    $t= $includes_dir.str_replace("../", "", $key['img']);
    
    $img_producto=new stdClass();
    $img_producto->titulo=$texto_h1_seccion;
    $img_producto->src=$t.'med.jpg';
    $img_producto->height=600;

    $a_imagenes=array();
    $a_imagenes[]=$img_producto;
    if (trim($key['imgamb'])!=''){
      $t= $includes_dir.str_replace("../", "", $key['imgamb']);
      $img_producto_amb=new stdClass();
      $img_producto_amb->titulo=$texto_h1_seccion;
      $img_producto_amb->src=$t.'med.jpg';
      $img_producto_amb->height=600;
      $a_imagenes[]=$img_producto_amb;
    }

    $class_nopadding='';
    if (count($a_imagenes)<2)
      $class_nopadding=' p-0 ';
    ?>
    <div class='row cuerpo-producto mt-4'>
      <input type="hidden" id="tipo_unidad" name="tipo_unidad" value="<?php echo $key['item_unidad'];?>"/>
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-sp-12">
        <?php
        if (count($a_imagenes)>1){
        ?>
          <div class="imagenes-producto <?php echo $class_nopadding; ?>">
            <div class="">
              <?php
              $this->data['images']=$a_imagenes;
              $this->load->view('frontend/slider_nuevo_miniaturas', $this->data);
              //$this->load->view('frontend/slider_nuevo_src', $this->data);
              ?>
            </div>
          </div>
        <?php
        }
        else{
          echo '  <div class="">';
          //echo '  <p class="">imagen herramienta</p>';
          foreach($a_imagenes as $item_imagen){
              $txt_alt=$item_imagen->titulo;
              
              echo '<picture>';
              //echo '<source srcset="'.$key->src.'/'.$key->id.'.webp" type="image/webp">';
              echo '<source srcset="'.$item_imagen->src.'" type="image/jpeg">';
              echo '<img src="'.$item_imagen->src.'" style="width:100%" alt="'.$txt_alt.'" height="300" class="align-top" />';
              echo '</picture>';
          }
          echo '  </div>';
        }
        ?>
      </div>   
      <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-sp-12">
        <div class="caracteristicas-producto mt-4">
          <?php 
          //echo '<p>'.$key['item_ref'].'</p>';
          ?>
          <div class='row'>
            <?php 
            if ($key['item_tipo']==5){
              echo '<div class="col-12">';
              echo $key['item_text'];
              echo '</div>';
            }
            
            if ($key['item_tipo']==0 || $key['item_tipo']==1 || $key['item_tipo']==2){
              // Para papeles, murales y revestimientos
              echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-sp-12 product-detail-feature">';
              echo '  <div>';
              echo '    <img src="/includes/images/iconos_producto/i-lavable.png" title="Material" alt="Material" with="50" /> ';
              echo '  </div>';
              echo '  <div class="titulo-upper-oscuro-1">';
              echo '    <span class="titulo-upper-claro-1">MATERIAL</span><br />';
              switch ($key['item_lavable']){
                case 0: echo "No Lavable"; break;
                case 1: echo "Lavable"; break;
                case 2: echo "Esponjable"; break;
                case 3: echo "SuperLavable"; break;
              }
              echo '  </div>';
              echo '</div>';

              echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-sp-12 product-detail-feature">';
              echo '  <div>';
              echo '    <img src="/includes/images/iconos_producto/i-tiempo.png" title="Resistencia a la luz" alt="Resistencia a la luz" with="50" /> ';
              echo '  </div>';
              echo '  <div class="titulo-upper-oscuro-1">';
              echo '    <span class="titulo-upper-claro-1">RESISTENCIA A LA LUZ</span><br />';
              if ($key['item_sol']==1)
                echo 'Buena';
              else
                echo 'Suficiente';
              echo '  </div>';
              echo '</div>';
            }

            if (($key['item_tipo']==0 || $key['item_tipo']==1) && ($key['item_vinilo']==1 || $key['item_cola']=='pared')){ 
              echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-sp-12 product-detail-feature">';
              echo '  <div>';
              echo '    <img src="/includes/images/iconos_producto/i-calidad.png" title="Calidad" alt="Calidad" with="50" /> ';
              echo '  </div>';
              echo '  <div class="titulo-upper-oscuro-1">';
              echo '    <span class="titulo-upper-claro-1">CALIDAD</span><br />';
              if ($key['item_vinilo']==1)
                echo $tipo_producto.' vinílico';
              elseif($key['item_cola']=='pared')  
                echo 'Tejido no tejido';
              echo '  </div>';
              echo '</div>';
            }

            if ($key['item_tipo']==3 && ($key['item_largo']>0 || $key['item_ancho']>0)){ // TELAS
              echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-sp-12 product-detail-feature">';
              echo '  <div>';
              echo '    <img src="/includes/images/iconos_producto/i-medidas.png" title="Medidas" alt="Medidas" with="50" /> ';
              echo '  </div>';
              echo '  <div class="titulo-upper-oscuro-1">';
              echo '    <span class="titulo-upper-claro-1">MEDIDAS</span><br />';
              if($key['item_largo']>0)
                echo 'Largo de la pieza '.number_format((float)$key['item_largo'], 2, ',', '')." cm<br />";
              if($key['item_ancho']>0)
                echo 'Ancho de la pieza '.number_format((float)$key['item_ancho'], 2, ',', '')." cm<br />";
              if($key['item_case']>0)
                echo 'Repetición largo '.number_format((float)$key['item_case'], 2, ',', '')." cm<br />";
              if($key['item_case2']>0)
                echo 'Repetición ancho '.number_format((float)$key['item_case2'], 2, ',', '')." cm<br />";
              echo '  </div>';
              echo '</div>';
            }
            else if ($key['item_tipo']==4){ // SI ALFOMBRA
              echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-sp-12 product-detail-feature">';
              echo '  <div>';
              echo '    <img src="/includes/images/iconos_producto/i-medidas.png" title="Medidas" alt="Medidas" with="50" /> ';
              echo '  </div>';
              echo '  <div class="titulo-upper-oscuro-1">';
              if ($key['item_unidad']=="Unidad"){
                echo '    <span class="titulo-upper-claro-1">MEDIDAS</span><br />';
                echo number_format((float)$key['item_ancho'], 2, ',', '')."M X ".number_format((float)$key['item_largo'], 2, ',', '')."M";
                //echo 'Ancho  '.number_format((float)$key['item_ancho'], 2, ',', '')." m<br />";
                //echo 'Largo  '.number_format((float)$key['item_largo'], 2, ',', '')." m<br />";
              }
              else{
                echo '    <span class="titulo-upper-claro-1">DIMENSIONES</span><br />Alfombra a medida';
              }
              echo '  </div>';
              echo '</div>';
            }
            else if ($key['item_tipo']!=5){ // SI NO ES HERRAMIENTA => papel, mural y revestimiento
              echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-sp-12 product-detail-feature">';
              echo '  <div>';
              echo '    <img src="/includes/images/iconos_producto/i-medidas.png" title="Medidas" alt="Medidas" with="50" /> ';
              echo '  </div>';
              echo '  <div class="titulo-upper-oscuro-1">';
              echo '    <span class="titulo-upper-claro-1">MEDIDAS</span><br />';
              if ($key['item_unidad']=="Rollo"){
                echo number_format((float)$key['item_ancho'], 2, ',', '')."CM X ".number_format((float)$key['item_largo'], 2, ',', '')."M <br />";
                //echo 'Ancho  '.number_format((float)$key['item_ancho'], 2, ',', '')." cm<br />";
                //echo 'Largo  '.number_format((float)$key['item_largo'], 2, ',', '')." m<br />";
                if($key['item_case']==0)
                  echo "El dibujo no tiene case <br />";
                else
                  echo 'Case del dibujo: '.number_format((float)$key['item_case'], 2, ',', '')." cm <br />";

              }
              elseif($key['item_case']!=0){
                  echo 'Case del dibujo: '.number_format((float)$key['item_case'], 2, ',', '')." cm <br />";
              }

              // Si Unidades UNIDADES
              if ($key['item_unidad']=="Unidad"){
                echo number_format((float)$key['item_ancho'], 2, ',', '')."M X ".number_format((float)$key['item_largo'], 2, ',', '')."M <br />";
                //echo 'Ancho  '.number_format((float)$key['item_ancho'], 2, ',', '')." m<br />";
                //echo 'Largo  '.number_format((float)$key['item_largo'], 2, ',', '')." m<br />";
              }
              // Si Unidades Metros cuadrados
              if ($key['item_unidad']=="m2"){
                  echo "Se vende por metros cuadrados <br />";
              }

              // Si Unidades Metros cuadrados
              if ($key['item_unidad']=="m lineal"){
                //echo 'Ancho de la pieza: '.number_format((float)$key['item_case'], 2, ',', '')." cm <br />";
                echo 'Ancho de la pieza: '.number_format((float)$key['item_ancho'], 2, ',', '')." cm <br />";
                echo 'Se vende por metros lineales <br />';
              }
              echo '  </div>';
              echo '</div>';
            }
            if (trim($key['composicion'])!=''){
              echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 col-sp-12 product-detail-feature">';
              echo '  <div>';
              echo '    <img src="/includes/images/iconos_producto/i-composicion.png" title="Composición" alt="Composición" with="50" /> ';
              echo '  </div>';
              echo '  <div class="titulo-upper-oscuro-1">';
              echo '    <span class="titulo-upper-claro-1">COMPOSICIÓN</span><br />'.$key['composicion'];
              echo '  </div>';
              echo '</div>';
            }
            ?>
          </div>
        </div>
        <?php
        /* 
        print '<pre><xmp>';
        print_r($relacionados);
        print '</xmp></pre>';
        */
        ?>
        <div class='copiado-del-original'>
          <?php
          $mostrar_modal_simulacion=false;
          $mostrar_calculadora_generica=true;
          $seleccionar_forma='';
          if ($key['item_cat_fk']==276){
            $a_kp_cenefas[1933]=1933; //id coleccion
            $a_kp_cenefas[1934]=1934; //id coleccion
            $a_kp_cenefas[1935]=1935; //id coleccion
            $a_kp_cenefas[1936]=1936; //id coleccion
            $a_kp_cenefas[1937]=1937; //id coleccion
            /*
            print '<pre><xmp>';
            print_r($key);
            print '</xmp></pre>';
            */
            if (isset($a_kp_cenefas[$key['item_coleccion_id']])){
              $mostrar_modal_simulacion=true;

              $this->data['a_grecas_varias_colecciones'] = $this->flexi_cart_model->get_items_grecas($a_kp_cenefas, false, $key['item_tipo']);

              $mostrar_posibilidad_grecas=true;
              $mostrar_grecas_exteriores=true;
              $mostrar_grecas_interiores=false;
              $greca_misma_coleccion_be=1;
              ?>
              <div class="pb-4">
                <?php
                // Grecas posibles dentro de la misma colección, sin calculadora
                if ($mostrar_posibilidad_grecas){
                  $this->data['mostrar_grecas_interiores']=$mostrar_grecas_interiores;
                  $this->data['mostrar_grecas_exteriores']=$mostrar_grecas_exteriores;
                  $this->data['mostrar_calculadora_keplan']=true;
                  $this->load->view('frontend/grecas_misma_coleccion', $this->data); 
                }
                ?>
              </div>
            <?
            }
            else{
              if (trim($key['extra'])!=''){
                $key['extra']=str_replace('Remates', 'Acabados',$key['extra']);
                $extra_info=str_replace('Acabados recomendados', '<strong>Acabados recomendados</strong>',$key['extra']);
                echo '<div class="row"><div class="col-12"><div class="texto-aviso p-3"><small>'.nl2br($extra_info).'</small></div></div></div>';
              }
              $this->load->view('frontend/acabados_alfombras_kp_formas', $this->data); 
              $seleccionar_forma='seleccionar_forma';
              //$this->load->view('frontend/acabados_alfombras_kp', $this->data); 
            }
          }
          elseif(isset($relacionados) && count($relacionados)>1){
            $mostrar_posibilidad_grecas=false;
            $mostrar_grecas_exteriores=false;
            $mostrar_grecas_interiores=false;
            ?>
            <div class="pb-4">
              <div class="row">
                <div class="h5 mb-0 col-12">Opciones disponibles:</div>
                <div class="col-12 mb-4">
                  <?php 
                  foreach ($relacionados as $item) {
                    if (trim($item['texto_relacion'])=='CON GRECA')
                      $item['texto_relacion']='GRECA EXTERIOR';
                    if (trim($item['texto_relacion'])=='CON GRECA INTERIOR')
                      $item['texto_relacion']='GRECA INTERIOR';

                    $txt_seleccionado='';
                    if ($item['item_id']==$key['item_id']){
                      $txt_seleccionado='seleccionado';
                      if (trim($item['texto_relacion'])=='GRECA EXTERIOR'){
                        //echo "<br />greca exterior";
                        $mostrar_posibilidad_grecas=true;
                        $mostrar_grecas_exteriores=true;
                      }
                      if (trim($item['texto_relacion'])=='GRECA INTERIOR'){
                        $mostrar_posibilidad_grecas=true;
                        $mostrar_grecas_interiores=true;
                      }
                    }
                    //echo '<div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 col-xs-6 col-sp-6 text-center"><a href="'.base_url().'tienda/articulo/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/id/'.$item['item_id'].'" class="boton-opciones '.$txt_seleccionado.'">'.$item['texto_relacion'].'</a></div>';
                    echo '<a href="'.base_url().'tienda/articulo/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/id/'.$item['item_id'].'" class="boton-opciones '.$txt_seleccionado.'">'.$item['texto_relacion'].'</a>';
                  }
                  ?>
                </div>
              </div>
              <?php
              // Grecas posibles dentro de la misma colección, sin calculadora
              if ($key['greca_misma_coleccion_be']==1 && $mostrar_posibilidad_grecas){
                $this->data['mostrar_grecas_interiores']=$mostrar_grecas_interiores;
                $this->data['mostrar_grecas_exteriores']=$mostrar_grecas_exteriores;
                $this->load->view('frontend/grecas_misma_coleccion', $this->data); 
              }
              ?>
            </div>
          <?
          }
          elseif ($key['item_cat_fk']==268){
            if (trim($key['extra'])!=''){
              $key['extra']=str_replace('Remates', 'Acabados',$key['extra']);
              $extra_info=str_replace('Acabados recomendados', '<strong>Acabados recomendados</strong>',$key['extra']);
              echo '<div class="row"><div class="col-12"><div class="texto-aviso p-3"><small>'.nl2br($extra_info).'</small></div></div></div>';
            }
            $this->load->view('frontend/acabados_alfombras_santos_monteiro_aux', $this->data); 
            $mostrar_calculadora_generica=false;
            $seleccionar_forma='seleccionar_forma';
            //exit;
          }
          else{
            if(isset($variantes) && count($variantes)>1){
            ?>
              <div class="row pb-4">
                <div class="h5 mb-2 col-12">Otras medidas:</div>
                <div class="col-12 form-grou">
                  <select class="form-control" onchange="self.location='<?=base_url()."tienda/articulo/".$this->uri->segment(3)."/".$this->uri->segment(4)."/id/"?>'+this.options[this.selectedIndex].value;">
                  <?php
                  foreach($variantes as $item){
                    $opt_selected='';
                    if($item['item_id']==$key['item_id'])
                      $opt_selected=' selected="selected" ';
                    //$txt_option=$item['item_ref'].": dimensiones (alto x ancho): ".$item['item_largo']."x".$item['item_ancho'];
                    $txt_option=$item['item_ref'].": dimensiones (ancho x alto): ".number_format($item['item_ancho'], 2, ',', '.')."x".number_format($item['item_largo'], 2, ',', '.');
                    if ($key['item_tipo']==4)
                      $txt_option=$item['item_ref'].": dimensiones (ancho x largo): ".number_format($item['item_ancho'], 2, ',', '.')."x".number_format($item['item_largo'], 2, ',', '.');
                    ?>
                    <option <?php echo $opt_selected; ?> value="<?=$item['item_id']?>"><?php echo $txt_option;?></option>
                    <?
                  }
                  ?>
                  </select>
                </div>
              </div>
              <?
            }
          }

          if($key['item_unidad']=="m2"){ 
            $mostrarunidad="m<sup>2</sup>";
            $mostrarunidades="m<sup>2</sup>";
          }
          else if($key['item_unidad']=="m lineal"){ 
            $mostrarunidad="Metro Lineal";
            $mostrarunidades="Metro(s) Lineal(es)";
            $txt_ncesarios="Metros Lineales";
          }
          else if($key['item_unidad']=="Rollo"){ 
            $mostrarunidad="Rollo";
            $mostrarunidades="Rollo(s)";
            $txt_ncesarios="Rollos";
          }
          else{ 
            $mostrarunidad=$key['item_unidad'];
            $mostrarunidades=$key['item_unidad'];
          }

          //CALCULADORA DE ROLLOS
          if(($key['item_tipo']==0 || $key['item_tipo']==2) && $key['item_unidad']!="Unidad" ){ // Papel y revestimientos por rollos
            if($key['item_tipo']==0) 
              $titulo_calculadora='Calculadora de rollos de papel pintado'; 
            else 
              $titulo_calculadora='Calculadora de rollos de revestimientos';
            ?>
            <div class="product-detail-calculadora-rollo">
              <div class="product-title row">
                <span class="title col-11">
                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><rect x="0" y="0" width="16" height="16" fill="none" stroke="none"></rect><g fill="#2d2525"><path d="M12 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H4a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h8zM4 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H4z"></path><path d="M4 2.5a.5.5 0 0 1 .5-.5h7a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-.5.5h-7a.5.5 0 0 1-.5-.5v-2zm0 4a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm3-6a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 .5.5v4a.5.5 0 0 1-.5.5h-1a.5.5 0 0 1-.5-.5v-4z"></path></g></svg>
                  <?php echo $titulo_calculadora;?>
                </span>
                <button class="calc_collapsible col-1 py-0" data-toggle="collapse" data-target="#calc-colapsable" aria-expanded="false" aria-controls="calc-colapsable" aria-label="Ver calculadora"></button>
              </div>

              <div id='hr_calculadora' class="row hr_calculadora d-none">
                <hr class="col-12 p-0 mt-2 mb-4" style='border-top: 1px solid #212529;'/>
              </div>
              <div id='calc-colapsable' class="collapse">
                <div class="form-group row">
                  <input type="hidden" id="p_ancho" name="p_ancho" value="<?=$key['item_ancho']?>"/>
                  <input type="hidden" id="p_alto" name="p_alto" value="<?=$key['item_largo']?>"/>
                  <input type="hidden" id="case" name="case" value="<?=$key['item_case']?>"/>
                  <input type="hidden" id="ud" name="ud" value="<?=$key['item_unidad']?>"/>
                  <div class="col-6">
                    <div class="pr-15">
                      <label for="i-ancho-pared">Ancho pared (metros)</label>
                      <div class="">
                        <div class="">
                          <input type="number" min="0" step="0.1" id="i-ancho-pared" name="i-ancho-pared" class="w-75" oninput="calcular_nuevo();" /> m
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="">
                      <label for="i-alto-pared">Alto pared (metros)</label>
                      <div class="">
                        <div class="">
                          <input type="number" min="0" step="0.1" id="i-alto-pared" name="i-alto-pared" class="w-75" oninput="calcular_nuevo();" /> m
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="pdcr-result col-6 mt-4">
                    <span class="tipo"><?php echo $txt_ncesarios; ?> necesarios</span> 
                    <input type="number" id="i-resultado" name="i-resultado" disabled="" class="w-25" />
                    <small id="i-resultado" class="form-text text-muted">* Los resultados son aproximados</small>
                  </div>
                </div>
              </div>

            </div>
          <?
          } // FIN CALCULADORA

          if ($key['item_cat_fk']!=276 && $mostrar_calculadora_generica){ // PARA KP USAREMOS SU PROPIA CALCULADORA
            if($key['item_unidad']=='m2'){ // Calculo de metros cuadrados
              $txt_p_alto='Alto en metros';
              if($key['item_tipo']==4)
                $txt_p_alto='Largo en metros';

              $txt_caja='Dimensiones:';
              if($key['item_tipo']==4)
                $txt_caja='Introduce las medidas de tu alfombra:';
              ?>
              <div class="product-detail-calculadora-rollo">
                <div class="product-title row">
                  <span class="title col-12"><?php echo $txt_caja; ?></span>
                </div>

                <div id='hr_calculadora_alfombra' class="row hr_calculadora">
                  <hr class="col-12 p-0 mt-2 mb-4" style='border-top: 1px solid #212529;'/>
                </div>

                <div class="form-group row">
                  <p class="col-12">Introduce las dimensiones necesarias en metros, ej: 3.8 x 2.5</p>
                  <?php
                  /*
                  <div class="col-12">
                    <input type="text" class="metrs calcuinput" placeholder="Ancho en metros" value="" id="p_ancho" name="p_ancho" >
                    <input type="text" class="metrs calcuinput" placeholder="<?php echo $txt_p_alto; ?>" value="" id="p_alto" name="p_alto" ><button id="calculaboton">Calcular</button>
                  </div>
                  */
                  ?>
                  <div class="col-6">
                    <div class="pr-15">
                      <label for="p_ancho">Ancho en metros</label>
                      <div class="">
                        <div class="">
                          <input type="number" min="0" step="0.1" id="p_ancho" name="p_ancho" class="w-75 metrs calcuinput" oninput="CalculaMetros();" /> m
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="">
                      <label for="p_alto"><?php echo $txt_p_alto; ?></label>
                      <div class="">
                        <div class="">
                          <input type="number" min="0" step="0.1" id="p_alto" name="p_alto" class="w-75" oninput="CalculaMetros();" /> m
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <?php 
                $this->load->view('frontend/info_opc_seleccionadas'); 
                ?>
              </div>

              <?
            }
            if($key['item_unidad']=='m2' || $key['item_unidad']=='m lineal'){
              ?>
              <div>*Las medidas introducidas se ajustarán automáticamente a las exigencias del fabricante. Consultanos otras opciones</div>
              <?
            }
            if(isset($key['stock_quantity']) && $key['stock_quantity']<5){
              ?>
              <div style="color: #3c3; font-size:25px; margin-bottom: 5px" ><span>Últimas unidades</span></div>
              <?
            }
            else if(isset($key['stock_quantity']) && $key['stock_quantity']<100){
              ?>
              <div style="color: #3c3; font-size:25px; margin-bottom: 5px" ><span>Unidades limitadas</span></div>
              <?
            }
          }
          ?>

          <?php 
          $precio=$key['item_price'];
          $preciobase=$precio;
          $preal=$key['item_price'];
          
          // El precio aux es para calcular con el ancho del rollo completo en el caso de las alfombras de Santos Monteiro
          $precio_aux=$key['item_price_aux'];
          $preciobase_aux=$precio_aux;
          $preal_aux=$key['item_price_aux'];
          
          if($key['item_economico']){
            //$precio='<span style="font-size:18px;color:#AE0058"><strong>'.$precio.' €/'.$mostrarunidad.'</strong></span>';
          }

          if(isset($key['disc_status']) && $key['disc_status']==1 && $key['disc_type_fk']==1 && $totalcarro>=$key['disc_value_required']){//tipo de descuento
            if($key['disc_method_fk']==1){//%
              $preal=($key['item_price']*(100-$key['disc_value_discounted'])/100);
              $preal_aux=($key['item_price_aux']*(100-$key['disc_value_discounted'])/100);
              //$precio='<span><strike><span id="pb">'.$key['item_price'].'</span> €/'.$mostrarunidad.'</strike></span><br><span style="font-size:18px;color:#AE0058"><strong>'.number_format(round($preal,2),2).' €/'.$mostrarunidad.'</strong></span>';
            }
            else if($key['disc_status']==1 && $key['disc_method_fk']==2 && $totalcarro>=$key['disc_value_required']){//%
              $preal=($key['item_price']-$key['disc_value_discounted']);
              $preal_aux=($key['item_price_aux']-$key['disc_value_discounted']);
              //$precio='<span><strike>'.$key['item_price'].' €/'.$key['item_unidad'].'</strike></span><br><span style="font-size:18px;color:#AE0058"><strong>'.number_format(round($preal,2),2).' €/'.$key['item_unidad'].'</strong></span>';
            }
          }
          elseif(!$key['item_economico']){
            //$precio=$precio.' €/'.$mostrarunidad;
          }
          /*
          echo "<br />precio: $precio";
          echo "<br />preciobase: $preciobase";
          echo "<br />preal: $preal";
          */
          $preal=number_format(round($preal,2),2,'.','');
          $preciobase=number_format(round($preciobase,2),2,'.','');

          $preal_aux=number_format(round($preal_aux,2),2,'.','');
          $preciobase_aux=number_format(round($preciobase_aux,2),2,'.','');
          ?>
          <div class="product-price row mt-4">
            <div class='col-6'>
              <span class="product-price-label">PRECIO</span>
              <div class="product-price">
                <span class="current-price-value" content="<?php echo $preal; ?>"><strong><?php echo number_format($preal, 2,',','.').' €/'.$mostrarunidad; ?></strong></span>
                <?php
                if ($preal != $preciobase){
                  echo "<br /><span class='regular-price'><del>".number_format($preciobase, 2,',','.')." €</del></span>";
                }
                ?>
              </div>
            </div>
            <div class='col-6'>
              <label for="unidades" class="product-price-label">UNIDADES</label>
              <div class="product-price">
                <?php
                if ($key['item_cat_fk']==276){
                  // PARA KP USAREMOS SU PROPIA CALCULADORA
                  echo '<input type="number" min="0" step="1" id="unidades" name="unidades"  value="1" class="w-25" oninput="calcularKP();" />';
                }
                elseif ($key['item_cat_fk']==268 && !$mostrar_calculadora_generica){
                  // PARA Santos Monteiro 'acabados especiales' usaremos su propia claculadora
                  echo '<input type="number" min="0" step="1" id="unidades" name="unidades"  value="1" class="w-25" oninput="calcularSantosMonteiro();" />';
                }
                else{
                  echo '<input type="number" min="0" step="1" id="unidades" name="unidades"  value="1" class="w-25" oninput="calcular_total();" />';
                }
                //<input type="number" min="0" step="1" id="unidades" name="unidades"  value="1" class="w-25" oninput="calcular_total();" />
                  if($key['item_unidad']!='m2')
                    echo ' '.$mostrarunidades;
                ?>
                <input type="hidden" id="ud" name="ud" value="<?=$key['item_unidad']?>"/> 
              </div>
            </div>
          </div>

          <div class="product-price row mt-4 align-items-end">
            <div class='col-6'>
              <span class="product-price-label total"><span>TOTAL</span> COMPRA</span>
              <div class="product-price">
                <span class="current-price-value" id='total-current-price'><?php echo number_format($preal, 2,',','.').' €'; ?></span>
                <?php
                if ($preal != $preciobase){
                  echo "<br /><span class='regular-price'><del id='total-regular-price'>".number_format($preciobase, 2,',','.')." €</del></span>";
                }
                ?>
              </div>
            </div>
            <div class='col-6'>
              <p class='text-left m-0'>
                Promociones especiales<br />
                Llámanos: <a rel="nofollow" target="_blank" href="tel:944056616"><strong>94 405 66 16</strong></a>
              </p>
            </div>
            <?php
            /*
            <div class="tax-shipping-delivery-label">
            Impuestos incluidos
            </div>
            */
            ?>
          </div>

          <div class="carroficha mt-3">
            <input type="hidden" id="preciobase" name="pb" value="<?=$preciobase?>"/>
            <input type="hidden" id="preciounitario" name="pu" value="<?=$preal?>"/>
            <input type="hidden" id="preciobase_aux" name="pb" value="<?=$preciobase_aux?>"/>
            <input type="hidden" id="preciounitario_aux" name="pu" value="<?=$preal_aux?>"/>
            <input type="hidden" id="precio_unitario_final" name="precio_unitario_final" value="<?=$preal?>"/>
            <input type="hidden" id="precio_unitario_final_sin_desc" name="precio_unitario_final_sin_desc" value="<?=$preciobase?>"/>
            <input type="hidden" id="nombre_completo" name="nombre_completo" value="<?php echo $nombre_completo; ?>"/>
            <input type="hidden" id="item_cat_fk" name="item_cat_fk" value="<?php echo $key['item_cat_fk']; ?>"/>
            <input type="hidden" id="fab" name="fab" value="<?=(isset($key['cat_name']))?$key['cat_name']:$key['item_name']?>"/>
            <input type="hidden" id="col" name="col" value="<?=(isset($key['coleccion_name']))?$key['coleccion_name']:""?>"/>
            <input type="hidden" id="itemid" name="itemid" value="<?=$key['item_id']?>"/>
            <input type="hidden" id="ancho_para_calculo" name="ancho_para_calculo" value="<?$key['item_ancho']; ?>"/>
            <input type="hidden" id="alto_para_calculo" name="alto_para_calculo" value="<?=$key['item_largo']; ?>"/>
            <input type="hidden" id="informacion_extra_forma" name="informacion_extra_forma" value="<?php echo $seleccionar_forma; ?>"/>
            <input type="hidden" id="informacion_extra_acabado" name="informacion_extra_acabado" value=""/>
            <input type="hidden" id="informacion_extra_greca" name="informacion_extra_greca" value=""/>
            <input type="hidden" id="informacion_extra_tipo" name="informacion_extra_tipo" value=""/>
            <input type="hidden" id="informacion_extra_opcion" name="informacion_extra_opcion" value=""/>
            <input type="hidden" id="informacion_extra_desperdicio" name="informacion_extra_desperdicio" value=""/>
            <input type="hidden" id="tipo_producto_txt" name="tipo_producto_txt" value="<?php echo $tipo_producto; ?>"/>
            <input type="hidden" id="tipo_producto_id" name="tipo_producto_id" value="<?php echo $key['item_tipo']; ?>"/>
            <?php 
            $metodo_descuento=0;
            if (isset($key['disc_method_fk']))
              $metodo_descuento=$key['disc_method_fk'];
            $valor_descuento=0;
            if (isset($key['disc_value_discounted']))
              $valor_descuento=$key['disc_value_discounted'];
            ?>
            <input type="hidden" id="metodo_descuento" name="metodo_descuento" value="<?php echo $metodo_descuento; ?>"/>
            <input type="hidden" id="valor_descuento" name="valor_descuento" value="<?php echo $valor_descuento; ?>"/>
            <?php
            /*
            if(false){ //$key['item_tipo']==0
            ?> 
              <input type="button" class="addformsample" name="addformsample" value="Solicitar Muestra"/> <?
            }
            <button class="addformitem boton" name="addform" value="Añadir al carro"/>Añadir al carro <i class="fa fa-shopping-cart"></i></button>
            */
            ?>
            <button class="addformitem boton-entero" name="addform" value="Añadir al carro"/>AÑADIR AL CARRITO</button>
          </div>

            <?php
            /*
            if(false){ //$key['item_tipo']==0
              echo anchor ("informacion_muestras_papel_pintado","Política de muestras");
            }
            */
            ?>

            <?php
            /*
            if ($key['item_tipo']==5){ // SI NO ES HERRAMIENTA?>
              <button onclick="history.back(-1)" type="button" name="update" value="Volver a la tienda" class="link_button2">Volver <i class="fa fa-reply"></i></button>
            <?
            }
            */
            ?>
          
          <?php 
          if (trim($key['plazo']!='') && $key['plazo']!=0){
          ?>    
            <div class="plazo-entrega mt-3">
              <div class='text-center'>PLAZO DE ENTREGA <strong><?php echo $key['plazo']; ?> DÍAS LABORABLES</strong></div>
            </div>
          <?
          }
          ?>
        </div> <!-- fin copiado del original -->
      </div>
    </div>
    <?php
    if ($key['item_tipo']!=5){
    ?>
      <div class='row detalles-producto'>
        <h2 class="h4 mb-0 pt-4 pb-4 text-left col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-sp-12">Detalles de producto</h2>
        <div class="estilazo col-12">
          <div class='p-4 border'>
            <table>
              <?php
              if ($key['item_tipo']==3){ // SI TELA
                echo "<tr><th>Composición: </th><td>{$key['composicion']}</td>\n";
                
                echo "<tr><th>Uso recomendado: </th><td>";
                $usos=explode(" ",$key['uso']);

                $i=0;
                foreach($usos as $k){
                  if($i>0)echo ', ';
                  if($k==0)echo 'Cortinas';
                  if($k==1)echo 'Tapicerias';
                  if($k==2)echo 'Stores';
                  if($k==3)echo 'Cojines';
                  if($k==4)echo 'Cabeceros';
                  if($k==5)echo 'Visillos';
                  $i++;
                }
                echo "</td>";
                if($key['item_largo']>0){
                  echo "<tr><th>Largo de la pieza: </th><td>{$key['item_largo']} cm</td></tr>\n";
                }
                if($key['item_ancho']>0){
                  echo "<tr><th>Ancho de la pieza: </th><td>{$key['item_ancho']} cm</td></tr>\n";
                }
                if($key['item_case']>0){
                  echo "<tr><th>Repetición largo: </th><td>{$key['item_case']} cm</td></tr>\n";
                }
                if($key['item_case2']>0){
                  echo "<tr><th>Repetición ancho: </th><td>".number_format((float)$key['item_case2'], 2, '.', '')." cm</td></tr>\n";
                }

                echo "<tr><th>Colores: </th><td>{$key['color']}</td></tr>\n";
                echo "<tr><th>Estilos: </th><td>{$key['estilo']}</td></tr>\n";
                echo "<tr><th>Plazo de entrega: </th><td>{$key['plazo']} días laborables</td></tr>\n";
              }
              else if ($key['item_tipo']==4){ // SI ALFOMBRA
                echo "<tr><th>Composición: </th><td>{$key['composicion']}</td></tr>\n";
                if ($key['item_unidad']=="Unidad"){
                  echo "<tr><th>Ancho: </th><td>{$key['item_ancho']} metros</td></tr>\n";
                  echo "<tr><th>Largo: </th><td>{$key['item_largo']} metros</td></tr>\n";
                }else{
                  echo "<tr><th>Dimensiones: </th><td>A medida</td></tr>\n";
                }
                echo "<tr><th>Colores: </th><td>{$key['color']}</td></tr>\n";
                echo "<tr><th>Estilos: </th><td>{$key['estilo']}</td></tr>\n";
                echo "<tr><th>Plazo de entrega: </th><td>{$key['plazo']} días laborables</td></tr>\n";
              }
              else if ($key['item_tipo']!=5){ // SI NO ES HERRAMIENTA
                //echo "<tr><th>Composición: </th><td>{$key['composicion']}</td></tr>\n";
                echo "<tr><th>Material: </th><td>";
                switch ($key['item_lavable']){
                  case 0: echo "No Lavable"; break;
                  case 1: echo "Lavable"; break;
                  case 2: echo "Esponjable"; break;
                  case 3: echo "SuperLavable"; break;
                }
                echo "</td></tr>";

                if($key['item_sol']==1)
                  echo "<tr><th>Resistencia a la luz: </th><td>Buena</td></tr>\n";
                else
                  echo "<tr><th>Resistencia a la luz: </th><td>Suficiente</td></tr>\n";
                
                if($key['item_vinilo']==1)
                  echo "<tr><th>Calidad: </th><td>$tipo_producto vinílico</td></tr>\n";
                
                switch ($key['item_cola']){
                  case "papel": echo "<tr><th>Encolar: </th><td>Papel</td></tr>"; break;
                  case "pared": echo "<tr><th>Encolar: </th><td>Pared</td></tr>"; break;
                  case "autoadhesivo": echo "<tr><th>Encolar: </th><td>Autoadhesivo</td></tr>"; break;
                }

                if ($key['item_unidad']=="Rollo"){
                  if ($key['item_tipo']==0) 
                    echo "<tr><th>Unidad: </th><td>Rollos de papel pintado</td></tr>\n";
                   else 
                    echo "<tr><th>Unidad: </th><td>Rollo</td></tr>\n";
                  echo "<tr><th>Ancho del rollo: </th><td>{$key['item_ancho']} centímetros</td></tr>\n";
                  echo "<tr><th>Largo del rollo: </th><td>{$key['item_largo']} metros</td></tr>\n";
                  if($key['item_case']==0)
                    echo "<tr><th>Case del dibujo: </th><td>No tiene case</td></tr>\n";
                  else
                    echo "<tr><th>Case del dibujo: </th><td>{$key['item_case']} centímetros</td></tr>\n";
                }
                elseif($key['item_case']!=0){
                  echo "<tr><th>Case del dibujo: </th><td>{$key['item_case']} centímetros</td></tr>\n";
                }
                // Si Unidades UNIDADES
                if ($key['item_unidad']=="Unidad"){
                  //echo "<tr><th>Unidad: </th><td>Unidad</td></tr>\n";
                  echo "<tr><th>Ancho: </th><td>{$key['item_ancho']} metros</td></tr>\n";
                  echo "<tr><th>Alto: </th><td>{$key['item_largo']} metros</td></tr>\n";
                }
                // Si Unidades Metros cuadrados
                if ($key['item_unidad']=="m2"){
                  echo "<tr><th>Unidad: </th><td>Se vende por metros cuadrados</td></tr>\n";
                }
                // Si Unidades Metros cuadrados
                if ($key['item_unidad']=="m lineal"){
                  echo "<tr><th>Unidad: </th><td>Se vende por metros lineales</td></tr>\n";
                  echo "<tr><th>Ancho de la pieza: </th><td>{$key['item_ancho']} cm</td></tr>\n";
                }
                echo "<tr><th>Colores: </th><td>{$key['color']}</td></tr>\n";
                echo "<tr><th>Estilos: </th><td>{$key['estilo']}</td></tr>\n";
                echo "<tr><th>Plazo de entrega: </th><td>{$key['plazo']} días laborables</td></tr>\n";
              }
              // Fin características específicas tipo producto
              if($key['item_weight']>1){
                echo "<tr><th>Peso: </th><td>{$key['item_weight']} gr</td></tr>\n";
              }
              if($key['extra']!=''){ 
                /*
                <li><?=  str_replace("<br />", "</li><li>", nl2br($key['extra']))?></li>
                */
                echo "<tr><th>Más información: </th><td>".nl2br($key['extra'])."</td></tr>\n";
              }
              if ($key['item_tipo']==3 && $key['limpieza']!=""){ // SI TELA
                echo "<tr><th>Limpieza: </th><td>";
                $limp=explode(" ",$key['limpieza']);
                foreach($limp as $k){
                  if($k==0)echo '<img src="'.$includes_dir.'iconos/0.jpg" alt="Limpieza en seco" title="Limpieza en seco"/>';
                  if($k==1)echo '<img src="'.$includes_dir.'iconos/1.jpg" alt="Lavadora" title="Lavadora"/>';
                  if($k==2)echo '<img src="'.$includes_dir.'iconos/2.jpg" alt="A mano" title="A mano"/>';
                  if($k==3)echo '<img src="'.$includes_dir.'iconos/3.jpg" alt="No centrifugar" title="No centrifugar"/>';
                  if($k==4)echo '<img src="'.$includes_dir.'iconos/4.jpg" alt="No secadora" title="No secadora"/>';
                  if($k==5)echo '<img src="'.$includes_dir.'iconos/5.jpg" alt="Sin Lejia" title="Sin Lejia"/>';
                  if($k==6)echo '<img src="'.$includes_dir.'iconos/6.jpg" alt="Planchar a temperatura baja" title="Planchar a temperatura baja"/>';
                  if($k==7)echo '<img src="'.$includes_dir.'iconos/7.jpg" alt="Planchar a temperatura media" title="Planchar a temperatura media"/>';
                  if($k==8)echo '<img src="'.$includes_dir.'iconos/8.jpg" alt="Planchar a temperatura alta" title="Planchar a temperatura alta"/>';
                  if($k==9)echo '<img src="'.$includes_dir.'iconos/9.jpg" alt="Lavar máximo 30º" title="Lavar máximo 30º"/>';
                  if($k==10)echo '<img src="'.$includes_dir.'iconos/10.jpg" alt="Lavar máximo 40º" title="Lavar máximo 40º"/>';
                  if($k==11)echo '<img src="'.$includes_dir.'iconos/11.jpg" alt="Lavar máximo 60º" title="Lavar máximo 60º"/>';
                }
                echo "</td>";
              }

              if ($key['item_tipo']<=2){ //
                echo "<tr><th>Instrucciones: </th><td>Leer las instrucciones de colocación en la etiqueta.</td></tr>\n";
              }
              ?>
            </table>
          </div>
        </div>
      </div>
    <?php
    }
    ?>

    <div class="row" id='articulos-relacionados'>
      <?php 
      $this->data['no_hay_filtros']=true;
      $this->load->view('frontend/otrosarticulos_nuevo'); 
      ?>
    </div>
  </div>
  <script>
  function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
  }
  var importeval=0;
  document.getElementById('inicio').scrollIntoView();

  /*
  */
    var categ =<?=$key['item_tipo']?>;
    var uds="<?=($key['item_unidad']=="m lineal")?"Metros lineal(es)":"Rollo(s)"?>"
    var tipo_unidad='<?=$key['item_unidad']?>';

    function CalculaMetros(){
      /*
      p_ancho= $("#p_ancho").val().replace(",",".");
      p_alto= $("#p_alto").val().replace(",",".");
      alert('ancho: '+p_ancho+' alto: '+p_alto);
      p_ancho=Math.ceil(p_ancho*10)/10;
      p_alto=Math.ceil(p_alto*10)/10;
      alert('ancho: '+p_ancho+' alto: '+p_alto);
      */
      if (!isNumeric($("#p_ancho").val())||!isNumeric($("#p_alto").val())){
        //$("#rescalcu").html("<div style=\"font-size: 16px;\">Los valores introducidos no son validos</div>");
        return;
      }
      if(isNumeric($("#p_ancho").val()) && isNumeric($("#p_alto").val()) && isNumeric($("#unidades").val())){
        var cm=0;
        var dec=parseFloat($("#p_ancho").val());
        var alt=parseFloat($("#p_alto").val());;
        <?if($key['item_unidad']=="m2" && $key['item_ancho']!=0){?>
          dec=Math.ceil(parseFloat($("#p_ancho").val())/<?=$key['item_ancho']?>)*<?=$key['item_ancho']?>;
        <?}?>
        <?if($key['item_unidad']=="m2" && $key['item_largo']!=0){?>
          alt=Math.ceil(parseFloat($("#p_alto").val())/<?=$key['item_largo']?>)*<?=$key['item_largo']?>;
        <?}?>
        <?if(isset($key['fabmargen']) && $key['item_unidad']=="m2" && $key['fabmargen']!=0){?>
          alt+=<?=$key['fabmargen']?>;
        <?}?>

        marca_item=$("#item_cat_fk").val();
        tipo_producto_id=$("#tipo_producto_id").val();
        console.log("dec"+dec+" alt:"+alt);
        console.log("tipo producto "+tipo_producto_id+" marca "+marca_item);
        //~ alert($("#ancho_para_calculo").val());
        //~ alert($("#alto_para_calculo").val());
        $("#ancho_para_calculo").val(dec);
        $("#alto_para_calculo").val(alt);
        //~ alert($("#ancho_para_calculo").val());
        //~ alert($("#alto_para_calculo").val());

        cm=dec*alt;
        if (cm<0)
          cm*=-1;
        /*
        preciounitario=parseFloat(<?php echo $preal; ?>);
        unidades=parseFloat($("#unidades").val());
        preciobase=parseFloat($("#unidades").val());
        */
        var preciounitario= parseFloat($("#preciounitario").val());
        var preciobase= parseFloat($("#preciobase").val());
        var unidades= parseFloat($("#unidades").val());

        precio_unitario_adaptado=parseFloat(preciounitario).toFixed(2);
        precio_base_adaptado=parseFloat(preciobase).toFixed(2);


        importe_tratamiento_imagen=0;
        importe_tratamiento_imagen_descuento=0;
        //if (tipo_producto_id==1 && (marca_item==31 || marca_item==250 || marca_item==278)){
        if (tipo_producto_id==1 && (marca_item==250 || marca_item==278)){
          importe_tratamiento_imagen=90;
          importe_tratamiento_imagen_descuento=importe_tratamiento_imagen;
          <?php
          if(isset($key['disc_method_fk']) && $key['disc_method_fk']==1){//%
          ?>
            importe_tratamiento_imagen_descuento=importe_tratamiento_imagen*(100-<?php echo $key['disc_value_discounted']; ?>)/100;
          <?php
          }
          ?>
        }

        console.log("tipo producto "+tipo_producto_id+" marca "+marca_item+" importe_tratamiento_imagen "+importe_tratamiento_imagen);

        <?php
        if($key['item_unidad']=="m2"){
          ?>
          if(cm.toFixed(2)<1){ 
            //DisplayImporte(parseFloat(<?=$preal?>)*parseFloat($("#unidades").val()));
            $("#total-current-price").html(parseFloat((preciounitario + importe_tratamiento_imagen_descuento) *unidades).toFixed(2).replace('.', ',')+" €");
            $("#total-regular-price").html(parseFloat((preciobase + importe_tratamiento_imagen)*unidades).toFixed(2).replace('.', ',')+" €");
            precio_unitario_adaptado=parseFloat(preciounitario + importe_tratamiento_imagen_descuento).toFixed(2);
            precio_base_adaptado=parseFloat(preciobase + importe_tratamiento_imagen).toFixed(2);

          }
          <?php
        }
        else{?>
          if(cm.toFixed(2)-<?=($key['item_ancho']*$key['item_largo'])?><Math.abs(0.001)){ 
            //DisplayImporte(parseFloat(<?=$preal?>)*parseFloat($("#unidades").val()));
            $("#total-current-price").html(parseFloat((preciounitario + importe_tratamiento_imagen_descuento)*unidades).toFixed(2).replace('.', ',')+" €");
            $("#total-regular-price").html(parseFloat((preciobase + importe_tratamiento_imagen)*unidades).toFixed(2).replace('.', ',')+" €");
            precio_unitario_adaptado=parseFloat(preciounitario + importe_tratamiento_imagen_descuento).toFixed(2);
            precio_base_adaptado=parseFloat(preciobase + importe_tratamiento_imagen).toFixed(2);
          }
        <?}?>
        else{
          //DisplayImporte(cm*parseFloat(<?=$preal?>)*parseFloat($("#unidades").val()));
          $("#total-current-price").html(parseFloat((cm*preciounitario + importe_tratamiento_imagen_descuento)*unidades).toFixed(2).replace('.', ',')+" €");
          $("#total-regular-price").html(parseFloat((cm*preciobase + importe_tratamiento_imagen)*unidades).toFixed(2).replace('.', ',')+" €");
          precio_unitario_adaptado=parseFloat(cm*preciounitario + importe_tratamiento_imagen_descuento).toFixed(2);
          precio_base_adaptado=parseFloat(cm*preciobase + importe_tratamiento_imagen).toFixed(2);
        }
      }
      else if(isNumeric($("#unidades").val())){
        //DisplayImporte(parseFloat(<?=$preal?>)*parseFloat($("#unidades").val()));
        $("#total-current-price").html(parseFloat((preciounitario + importe_tratamiento_imagen_descuento)*unidades).toFixed(2).replace('.', ',')+" €");
        $("#total-regular-price").html(parseFloat((preciobase + importe_tratamiento_imagen)*unidades).toFixed(2).replace('.', ',')+" €");
        precio_unitario_adaptado=parseFloat(cm*preciounitario + importe_tratamiento_imagen_descuento).toFixed(2);
        precio_base_adaptado=parseFloat(cm*preciobase + importe_tratamiento_imagen).toFixed(2);
      }
      //else 
        //DisplayImporte(0);
        console.log("precio_unitario_adaptado 2 "+precio_unitario_adaptado+" precio_base_adaptado 2 "+precio_base_adaptado);

      $("#precio_unitario_final").val(precio_unitario_adaptado);
      $("#precio_unitario_final_sin_desc").val(precio_base_adaptado);
    }

    function calcular_nuevo(){
      var paredancho= parseFloat($("#i-ancho-pared").val());
      var paredalto= parseFloat($("#i-alto-pared").val());
      var calcu=false;
      if (categ==1){
        alert("Calculadora no disponible para murales")
      }
      else if (categ<3){
        if (!isNumeric(paredancho)||!isNumeric(paredalto)){
          //$("#rescalcu").html("<div style=\"font-size: 16px;\">Los valores introducidos no son validos</div>");
          return;
        }

        num_calculado=calcula();
        $("#i-resultado").val(num_calculado)


        //$("#rescalcu").html("<div style=\"font-size: 16px;\"><b><font>"+ calcula_nuevo()+ " "+uds+"</font></b>* Los resultados son aproximados</div>");
        //calcu=true;
      }
      else{
        alert("Calculadora no disponible para estos articulos");
      }

    }
    function calcula(){
      var ancho = parseFloat($("#p_ancho").val())/100;
      var rollo = parseFloat($("#p_alto").val());
      var caser = parseFloat($("#case").val())/100;
      return calcuval(ancho,rollo,caser);
    }
    function calcuval(ancho,rollo,caser){
      paredancho= parseFloat($("#i-ancho-pared").val());
      paredalto= parseFloat($("#i-alto-pared").val());
      categ=<?php echo $key['item_tipo']; ?>;

      //alert('ancho: '+ancho+' rollo: '+rollo+' caser: '+caser );
      //alert('paredancho: '+paredancho+' paredalto: '+paredalto);
      
      var segmentos=Math.ceil(paredancho/ancho);
      if(categ==0){

        if(caser>0.005){
          var tiracase=paredalto%caser;
          var tirafinal=paredalto+caser-tiracase;
        }
        else 
          var tirafinal=paredalto;
        var rollofinal=(rollo/tirafinal>1)?Math.floor(rollo/tirafinal):1/Math.floor(tirafinal/rollo);

        return Math.ceil(segmentos/rollofinal);
      }
      if(categ==2){
         var segmentos=Math.ceil(paredancho/ancho);
          if(caser>0.005){
            var tiracase=paredalto%caser;
            var tirafinal=paredalto+caser-tiracase;
           }
          else var tirafinal=paredalto;

          return Math.ceil(tirafinal*segmentos);
      }
    }

    function calcular_total(){
      <?php
      if($key['item_unidad']=='m2'){
      ?>
        CalculaMetros();
      <?php
      }
      else{
      ?>
        var preciounitario= $("#preciounitario").val();
        var preciobase= $("#preciobase").val();
        var unidades= $("#unidades").val();
        
        $("#total-current-price").html(parseFloat(preciounitario*unidades).toFixed(2).replace('.', ',')+" €");
        $("#total-regular-price").html(parseFloat(preciobase*unidades).toFixed(2).replace('.', ',')+" €");
      <?php
      }
      ?>
    }

    //function ajax_update_mini_cart(data) {
    function ajax_update_mini_cart() {
      $.ajax({
        url: '/tienda/datos_minicarro',
        type: 'POST',
        success: function(data){
          $('#mini_cart').replaceWith(data);
          activar_minicarro();
        }
      });
    }
    /*
    function ajax_update_mini_cart(data,esmuestra) {
      var ajax_mini_cart = $(data).find('.ulcarro>.status');
      var importe =$(data).find('.precio-minicarro').html();

      alert(importe);
      $('.ulcarro>.status').replaceWith(ajax_mini_cart);
      $('.precio-minicarro').replaceWith(importe);
      <?php
      if(isset($key['stock_quantity'])){?>
        if(!esmuestra && parseFloat($("#unidades").val())>parseFloat(<?=$key['stock_quantity']?>)){
          alert("No es posible añadir todos los artículos al carro, solo quedan <?=$key['stock_quantity']?> unidades");
          importeval=(<?=$preal?>*parseFloat(<?=$key['stock_quantity']?>)).toFixed(2)+" €";
        }
      <?
      }
      ?>
      if(esmuestra)  
        $( "#importevalor").html("2 €");
      else  
        $( "#importevalor").html(importeval);
    }
    */
  </script>
  <?php
  /*
  <div style="display:none" id="dialog-confirm" title="Se ha añadido el artículo">
    <p>
      <span>
        <img style="width:60px; margin-right:10px;" src="<?=$t?>th.jpg" alt='<?php echo $key['imgdetalt']; ?> - th' title='<?php echo $key['imgdettitle']; ?> - th' /> 
        <?=(isset($key['cat_name']))?$key['cat_name']:$key['item_name']?> - <?=(isset($key['coleccion_name']))?$key['coleccion_name']:""?> - <?=$key['item_ref']?> : <span id="importevalor"></span></span>
    </p>
  </div>
  */



  $this->data['img_modal']=$t;
  $this->load->view('frontend/articulo_modal_carrito', $this->data);

  $this->data['img_modal']=$img_producto->src;
  $this->load->view('frontend/articulo_modal_simulacion', $this->data);

  $this->load->view('frontend/articulo_modal_error');

  ?>
</div>

<script>
// Measure a view of product details. This example assumes the detail view occurs on pageload,
// and also tracks a standard pageview of the details page.
dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
dataLayer.push({
  'ecommerce': {
    'detail': {
      'products': [{
        'name': '<?php echo $nombre_completo; ?>',         // Name or ID is required.
        'id': '<?php echo $key['item_id']; ?>',
        'price': '<?php echo number_format(round($preal,2),2); ?>',
        'brand': '<?php echo $key['cat_name']; ?>',
        'category': '<?php echo ucwords(str_replace('_', ' ', $tipo_producto)); ?>',
       }]
     }
   }
});


// Measure a view of product details. This example assumes the detail view occurs on pageload,
dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
dataLayer.push({
  event: "view_item",
  ecommerce: {
    'currencyCode': 'EUR',
    'items': [{
      'item_name': "<?php echo $nombre_completo; ?>", // Name or ID is required.
      'item_id': "<?php echo $key['item_id']; ?>",
      'price': '<?php echo number_format(round($preal,2),2); ?>',
      'item_brand': "<?php if (isset($key['cat_name'])) echo $key['cat_name']; ?>",
      'item_category': "<?php echo ucwords(str_replace('_', ' ', $tipo_producto)); ?>",
      'quantity': 1
    }]
  }
});
/*
*/
</script>

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

  var botones_collapse_calc = document.getElementsByClassName("calc_collapsible");
  for (i = 0; i < botones_collapse_calc.length; i++) {
    botones_collapse_calc[i].addEventListener("click", function() {
      this.classList.toggle("active");
      document.getElementById("hr_calculadora").classList.toggle("d-none");
    });
  }

</script>
