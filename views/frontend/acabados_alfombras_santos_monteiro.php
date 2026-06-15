<?php
// En esta versión, cogemos los datos desde la BBDD
//$this->load->model('santos_monteiro_model');

$a_datos_acabados=$this->santos_monteiro_model->get_datos_acabados();
$a_precios=$this->santos_monteiro_model->get_precios_acabados($key['item_coleccion_id']);
$a_opciones=$this->santos_monteiro_model->get_opciones_from_array(); 


$a_acabados=array();
$precios_sin_acabado=array();
foreach ($a_precios as $id_tarifa => $datos_tarifa){
	if ($datos_tarifa->precio_m_cuadrado!=0){
		if ($datos_tarifa->idsantos_monteiro_acabado==1){
			$precios_sin_acabado['precio_m2_medida']=$datos_tarifa->precio_m_cuadrado;
			$precios_sin_acabado['precio_m2_medida_ancho_rollo']=$datos_tarifa->precio_m_cuadrado_exacto;
		}
		$datos_acabado=$a_datos_acabados[$datos_tarifa->idsantos_monteiro_acabado];
		/*
		print '<pre><xmp>';
		print_r($datos_tarifa);
		print '</xmp></pre>';
		*/
		$a_acabados[strip_tags($datos_acabado->nombre_acabado)]['img']=$datos_acabado->img_acabado;
		$a_acabados[strip_tags($datos_acabado->nombre_acabado)]['opciones']=$datos_acabado->nombre_acabado_limpio;
		$a_acabados[strip_tags($datos_acabado->nombre_acabado)]['txt_opciones']=$datos_acabado->nombre_acabado_web;
		$a_acabados[strip_tags($datos_acabado->nombre_acabado)]['txt_web']=$datos_acabado->txt_web;
		$a_acabados[strip_tags($datos_acabado->nombre_acabado)]['precio_m2_medida']=$datos_tarifa->precio_m_cuadrado;
		$a_acabados[strip_tags($datos_acabado->nombre_acabado)]['precio_m2_medida_ancho_rollo']=$datos_tarifa->precio_m_cuadrado_exacto;
		$a_acabados[strip_tags($datos_acabado->nombre_acabado)]['m2_diferencia']=$datos_tarifa->precio_m_cuadrado - $precios_sin_acabado['precio_m2_medida'];
		$a_acabados[strip_tags($datos_acabado->nombre_acabado)]['m2_rollo_diferencia']=$datos_tarifa->precio_m_cuadrado_exacto - $precios_sin_acabado['precio_m2_medida_ancho_rollo'];
	}
	// code...
}
/*
print '<pre><xmp>';
print_r($a_acabados);
print '</xmp></pre>';
exit;

echo "nueva opción";
*/
$familia_producto=4; // 4: alfombras
$marca_producto=268; // 268: marca Santos Monteiro
// CAMBIAMOS EL MÉTIODO DE CALCULO, POR LO QUE LAS ALFOMBRAS SE VAN A CALCULAR EN BASE AL PRECIO DEL M2 + EL PERMÍMETRO LINEAL

// 4: alfombras
// 268: marca Santos Monteiro

$a_forma_alfombra['RECTANGULAR CUADRADA']['img']='/includes/images/acabados-santos-monteiro/rectangular-cuadrada.jpg';
$a_forma_alfombra['REDONDA']['img']='/includes/images/acabados-santos-monteiro/redonda.jpg';
$a_forma_alfombra['ROLLO']['img']='/includes/images/acabados-santos-monteiro/rollo.jpg';

$a_rollos[2]='ANCHO DE 2 METROS';
$a_rollos[4]='ANCHO DE 4 METROS';


$rollo_diferenciado[1799]['ancho_1']=2.5;	// BLISS
$rollo_diferenciado[1799]['ancho_2']=5;		// BLISS

echo '<div class="row">';
echo '  <div class="h6 destacado mt-3 mb-3 col-11">SELECCIONE LA FORMA: <span id="forma_seleccionada"></span></div>';
echo '</div>';

echo '<div class="" id="lista-opciones-formas">';
echo '<ul class="opciones-grecas row p-0">';
foreach ($a_forma_alfombra as $txt_forma=>$datos_forma){
	$nombre=$txt_forma;
	$src=$datos_forma['img'];
	echo '<li class="item-opcion-greca col-3 col-lg-2">';
	echo '  <div class="img-opcion-greca">';
	echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-forma-santos-monteiro" data-name-forma="'.$nombre.'" src="'.$src.'"/>';
	//echo '    <p class="name-opcion-greca text-center">'.$nombre.'</p>';
	echo '  </div>';
	echo '</li>';
}
echo '</ul>';
echo '</div>';

echo '<div id="div-acabados-santos-monteiro">';
echo '<div class="row">';
echo '  <div class="h6 destacado mt-3 mb-3 col-11">SELECCIONE EL ACABADO: <span id="acabado_seleccionado"></span></div>';
echo '</div>';

