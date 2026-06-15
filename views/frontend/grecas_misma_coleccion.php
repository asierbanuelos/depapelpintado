<?php 
$class_img_acabado_kp=''; 
if (isset($mostrar_calculadora_keplan))
  $class_img_acabado_kp=' img-acabado-kp '; 

echo '<div class="row">';
echo '  <div class="h6 destacado mt-3 mb-3 col-11">SELECCIONE EL ACABADO: <span id="acabado_seleccionado"></span></div>';
//echo '  <button class="calc_collapsible col-1 py-0" data-toggle="collapse" data-target="#lista-opciones-grecas" aria-expanded="false" aria-controls="calc-colapsable" aria-label="Ver opcines grecas"></button>';
echo '</div>';

//echo '<div class="collapse" id="lista-opciones-grecas">';
echo '<div class="" id="lista-opciones-grecas">';
echo '<ul class="opciones-grecas row p-0">';
if ($mostrar_grecas_exteriores){
  $cenefas_exteriores[0]['src']='/includes/images/cenefa-exterior-10.jpg';
  $cenefas_exteriores[0]['nombre']='Cenefa exterior de 10 cm';
  $cenefas_exteriores[0]['ancho']='10';
  $cenefas_exteriores[1]['src']='/includes/images/cenefa-exterior-15.jpg';
  $cenefas_exteriores[1]['nombre']='Cenefa exterior de 15 cm';
  $cenefas_exteriores[1]['ancho']='15';
  $cenefas_exteriores[2]['src']='/includes/images/cenefa-exterior-20.jpg';
  $cenefas_exteriores[2]['nombre']='Cenefa exterior de 20 cm';
  $cenefas_exteriores[2]['ancho']='20';
  //echo '<ul class="opciones-grecas row p-0">';
  foreach ($cenefas_exteriores as $item_cenefa){
    $nombre=$item_cenefa['nombre'];
    $src=$item_cenefa['src'];
    $ancho_greca=$item_cenefa['ancho'];
    echo '<li class="item-opcion-greca col-2">';
    echo '  <div class="img-opcion-greca">';
    echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-acabado'.$class_img_acabado_kp.'" data-name-acabado="'.$nombre.'" data-ancho-greca-exterior="'.$ancho_greca.'" data-ancho-greca-interior="0" src="'.$src.'"/>';
    echo '    <p class="name-opcion-greca text-center">'.$nombre.'</p>';
    echo '  </div>';
    echo '</li>';
  }
  //echo '</ul>';
}

if ($mostrar_grecas_interiores){
  $cenefas_interiores[0]['src']='/includes/images/cenefa-interior-5.jpg';
  $cenefas_interiores[0]['nombre']='Cenefa interior de 5 cm';
  $cenefas_interiores[0]['ancho']='5';
  $cenefas_interiores[1]['src']='/includes/images/cenefa-interior-10.jpg';
  $cenefas_interiores[1]['nombre']='Cenefa interior de 10 cm';
  $cenefas_interiores[1]['ancho']='10';
  $cenefas_interiores[2]['src']='/includes/images/cenefa-interior-15.jpg';
  $cenefas_interiores[2]['nombre']='Cenefa interior de 15 cm';
  $cenefas_interiores[2]['ancho']='15';
  //echo '<ul class="opciones-grecas row p-0">';
  foreach ($cenefas_interiores as $item_cenefa){
    $nombre=$item_cenefa['nombre'];
    $src=$item_cenefa['src'];
    $ancho_greca=$item_cenefa['ancho'];
    echo '<li class="item-opcion-greca col-2">';
    echo '  <div class="img-opcion-greca">';
    echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-acabado" data-name-acabado="'.$nombre.'" data-ancho-greca-exterior="0" data-ancho-greca-interior="'.$ancho_greca.'" src="'.$src.'"/>';
    echo '    <p class="name-opcion-greca text-center">'.$nombre.'</p>';
    echo '  </div>';
    echo '</li>';
  }
  //echo '</ul>';
}
echo '</ul>';
echo '</div>';

if (trim($key['item_name'])!='')
  $nombre_aux=trim($key['item_name']);
else{
  $a_nombre_aux=explode('CON', $key['item_ref']);
  $nombre_aux=trim($a_nombre_aux[0]);
}
$title_aux=$nombre_aux;
$alt_aux=$nombre_aux;
echo '<div class="row">';
echo '  <div class="h6 destacado mt-3 mb-3 col-11">SELECCIONE EL COLOR DE LA CENEFA: <span id="greca_seleccionada" data-idarticulo-greca="'.$key['item_id'].'"></span></div>';
//echo '  <button class="calc_collapsible col-1 py-0" data-toggle="collapse" data-target="#lista-colores-grecas" aria-expanded="false" aria-controls="calc-colapsable" aria-label="Ver opciones colores"></button>';
echo '</div>';