echo '<div class="" id="lista-opciones-grecas">';
echo '<ul class="opciones-grecas row p-0">';
foreach ($a_acabados as $txt_acabado=>$datos_acabado){
	//$nombre=$txt_acabado;
	$nombre=$datos_acabado['txt_web'];
	$nombre_aux='ID_'.str_replace(' ', '_', $nombre);
	$precio_m_lineal=0;
	if (isset($datos_acabado['precio_m_lineal']))
		$precio_m_lineal=$datos_acabado['precio_m_lineal'];
	
	$precio_m_lineal_largo=0;
	if ($txt_acabado=='FRANJA' && isset($a_acabados['LINE']['precio_m_lineal']))
		$precio_m_lineal_largo=$a_acabados['LINE']['precio_m_lineal']; // El acabado franja va en el lado corto, lado largo LINE

	$precio_m2_medida=0;
	if (isset($datos_acabado['precio_m2_medida']))
		$precio_m2_medida=$datos_acabado['precio_m2_medida'];

	$precio_m2_medida_ancho_rollo=0;
	if (isset($datos_acabado['precio_m2_medida_ancho_rollo']))
		$precio_m2_medida_ancho_rollo=$datos_acabado['precio_m2_medida_ancho_rollo'];

	$txt_tit_opcion='';
	if (isset($datos_acabado['txt_opciones']))
		$txt_tit_opcion=$datos_acabado['txt_opciones'];
	
	$div_opciones='--';
	if (isset($datos_acabado['opciones']) && trim($datos_acabado['opciones'])!='')
		$div_opciones=$datos_acabado['opciones'];

	if (trim($datos_acabado['img'])!=''){
		$src=$datos_acabado['img'];
		echo '<li class="item-opcion-greca col-3 col-lg-2">';
		echo '  <div class="img-opcion-greca">';
		echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-acabado-santos-monteiro" id="'.$nombre_aux.'" data-name-acabado="'.$nombre.'" data-div-opciones="'.$div_opciones.'" data-txt-opciones="'.$txt_tit_opcion.'" data-precio-ml="'.$precio_m_lineal.'" data-precio-ml_largo="'.$precio_m_lineal_largo.'" data-precio-m2="'.$precio_m2_medida.'" data-precio-m2-ancho-rollo="'.$precio_m2_medida_ancho_rollo.'" src="'.$src.'"/>';
		//echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-acabado-santos-monteiro" id="'.$nombre_aux.'" data-name-acabado="'.$nombre.'" data-div-opciones="'.$div_opciones.'" data-txt-opciones="'.$txt_tit_opcion.'" data-precio-ml="'.$precio_m_lineal.'" data-precio-ml_largo="'.$precio_m_lineal_largo.'" data-precio-m2="'.$precio_m2_medida.'" data-precio_m2_fieltro="'.$precio_m2_fieltro.'" data-precio_extra="'.$precio_extra.'" data-precio_promo="'.$precio_promocion.'" src="'.$src.'"/>';
		echo '    <p class="name-opcion-greca text-center">'.$nombre.'</p>';
		echo '  </div>';
		echo '</li>';
	}
}
echo '</ul>';
echo '</div>';
echo '</div>';

$a_generados=array();
/*
print '<pre><xmp>';
print_r($datos_acabado);
print '</xmp></pre>';
*/
foreach ($a_acabados as $txt_acabado=>$datos_acabado){
	if (isset($datos_acabado['opciones'])){
		$txt_opcion=$datos_acabado['opciones'];
		$txt_tit_opcion=$datos_acabado['txt_opciones'];
		if (isset($a_opciones[$txt_opcion]) && !isset($a_generados[$txt_opcion])){
			//echo '<div class="" id="'.$txt_opcion.'">';
			echo '<div class="opciones-santos-monteiro d-none" id="opciones-'.$txt_opcion.'">';
			if (isset($datos_acabado['tipo_txt'])){
				echo '<div class="row">';
				echo '  <div class="h6 destacado mt-3 m3-2 col-11"><span class="txt_opcion_tipo">'.$datos_acabado['tipo_txt'].':</span> <span id="tipo-'.$txt_opcion.'" class="txt-tipo-seleccionado"></span></div>';
				//echo '  <button class="calc_collapsible col-1 py-0" data-toggle="collapse" data-target="#lista-colores-grecas" aria-expanded="false" aria-controls="calc-colapsable" aria-label="Ver opciones colores"></button>';
				echo '</div>';
				echo '<ul class="opciones-grecas row p-0">';
				foreach ($datos_acabado['tipo'] as $txt_tipo=>$img_tipo){
					$nombre=$txt_tipo;
					$src=$img_tipo;
					
					echo '<li class="item-opcion-greca col-3 col-lg-2">';
					echo '  <div class="img-opcion-greca">';
					echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-opcion-tipo-santos-monteiro" data-name-tipo="'.$nombre.'" data-txt-opcion="'.$txt_opcion.'" src="'.$src.'"/>';
					echo '    <p class="name-color-greca text-center">'.$nombre.'</p>';
					echo '  </div>';
					echo '</li>';
				}
				echo '</ul>';
			}



			echo '<div class="row">';
			echo '  <div class="h6 destacado mt-3 mb-3 col-11"><span id="txt-acabado-'.$txt_opcion.'" class="txt_opcion_acabado">'.$txt_tit_opcion.'</span>: <span id="seleccion-'.$txt_opcion.'" class="txt-opcion-seleccionada"></span></div>';
			//echo '  <button class="calc_collapsible col-1 py-0" data-toggle="collapse" data-target="#lista-colores-grecas" aria-expanded="false" aria-controls="calc-colapsable" aria-label="Ver opciones colores"></button>';
			echo '</div>';
			echo '<ul class="opciones-grecas row p-0">';
			foreach ($a_opciones[$txt_opcion] as $txt_remate=>$img_remate){
				$nombre=$txt_remate;
				$src=$img_remate;
				echo '<li class="item-opcion-greca col-3 col-lg-2">';
				echo '  <div class="img-opcion-greca">';
				echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-opcion-santos-monteiro" data-name-opcion="'.$nombre.'" data-txt-opcion="'.$txt_opcion.'" src="'.$src.'"/>';
				echo '    <p class="name-color-greca text-center">'.$nombre.'</p>';
				echo '  </div>';
				echo '</li>';
			}
			echo '</ul>';
			echo '</div>';
			$a_generados[$txt_opcion]=$txt_opcion;
		}
	}
}
/*
*/
$txt_caja='Introduce las medidas de tu alfombra:';
$txt_p_ancho='Ancho (max. 4m)';
$txt_p_alto='Largo (max. 25m)';

$ancho_1=2;
$ancho_2=4;
if (isset($rollo_diferenciado[$key['item_coleccion_id']])){
	$ancho_1=$rollo_diferenciado[$key['item_coleccion_id']]['ancho_1'];
	$ancho_2=$rollo_diferenciado[$key['item_coleccion_id']]['ancho_2'];

	$txt_p_ancho='Ancho (max. '.$ancho_2.'m)';
}
?>
<div class="product-detail-calculadora-rollo">
	<div class="product-title row">
	  <span class="title col-12"><?php echo $txt_caja; ?></span>
	</div>

	<div id='hr_calculadora_alfombra' class="row hr_calculadora">
	  <hr class="col-12 p-0 mt-2 mb-4" style='border-top: 1px solid #212529;'/>
	</div>

	<div class="form-group">
		<input type="hidden" id='calc_precio_m_lineal' name='precio_m_lineal' value='0' />	
		<input type="hidden" id='calc_precio_m_lineal_largo' name='calc_precio_m_lineal_largo' value='0' />	
		<input type="hidden" id='calc_precio_m_2' name='precio_m_2' value='0' />	
		<input type="hidden" id='calc_precio_m_2_ancho_rollo' name='precio_m_2_ancho_rollo' value='0' />	
		<input type="hidden" id='calc_precio_m2_fieltro' name='precio_m_2_fieltro' value='0' />	
		<div id='dimensiones_cuadrada' class="row" >
			<p class="col-12">Introduce las dimensiones necesarias en metros, ej: 3.8 x 2.5</p>
			<div class="col-6">
				<div class="pr-15">
				  <label for="p_ancho"><?php echo $txt_p_ancho; ?></label>
				  <div class="">
				    <div class="">
				      <input type="number" min="0" step="0.1" id="p_ancho" name="p_ancho" class="w-75 metrs calcuinput" oninput="calcularSantosMonteiro();" /> m
				    </div>
				  </div>
				</div>
			</div>
			<div class="col-6">
				<div class="">
				  <label for="p_alto"><?php echo $txt_p_alto; ?></label>
				  <div class="">
				    <div class="">
				      <input type="number" min="0" step="0.1" id="p_alto" name="p_alto" class="w-75" oninput="calcularSantosMonteiro();" /> m
				    </div>
				  </div>
				</div>
			</div>
		</div>
		<div id='dimensiones_redonda' class="row d-none" >
			<p class="col-12">Introduce el diámetro de la alfombra, ej: 1.8</p>
			<div class="col-6">
				<div class="pr-15">
				  <label for="p_diametro">Diámetro en metros (max. <?php echo str_replace('.', ',', $ancho_2); ?>m)</label>
				  <div class="">
				    <div class="">
				      <input type="number" min="0" step="0.1" id="p_diametro" name="p_diametro" class="w-75 metrs calcuinput" oninput="calcularSantosMonteiro();" /> m
				    </div>
				  </div>
				</div>
			</div>
		</div>
		<div id='dimensiones_rollo' class="row d-none" >
			<p class="col-12">Introduce el ancho del rollo y la longitud</p>
			<div class="col-6">
				<div class="pr-15">
				  <label for="ancho_rollo">Ancho rollo</label>
				  <div class="">
				    <div class="mt-2">
						<input type="radio" id="val_2" name="ancho_rollo" value="<?php echo $ancho_1; ?>" onclick="calcularSantosMonteiro();" />
						<label for="val_2" class="mr-4"><?php echo str_replace('.', ',', $ancho_1); ?> metros</label>
						<input type="radio" id="val_4" name="ancho_rollo" value="<?php echo $ancho_2; ?>" onclick="calcularSantosMonteiro();" />
						<label for="val_4"><?php echo str_replace('.', ',', $ancho_2); ?> metros</label>
						<?php
						/*
						<input type="number" min="0" step="0.1" id="ancho_rollo" name="ancho_rollo" class="w-75 metrs calcuinput" oninput="calcularSantosMonteiro();" /> m
						*/
						?>
				    </div>
				  </div>
				</div>
			</div>
			<div class="col-6">
				<div class="">
				  <label for="alto_rollo">Largo rollo</label>
				  <div class="">
				    <div class="">
				      <input type="number" min="0" step="0.1" id="alto_rollo" name="alto_rollo" class="w-75" oninput="calcularSantosMonteiro();" /> m
				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>
	<div id='nota_dimensiones_cuadrada' class="mt-4">
		<small><strong>Se confeccionan a partir de rollos de <?php echo str_replace('.', ',', $ancho_1); ?> ó <?php echo str_replace('.', ',', $ancho_2); ?> metros de ancho en función de la medida final solicitada considerando siempre el mínimo desperdicio de material posible sin tener en cuenta el sentido de tramas o dibujos.</strong></small>
	</div>
    <?php 
    $this->load->view('frontend/info_opc_seleccionadas'); 
    ?>