// Quitamos la opción colapsable y ver más
//echo '<div class="contenido-colapsable contenido-colapsable-colores" id="lista-colores-grecas">';
echo '<div class="" id="lista-colores-grecas">';
echo '<ul class="opciones-grecas-color row p-0">';
$kont=0;

$posibles_grecas=$otro;
if (isset($a_grecas_varias_colecciones))
  $posibles_grecas=$a_grecas_varias_colecciones;

foreach ($posibles_grecas as $item_greca){
  $kont++;
  $img_selected='';
  if (trim($item_greca['item_name'])!='')
    $nombre_aux=trim($item_greca['item_name']);
  else{
    $a_nombre_aux=explode('SIN', $item_greca['item_ref']);
    $nombre_aux=trim($a_nombre_aux[0]);
  }
  $title_aux=$nombre_aux;
  $alt_aux=$nombre_aux;
  echo '<li class="item-opcion-greca col-2 mb-3">';
  echo '  <div class="img-opcion-greca">';
  echo '  <figure>';
  echo '    <img title="'.$title_aux.'" alt="'.$alt_aux.'" class="img-greca" data-id-greca="'.$key['item_id'].'" data-name-greca="'.$nombre_aux.'" src="'.$includes_dir.str_replace("../", "", $item_greca['img']).'th.jpg"/>';
  echo '  </figure>';
  echo '    <p class="name-color-greca text-center">'.$nombre_aux.'</p>';
  echo '  </div>';
  echo '</li>';
}
echo '</ul>';
echo '</div>';
// Quitamos la opción colapsable y ver más
//if ($kont>12)
//  echo '<button class="my_collapsible" aria-label="Ver más colores" ></button>';