</div>

<script>
<!--
function calcularSantosMonteiro_dos_calculos(){
	// Vamos a calcular el precio de la alfombra de dos maneras: 
	// 	1.- a partir del rollo + los precios de los metros lineales
	// 	2.- a partir de los precios de los metros cuadrados con ela cabado incluido
	forma_seleccionada=$("#informacion_extra_forma").val();

	faltan_datos=true;
    if (forma_seleccionada=='Redonda'){
	    if(isNumeric($("#p_diametro").val()) && isNumeric($("#unidades").val())){
	    	// Para el cálculo de metros tomamos el cuadrado de la pieza que forma el círculo, por lo que alto=ancho=diametro
		    p_ancho= $("#p_diametro").val().replace(",",".");
		    p_alto= $("#p_diametro").val().replace(",",".");
		    
		    p_ancho=Math.ceil(p_ancho*10)/10;
		    p_alto=Math.ceil(p_alto*10)/10;

			perimetro=p_ancho*3.1416; // 2 PI r, el ancho es igual al diametro= 2*r
		    perimetro=Math.ceil(perimetro*10)/10;
			lado_largo=0;
			lado_corto=0;

	        console.log("Redonda");
	        console.log("Diámetro: "+p_ancho+" - Perimetro: "+perimetro);
			
			faltan_datos=false;
		}
	}
    if (forma_seleccionada=='Rollo'){
        ancho_rollo_seleccionado=$('input[name="ancho_rollo"]:checked').val();
        
	    if(isNumeric(ancho_rollo_seleccionado) && isNumeric($("#alto_rollo").val()) && isNumeric($("#unidades").val())){
	    	// Para el cálculo de metros tomamos el cuadrado de la pieza que forma el círculo, por lo que alto=ancho=diametro
		    p_ancho= ancho_rollo_seleccionado.replace(",",".");
		    p_alto= $("#alto_rollo").val().replace(",",".");
		    
		    p_ancho=Math.ceil(p_ancho*10)/10;
		    p_alto=Math.ceil(p_alto*10)/10;

			perimetro=0; // Es rollo, no va a tener acabado en el perímetro
			lado_largo=0;
			lado_corto=0;
	        console.log("Rollo");
	        console.log("Ancho: "+p_ancho+" - Largo: "+p_alto);
			faltan_datos=false;
		}
	}
    if (forma_seleccionada=='Rectangular-cuadrada'){
	    if(isNumeric($("#p_ancho").val()) && isNumeric($("#p_alto").val()) && isNumeric($("#unidades").val())){
		    p_ancho= $("#p_ancho").val().replace(",",".");
		    p_alto= $("#p_alto").val().replace(",",".");
		    
		    p_ancho=Math.ceil(p_ancho*10)/10;
		    p_alto=Math.ceil(p_alto*10)/10;

			lado_largo=p_alto;
			lado_corto=p_ancho;
			if (p_ancho>p_alto){
				lado_largo=p_ancho;
				lado_corto=p_alto;
			}

			perimetro=p_ancho*2 + p_alto*2;

	        console.log("Cuadrada");
	        console.log("Ancho: "+p_ancho+" - Largo: "+p_alto);
			faltan_datos=false;
		}
	}
	if (faltan_datos){
		return;
	}
	else{
		// Precios de la base para el metro cuadrado a medida
		preciobase= parseFloat($("#preciobase").val()); // precio original`
		preciounitario= parseFloat($("#preciounitario").val()); // con descuento

		// Precios de la base para el cálculo a partir del rollo
		preciobase_aux= parseFloat($("#preciobase_aux").val()); // precio original`
		preciounitario_aux= parseFloat($("#preciounitario_aux").val()); // con descuento


	    precio_m_2= $("#calc_precio_m_2").val()*1;
	    precio_m_2_ancho_rollo= $("#calc_precio_m_2_ancho_rollo").val()*1;

	    precio_m_lineal= $("#calc_precio_m_lineal").val()*1;
	    precio_m_lineal_largo= $("#calc_precio_m_lineal_largo").val()*1;
	    precio_m_2_fieltro= $("#calc_precio_m2_fieltro").val()*1;

	    if (precio_m_2!=0)
	        console.log("m2 acabado: "+precio_m_2);
	    if (precio_m_2_ancho_rollo!=0)
	        console.log("m2 acabado ancho rollo: "+precio_m_2_ancho_rollo);
	    if (precio_m_2_fieltro!=0)
	        console.log("fieltro m2: "+precio_m_2_fieltro);
	    if (precio_m_lineal!=0)
	        console.log("precio m lineal: "+precio_m_lineal);
	    if (precio_m_lineal_largo!=0)
	        console.log("precio m lineal largo: "+precio_m_lineal_largo);

	    unidades= $("#unidades").val()*1;

		//Si hay descuentos, tenemos que aplicarlos también a los acabados
	    metodo_descuento= $("#metodo_descuento").val();
	    valor_descuento= $("#valor_descuento").val();
		
		// Inicio precios a medida
		metros_pieza_exactos=p_alto*p_ancho;

		precio_acabado_a_medida=precio_m_2+precio_m_2_extra;
		if(precio_m_2_promo!=0)
			precio_acabado_a_medida=precio_m_2_promo;
	    
	    precio_alfombra_original_a_medida=metros_pieza_exactos*preciobase + metros_pieza_exactos*precio_acabado_a_medida;		
	    precio_alfombra_final_a_medida=metros_pieza_exactos*preciounitario + metros_pieza_exactos*precio_acabado_a_medida;		
		if (metodo_descuento==1){
            precio_alfombra_final_a_medida=precio_alfombra_original_a_medida*(100 - valor_descuento)/100;
		}
		/*
        if (p_ancho>=3 && p_alto>=3){
        	// Si las dimensiones exceden de 3 metros (incluidos)
	        //console.log("sumar 50 a " +precio_alfombra_final);
	        console.log("precio_alfombra_final_a_medida: "+precio_alfombra_final_a_medida);
	        precio_alfombra_final_a_medida+=50;
	        console.log("precio_alfombra_final_a_medida: "+precio_alfombra_final_a_medida);
        }
		*/
        console.log("metros_pieza_exactos: "+metros_pieza_exactos);
        console.log("precio m2 sin acabado: "+preciobase +' --> '+preciounitario);
        console.log("precio alfombra a medida: "+precio_alfombra_original_a_medida.toFixed(2) +' --> '+precio_alfombra_final_a_medida.toFixed(2));
		// Fin precios a medida

        console.log("lado corto: "+lado_corto);
        console.log("lado largo: "+lado_largo);

		// Inicio precios desde rollos
		metros_pieza=0;
		precio_alfombra_original_rollo=0;
		precio_alfombra_final_rollo=0;

		ancho_referencia_1=<?php echo $ancho_1; ?>;// 2 por defecto
		ancho_referencia_2=<?php echo $ancho_2; ?>;// 4 por defecto

        console.log("opciones rollos: "+ancho_referencia_1+" y "+ancho_referencia_2);
        console.log("precio m2 desde rollo: "+preciobase_aux+' --> '+preciounitario_aux);
				
		//if(p_ancho<=4){
		if(p_ancho<=ancho_referencia_2){
			//if (p_ancho>2)
			if (p_ancho>ancho_referencia_1){
				metros_pieza=p_alto*ancho_referencia_2;
				//metros_pieza=p_alto*4;
			}
			else{
				metros_pieza=p_alto*ancho_referencia_1;
				//metros_pieza=p_alto*2;
			}
	        console.log("metros cálculo 1: "+metros_pieza);
		    
		    if ($("#acabado_seleccionado").text()=='FRANJA' && lado_corto>0){
		    	// Si acabado es franja, no se aplica a ttodo el perímetro, solo al lado corto. Lado largo, LINE
			    precio_alfombra_original_rollo=metros_pieza*preciobase_aux + lado_corto*2*precio_m_lineal + lado_largo*2*precio_m_lineal_largo;		
			    precio_alfombra_final_rollo=metros_pieza*preciounitario_aux + lado_corto*2*precio_m_lineal + lado_largo*2*precio_m_lineal_largo;	
		        console.log("precio_alfombra_original: "+ (metros_pieza*preciobase_aux));
		        console.log("lado corto: "+ (lado_corto*2*precio_m_lineal));
		        console.log("lado largo: "+ (lado_largo*2*precio_m_lineal_largo));
		        console.log("precio final original: "+ precio_alfombra_original_rollo);
		    }
		    else{
			    precio_alfombra_original_rollo=metros_pieza*preciobase_aux + perimetro*precio_m_lineal + metros_pieza*precio_m_2_fieltro;		
			    precio_alfombra_final_rollo=metros_pieza*preciounitario_aux + perimetro*precio_m_lineal + metros_pieza*precio_m_2_fieltro;
			}
			if (metodo_descuento==1){
	            precio_alfombra_final_rollo=precio_alfombra_original_rollo*(100 - valor_descuento)/100;
		        //console.log("valor_descuento: "+ valor_descuento);
		        //console.log("precio final descuento: "+ precio_alfombra_final_rollo);
			}
		
	        //console.log("precio alfombra rollo cálculo 1: "+precio_alfombra_original_rollo +' --> '+precio_alfombra_final_rollo);

		}

		metros_pieza_2=0;
		precio_alfombra_original_rollo_2=0;
		precio_alfombra_final_rollo_2=0;
		//if(p_alto<=4){
		if(p_alto<=ancho_referencia_2){
			//if (p_alto>2)
			if (p_alto>ancho_referencia_1){
				metros_pieza_2=p_ancho*ancho_referencia_2;
			}
			else{
				metros_pieza_2=p_ancho*ancho_referencia_1;
			}
	        console.log("metros cálculo 2: "+metros_pieza_2);

		    if ($("#acabado_seleccionado").text()=='FRANJA' && lado_corto>0){
		    	// Si acabado es franja, no se aplica a ttodo el perímetro, solo al lado corto. Lado largo, LINE
			    precio_alfombra_original_rollo_2=metros_pieza_2*preciobase_aux + lado_corto*2*precio_m_lineal + lado_largo*2*precio_m_lineal_largo;		
			    precio_alfombra_final_rollo_2=metros_pieza_2*preciounitario_aux + lado_corto*2*precio_m_lineal + lado_largo*2*precio_m_lineal_largo;	
		        console.log("precio_alfombra_original 2: "+ (metros_pieza_2*preciobase_aux));
		        console.log("lado corto: "+ (lado_corto*2*precio_m_lineal));
		        console.log("lado largo: "+ (lado_largo*2*precio_m_lineal_largo));
		        console.log("precio final original 2: "+ precio_alfombra_original_rollo_2);
		    }
		    else{
			    precio_alfombra_original_rollo_2=metros_pieza_2*preciobase_aux + perimetro*precio_m_lineal + metros_pieza_2*precio_m_2_fieltro;		
			    precio_alfombra_final_rollo_2=metros_pieza_2*preciounitario_aux + perimetro*precio_m_lineal + metros_pieza_2*precio_m_2_fieltro;		
			}
			if (metodo_descuento==1){
	            precio_alfombra_final_rollo_2=precio_alfombra_original_rollo_2*(100 - valor_descuento)/100;
		        //console.log("valor_descuento: "+ valor_descuento);
		        //console.log("precio final descuento 2: "+ precio_alfombra_final_rollo_2);
			}
	        //console.log("precio alfombra rollo cálculo 1: "+precio_alfombra_original_rollo_2 +' --> '+precio_alfombra_final_rollo_2);
		}
		// Fin precios desde rollos

		// Inicio seleccion precio más barato, marcaremos;
		// 	SD si es a medida (Sin Desperdicio)
		// 	CD si es desde rollo (Con Desperdicio)
    	precio_alfombra_original=precio_alfombra_original_a_medida;
	    if(precio_alfombra_original_rollo < precio_alfombra_original && precio_alfombra_original_rollo!=0){
		    precio_alfombra_original=precio_alfombra_original_rollo;
	    }
	    if(precio_alfombra_original_rollo_2 < precio_alfombra_original && precio_alfombra_original_rollo_2!=0){
		    precio_alfombra_original=precio_alfombra_original_rollo_2;
	    }
		
	    informacion_extra_desperdicio='SD'; // Sin desperdicio, corte a medida
	    precio_alfombra_final=precio_alfombra_final_a_medida;
	    if(precio_alfombra_final_rollo < precio_alfombra_final && precio_alfombra_final_rollo!=0){
		    precio_alfombra_final=precio_alfombra_final_rollo;
		    informacion_extra_desperdicio='CD'; // Con desperdicio, corte a partir de rollos
	    }
	    if(precio_alfombra_final_rollo_2 < precio_alfombra_final && precio_alfombra_final_rollo_2!=0){
		    precio_alfombra_final=precio_alfombra_final_rollo_2;
		    informacion_extra_desperdicio='CD'; // Con desperdicio, corte a partir de rollos
	    }
		// Fin seleccion precio más barato, marcaremos;

	    //alert('ancho: '+p_ancho+' alto: '+p_alto+' unidades: '+unidades+'\n'+'metros_pieza: '+metros_pieza+' perimetro: '+perimetro+'\n'+'precio ml: '+precio_m_lineal+' precio_m_2: '+precio_m_2);
	    /*
        console.log("precio_acabado_a_medida: "+precio_acabado_a_medida);
        console.log("precio original a medida: "+precio_alfombra_original_a_medida.toFixed(2));
        console.log("precio_m_lineal: "+precio_m_lineal);
        console.log("precio_m_2_fieltro: "+precio_m_2_fieltro);
        console.log("precio original rollo: "+precio_alfombra_original_rollo.toFixed(2));
		*/
        //console.log("metros_pieza_exactos: "+metros_pieza_exactos);
        //console.log("metros_pieza_1: "+metros_pieza+" metros_pieza_2: "+metros_pieza_2);
        console.log("precio final a medida: "+precio_alfombra_final_a_medida.toFixed(2));
        console.log("precio final rollo 1 ( "+p_ancho+" x "+p_alto+" ): "+precio_alfombra_original_rollo.toFixed(2)+" --> "+precio_alfombra_final_rollo.toFixed(2));
        console.log("precio final rollo 2 ( "+p_alto+" x "+p_ancho+" ): "+precio_alfombra_original_rollo_2.toFixed(2)+" --> "+precio_alfombra_final_rollo_2.toFixed(2));


		precio_extra_neto_dimensiones_alfombra=25;
		precio_extra_bruto_dimensiones_alfombra=25;

		// Para la colección Artisan, basta con que uno de los lados sea de 3 metros para sumar los portes por tamaño
		if((p_ancho>=3 || p_alto>=3) && <?php echo $key['item_coleccion_id']; ?>=='1788'){
			precio_extra_neto_dimensiones_alfombra=50;
			precio_extra_bruto_dimensiones_alfombra=50;
	        console.log("sumar 50 (artisan) a " +precio_alfombra_final);
	        //precio_alfombra_final+=precio_extra_neto_dimensiones_alfombra;
	        //precio_alfombra_original+=precio_extra_bruto_dimensiones_alfombra;
		}
		else if (p_ancho>=3 && p_alto>=3){
        	// Si las dimensiones exceden de 3 metros (incluidos)
			precio_extra_neto_dimensiones_alfombra=50;
			precio_extra_bruto_dimensiones_alfombra=50;
	        console.log("sumar 50 a " +precio_alfombra_final);
	        //precio_alfombra_final+=precio_extra_neto_dimensiones_alfombra;
	        //precio_alfombra_original+=precio_extra_bruto_dimensiones_alfombra;
        }
        else{
	        console.log("sumar 25 a " +precio_alfombra_final);
        }
		//Si tiene descuento hay que añadir el porcentaje para que el extra siempre quede en el porte neto
		if (metodo_descuento==1){
            precio_extra_bruto_dimensiones_alfombra=precio_extra_neto_dimensiones_alfombra*100/(100 - valor_descuento);
		}

        precio_alfombra_final+=precio_extra_neto_dimensiones_alfombra;
        precio_alfombra_original+=precio_extra_bruto_dimensiones_alfombra;
        
        console.log("precio final seleccionado( "+p_ancho+" x "+p_alto+" "+informacion_extra_desperdicio+"): "+precio_alfombra_final.toFixed(2));
        
		/*
	    alert(	'Precio final a medida: '+precio_alfombra_final_a_medida+'\n'+
	    		'Precio final a rollo ('+p_ancho+" x "+p_alto+'): '+precio_alfombra_final_rollo.toFixed(2)+'\n'+
	    		'Precio final a rollo ('+p_alto+" x "+p_ancho+'): '+precio_alfombra_final_rollo_2.toFixed(2));
		*/
		$("#total-current-price").html(parseFloat(precio_alfombra_final*unidades).toFixed(2).replace('.', ',')+" €");
		$("#total-regular-price").html(parseFloat(precio_alfombra_original*unidades).toFixed(2).replace('.', ',')+" €");
	   
	    $("#precio_unitario_final").val(parseFloat(precio_alfombra_final).toFixed(2));
	    $("#precio_unitario_final_sin_desc").val(parseFloat(precio_alfombra_original).toFixed(2));

	    $("#informacion_extra_desperdicio").val(informacion_extra_desperdicio);
	}
}