if (isset($mostrar_calculadora_keplan)){
  $txt_caja='Introduce las medidas de tu alfombra:';
  $txt_p_ancho='Ancho en metros (max. 2m + greca)';
  $txt_p_alto='Largo en metros (max. 25m)';
  ?>
  <div class="product-detail-calculadora-rollo">
    <div class="product-title row">
      <span class="title col-12"><?php echo $txt_caja; ?></span>
    </div>

    <div id='hr_calculadora_alfombra' class="row hr_calculadora">
      <hr class="col-12 p-0 mt-2 mb-4" style='border-top: 1px solid #212529;'/>
    </div>

    <div class="form-group row">
      <input type="hidden" id='ancho_greca_exterior' name='ancho_greca_exterior' value='0' />  
      <input type="hidden" id='ancho_greca_interior' name='ancho_greca_interior' value='0' />  
      <p class="col-12">Introduce las dimensiones necesarias en metros, ej: 1.2 x 2.5</p>
      <div class="col-6">
        <div class="pr-15">
          <label for="p_alto"><?php echo $txt_p_ancho; ?></label>
          <div class="">
            <div class="">
              <input type="number" min="0" step="0.1" id="p_ancho" name="p_ancho" class="w-75 metrs calcuinput" oninput="calcularKP();" /> m
            </div>
          </div>
        </div>
      </div>
      <div class="col-6">
        <div class="">
          <label for="p_alto"><?php echo $txt_p_alto; ?></label>
          <div class="">
            <div class="">
              <input type="number" min="0" step="0.1" id="p_alto" name="p_alto" class="w-75" oninput="calcularKP();" /> m
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="mt-4"><small><strong>Se confeccionan a partir de rollos de 1 ó 2 metros de ancho en función de la medida final solicitada considerando siempre el mínimo desperdicio de material posible sin tener en cuenta el sentido de tramas o dibujos.</strong></small></div>
    <?php 
    $this->load->view('frontend/info_opc_seleccionadas'); 
    ?>
  </div>
  <script>
  <!--
  function calcularKP(){
    if (!isNumeric($("#p_ancho").val())||!isNumeric($("#p_alto").val())){
      //$("#rescalcu").html("<div style=\"font-size: 16px;\">Los valores introducidos no son validos</div>");
      return;
    }
    if(isNumeric($("#p_ancho").val()) && isNumeric($("#p_alto").val()) && isNumeric($("#unidades").val())){
      p_ancho= $("#p_ancho").val().replace(",",".");
      p_alto= $("#p_alto").val().replace(",",".");
      unidades= $("#unidades").val();
      //alert('ancho: '+p_ancho+' alto: '+p_alto);
      p_ancho=Math.ceil(p_ancho*10)/10;
      p_alto=Math.ceil(p_alto*10)/10;

      ancho_greca_exterior=$("#ancho_greca_exterior").val();
      //ancho_greca_interior=$("#ancho_greca_interior").val();
      
      // Quitamos a la alfombra los cm de la greca el ancho de la greca 
      p_ancho_reducido=p_ancho - (ancho_greca_exterior * 2 / 100);
      p_alto_reducido=p_alto - (ancho_greca_exterior * 2 / 100);

      if (p_ancho_reducido>2){
        alert('El ancho de la alfombra con el ancho de greca seleccionado no puede exceder de '+(2 + ancho_greca_exterior*2/100)+' metros.');
        $("#p_ancho").val(2 + ancho_greca_exterior*2/100);
        return;
      }
      else if (p_ancho_reducido>1){
        metros_pieza=p_alto_reducido*2;
      }
      else{
        metros_pieza=p_alto_reducido*1;
      }

      // Si la pieza central es menor de dos metros en abas dimensiones, miramos por si acaso la opción más barata, menos m2
      metros_sentido_inverso=99999;
      if(p_ancho_reducido<2 && p_alto_reducido < 2){
        if (p_alto_reducido>1){
          metros_sentido_inverso=p_ancho_reducido*2;
        }
        else{
          metros_sentido_inverso=p_ancho_reducido*1;
        }
      }

      if(metros_sentido_inverso < metros_pieza){
        metros_pieza=metros_sentido_inverso;
      }


      //alert('metros_pieza: '+metros_pieza+'\n'+'metros_sentido_inverso: : '+metros_sentido_inverso);



      perimetro=p_ancho*2 + p_alto*2;
      //Greca de 5 a 15 cm......... 42€/ml.
      //Greca de 126 a 25 cm....... 47€/ml.
      
      precio_m_2= 0;
      precio_m_lineal= 0;
      if (ancho_greca_exterior > 15)
        precio_m_lineal= 47;
      else if(ancho_greca_exterior > 0)
        precio_m_lineal= 42;

      //alert('ancho: '+p_ancho_reducido+' alto: '+p_alto_reducido+' unidades: '+unidades+'\n'+'metros_pieza: '+metros_pieza+' perimetro: '+perimetro+'\n'+'ancho_greca_exterior: '+ancho_greca_exterior+'precio ml: '+precio_m_lineal);

      preciounitario= parseFloat($("#preciounitario").val()); // con descuento
      preciobase= parseFloat($("#preciobase").val()); // precio original`

      console.log('principal: '+p_ancho_reducido+'x'+p_alto_reducido+': '+metros_pieza+' precio metro: '+preciounitario+' total: '+metros_pieza*preciounitario);
      console.log('ancho_greca_exterior: '+ancho_greca_exterior+' perimetro: '+perimetro+'precio ml: '+precio_m_lineal+' total: '+perimetro*precio_m_lineal);
      //console.log("preciounitario: "+ preciounitario);
      
      precio_alfombra_original=metros_pieza*preciobase + perimetro*precio_m_lineal + metros_pieza*precio_m_2;   
      precio_alfombra_final=metros_pieza*preciounitario + perimetro*precio_m_lineal + metros_pieza*precio_m_2;    
      
      precio_extra_neto_dimensiones_alfombra=25;
      precio_extra_bruto_dimensiones_alfombra=25;
      //ESTAS ALFOMBRAS NO PUEDEN TENER MÁS DE 3 METROS DE ANCHO
      /*
      if (p_ancho>=3 && p_alto>=3){
        // Si las dimensiones exceden de 3 metros (incluidos)
        precio_extra_neto_dimensiones_alfombra=50;
        precio_extra_bruto_dimensiones_alfombra=50;
        console.log("sumar 50 a " +precio_alfombra_final);
        //precio_alfombra_final+=precio_extra_neto_dimensiones_alfombra;
        //precio_alfombra_original+=precio_extra_bruto_dimensiones_alfombra;
      }
      */
      //Si tiene descuento hay que añadir el porcentaje para que el extra siempre quede en 50 euros netos
      if (metodo_descuento==1){
              precio_extra_bruto_dimensiones_alfombra=precio_extra_neto_dimensiones_alfombra*100/(100 - valor_descuento);
      }

      precio_alfombra_final+=precio_extra_neto_dimensiones_alfombra;
      precio_alfombra_original+=precio_extra_bruto_dimensiones_alfombra;

      $("#total-current-price").html(parseFloat(precio_alfombra_final*unidades).toFixed(2).replace('.', ',')+" €");
      $("#total-regular-price").html(parseFloat(precio_alfombra_original*unidades).toFixed(2).replace('.', ',')+" €");
     
      $("#precio_unitario_final").val(parseFloat(precio_alfombra_final).toFixed(2));
      $("#precio_unitario_final_sin_desc").val(parseFloat(precio_alfombra_original).toFixed(2));

      if ($("#ficha-total-price").length) {
        $("#ficha-total-price").html($("#total-current-price").html());
      }
      if ($("#ficha-total-price-base").length) {
        $("#ficha-total-price-base").html($("#total-regular-price").html());
      }
    }
  }
  -->
  </script>
<?php
}
?>