function calcularSantosMonteiro(){
	forma_seleccionada=$("#informacion_extra_forma").val();

	faltan_datos=true;
    if (forma_seleccionada=='Redonda'){
	    if(isNumeric($("#p_diametro").val()) && isNumeric($("#unidades").val())){
	    	// Para el cálculo de metros tomamos el cuadrado de la pieza que forma el círculo, por lo que alto=ancho=diametro
		    p_ancho= $("#p_diametro").val().replace(",",".");
		    p_alto= $("#p_diametro").val().replace(",",".");
		    
		    p_ancho=Math.ceil(p_ancho*10)/10;
		    p_alto=Math.ceil(p_alto*10)/10;

			perimetro=p_ancho*3.1416; // 2 PI r, el ancho es igual al diametro= 2*r
		    perimetro=Math.ceil(perimetro*10)/10;
			lado_largo=0;
			lado_corto=0;

	        console.log("Redonda");
	        console.log("Diámetro: "+p_ancho+" - Perimetro: "+perimetro);
			
			faltan_datos=false;
		}
	}
    if (forma_seleccionada=='Rollo'){
        ancho_rollo_seleccionado=$('input[name="ancho_rollo"]:checked').val();
        
	    if(isNumeric(ancho_rollo_seleccionado) && isNumeric($("#alto_rollo").val()) && isNumeric($("#unidades").val())){
	    	// Para el cálculo de metros tomamos el cuadrado de la pieza que forma el círculo, por lo que alto=ancho=diametro
		    p_ancho= ancho_rollo_seleccionado.replace(",",".");
		    p_alto= $("#alto_rollo").val().replace(",",".");
		    
		    p_ancho=Math.ceil(p_ancho*10)/10;
		    p_alto=Math.ceil(p_alto*10)/10;

			perimetro=0; // Es rollo, no va a tener acabado en el perímetro
			lado_largo=0;
			lado_corto=0;
	        console.log("Rollo");
	        console.log("Ancho: "+p_ancho+" - Largo: "+p_alto);
			faltan_datos=false;
		}
	}
    if (forma_seleccionada=='Rectangular-cuadrada'){
	    if(isNumeric($("#p_ancho").val()) && isNumeric($("#p_alto").val()) && isNumeric($("#unidades").val())){
		    p_ancho= $("#p_ancho").val().replace(",",".");
		    p_alto= $("#p_alto").val().replace(",",".");
		    
		    p_ancho=Math.ceil(p_ancho*10)/10;
		    p_alto=Math.ceil(p_alto*10)/10;

			lado_largo=p_alto;
			lado_corto=p_ancho;
			if (p_ancho>p_alto){
				lado_largo=p_ancho;
				lado_corto=p_alto;
			}

			perimetro=p_ancho*2 + p_alto*2;

	        console.log("Cuadrada");
	        console.log("Ancho: "+p_ancho+" - Largo: "+p_alto);
			faltan_datos=false;
		}
	}
	if (faltan_datos){
		return;
	}
	else{
		// Precios de la base para el metro cuadrado a medida
		preciobase= parseFloat($("#preciobase").val()); // precio original`
		preciounitario= parseFloat($("#preciounitario").val()); // con descuento

		// Precios de la base para el cálculo a partir del rollo
		preciobase_aux= parseFloat($("#preciobase_aux").val()); // precio original`
		preciounitario_aux= parseFloat($("#preciounitario_aux").val()); // con descuento


	    precio_m_2= $("#calc_precio_m_2").val()*1;
	    precio_m_2_ancho_rollo= $("#calc_precio_m_2_ancho_rollo").val()*1;

	    precio_m_lineal= $("#calc_precio_m_lineal").val()*1;
	    precio_m_lineal_largo= $("#calc_precio_m_lineal_largo").val()*1;
	    precio_m_2_fieltro= $("#calc_precio_m2_fieltro").val()*1;

	    if (precio_m_2!=0)
	        console.log("m2 acabado: "+precio_m_2);
	    if (precio_m_2_ancho_rollo!=0)
	        console.log("m2 acabado ancho rollo: "+precio_m_2_ancho_rollo);

		ancho_ref_1=<?php echo $ancho_1; ?>;// 2 por defecto
		ancho_ref_2=<?php echo $ancho_2; ?>;// 4 por defecto

	    precio_referencia=precio_m_2;
	    if (lado_largo==ancho_ref_1 || lado_corto==ancho_ref_1 || lado_largo==ancho_ref_2 || lado_corto==ancho_ref_2)
		    precio_referencia=precio_m_2_ancho_rollo;

	    unidades= $("#unidades").val()*1;

		//Si hay descuentos, tenemos que aplicarlos también a los acabados
	    metodo_descuento= $("#metodo_descuento").val();
	    valor_descuento= $("#valor_descuento").val();
		
		// Inicio precios a medida
		metros_pieza_exactos=p_alto*p_ancho;

	    if (precio_m_2_fieltro!=0)
	        console.log("fieltro m2: "+precio_m_2_fieltro);
	    if (precio_m_lineal!=0)
	        console.log("precio m lineal: "+precio_m_lineal);
	    if (precio_m_lineal_largo!=0)
	        console.log("precio m lineal largo: "+precio_m_lineal_largo);

	    
        console.log("lado corto: "+lado_corto);
        console.log("lado largo: "+lado_largo);
        console.log("metros_pieza_exactos: "+metros_pieza_exactos);
        console.log("perímetro: "+perimetro);
        console.log("precio m2: "+precio_referencia);
	    
	    precio_alfombra_original_a_medida=metros_pieza_exactos*precio_referencia;	
	    precio_alfombra_final_a_medida=metros_pieza_exactos*precio_referencia;	

        console.log("precio alfombra sin descuento: "+precio_alfombra_original_a_medida.toFixed(2));
		if (metodo_descuento==1){
            precio_alfombra_final_a_medida=precio_alfombra_original_a_medida*(100 - valor_descuento)/100;
	        console.log("precio alfombra con descuento: "+precio_alfombra_final_a_medida.toFixed(2));
		}
        
        /*
	    if ($("#acabado_seleccionado").text()=='FRANJA' && lado_corto>0){
	    	// Si acabado es franja, no se aplica a ttodo el perímetro, solo al lado corto. Lado largo, LINE
	    	precio_acabado=lado_corto*2*precio_m_lineal + lado_largo*2*precio_m_lineal_largo;	
	        console.log("lado corto (franja): "+ (lado_corto*2*precio_m_lineal));
	        console.log("lado largo (line): "+ (lado_largo*2*precio_m_lineal_largo));
	        console.log("precio_acabado lineal: "+precio_acabado);

		    precio_alfombra_original_a_medida+=precio_acabado;		
		    precio_alfombra_final_a_medida+=precio_acabado;		
	    }
	    else{
	    	precio_acabado=perimetro*precio_m_lineal + metros_pieza_exactos*precio_m_2_fieltro;
	        console.log("precio_acabado lineal: "+precio_acabado);

		    precio_alfombra_original_a_medida+=precio_acabado;		
		    precio_alfombra_final_a_medida+=precio_acabado;		
		}
		*/

    	precio_alfombra_original=precio_alfombra_original_a_medida;
	    precio_alfombra_final=precio_alfombra_final_a_medida;

        // QUITAMOS PORTES CON EL NUEVO CALCULO
		precio_extra_neto_dimensiones_alfombra=0;
		precio_extra_bruto_dimensiones_alfombra=0;

        precio_alfombra_final+=precio_extra_neto_dimensiones_alfombra;
        precio_alfombra_original+=precio_extra_bruto_dimensiones_alfombra;
        
		$("#total-current-price").html(parseFloat(precio_alfombra_final*unidades).toFixed(2).replace('.', ',')+" €");
		$("#total-regular-price").html(parseFloat(precio_alfombra_original*unidades).toFixed(2).replace('.', ',')+" €");
	   
	    $("#precio_unitario_final").val(parseFloat(precio_alfombra_final).toFixed(2));
	    $("#precio_unitario_final_sin_desc").val(parseFloat(precio_alfombra_original).toFixed(2));
	}
}
-->
</script>


