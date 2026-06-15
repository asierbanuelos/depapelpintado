<?php
// 4: alfombras
// 1930: marca KP -> SPART
// 1931: marca KP -> SPARTWO
$a_forma_alfombra[4][1930]['RECTANGULAR CUADRADA']['img']='/includes/images/acabados/rectangular-cuadrada.jpg';
$a_forma_alfombra[4][1930]['REDONDA']['img']='/includes/images/acabados/redonda.jpg';

$a_opciones[1930]['REDONDA']['S']='1,50';
$a_opciones[1930]['REDONDA']['M']='2';
$a_opciones[1930]['REDONDA']['L']='2,50';

$a_precios[1930]['REDONDA']['S']='324';
$a_precios[1930]['REDONDA']['M']='576';
$a_precios[1930]['REDONDA']['L']='900';


$a_forma_alfombra[4][1931]['RECTANGULAR CUADRADA']['img']='/includes/images/acabados/rectangular-cuadrada.jpg';
$a_forma_alfombra[4][1931]['REDONDA']['img']='/includes/images/acabados/redonda.jpg';

$a_opciones[1931]['REDONDA']['S']='1,80';
$a_opciones[1931]['REDONDA']['M']='2,30';

$a_precios[1931]['REDONDA']['S']='540';
$a_precios[1931]['REDONDA']['M']='888';

if (isset($a_forma_alfombra[4][$key['item_coleccion_id']])){
	echo '<div class="row">';
	echo '  <div class="h6 destacado mt-3 mb-3 col-11">SELECCIONE LA FORMA: <span id="forma_seleccionada"></span></div>';
	echo '</div>';

	echo '<div class="" id="lista-opciones-formas">';
	echo '<ul class="opciones-grecas row p-0">';
	foreach ($a_forma_alfombra[4][$key['item_coleccion_id']] as $txt_forma=>$datos_forma){
		$nombre=$txt_forma;
		$src=$datos_forma['img'];
		/*
		if (isset($a_opciones[$key['item_coleccion_id']][$txt_forma])){
			foreach ($a_opciones[$key['item_coleccion_id']][$txt_forma] as $tamano=>$txt_tamano){
				echo '<li class="item-opcion-greca col-3 col-lg-2">';
				echo '  <div class="img-opcion-greca">';
				echo '    <img title="'.$nombre.' '.$tamano.' '.$txt_tamano.'" alt="'.$nombre.' '.$tamano.' '.$txt_tamano.'" class="img-forma-kp" data-name-forma="'.$nombre.'" src="'.$src.'"/>';
				echo '    <p class="name-opcion-greca text-center">'.$tamano.' - '.$txt_tamano.'</p>';
				echo '  </div>';
				echo '</li>';
			}

		}
		*/
		echo '<li class="item-opcion-greca col-3 col-lg-2">';
		echo '  <div class="img-opcion-greca">';
		echo '    <img title="'.$nombre.'" alt="'.$nombre.'" class="img-forma-variantes" data-name-forma="'.$nombre.'" src="'.$src.'"/>';
		//echo '    <p class="name-opcion-greca text-center">'.$nombre.'</p>';
		echo '  </div>';
		echo '</li>';
	}
	echo '</ul>';
	echo '</div>';
}

$txt_caja='Introduce las medidas de tu alfombra:';
$txt_p_ancho='Ancho en metros';
$txt_p_alto='Largo en metros';
?>
<div class="product-detail-calculadora-rollo ">
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
		<input type="hidden" id='p_diametro' name='p_diametro' value='' />	
		<div id='dimensiones_cuadrada' class="row" >
			<p class="col-12">Introduce las dimensiones necesarias en metros, ej: 3.8 x 2.5</p>
			<div class="col-6">
				<div class="pr-15">
				  <label for="p_alto"><?php echo $txt_p_ancho; ?></label>
				  <div class="">
				    <div class="">
				      <input type="number" min="0" step="0.1" id="p_ancho" name="p_ancho" class="w-75 metrs calcuinput" oninput="calcularVariante();" /> m
				    </div>
				  </div>
				</div>
			</div>
			<div class="col-6">
				<div class="">
				  <label for="p_alto"><?php echo $txt_p_alto; ?></label>
				  <div class="">
				    <div class="">
				      <input type="number" min="0" step="0.1" id="p_alto" name="p_alto" class="w-75" oninput="calcularVariante();" /> m
				    </div>
				  </div>
				</div>
			</div>
		</div>
		<div id='dimensiones_redonda' class="row d-none" >
			<p class="col-12">Selecciona el diámetro de la alfombra</p>
			<div class="col-6">
				<div class="pr-15">
				  <div class="">
				    <div class="">
				    	<?php
						if (isset($a_opciones[$key['item_coleccion_id']]['REDONDA'])){
							foreach ($a_opciones[$key['item_coleccion_id']]['REDONDA'] as $tamano=>$txt_tamano){
								$precio=$a_precios[$key['item_coleccion_id']]['REDONDA'][$tamano];
								
								//echo '<input type="radio" id="val_'.$tamano.'" name="p_diametro" value="'.$txt_tamano.'" data-precio-redonda="'.$precio.'" onclick="calcularVariante();" />';
								echo '<input type="radio" id="val_'.$tamano.'" name="precio_variante" value="'.$precio.'" data-tamano-variante="'.$txt_tamano.'" onclick="calcularVariante();" />';
								echo ' <label for="val_'.$tamano.'" class="mr-4">'.$txt_tamano.'m</label>';
							}
						}
						?>
				    </div>
				  </div>
				</div>
			</div>
		</div>
	</div>

	<div id='nota_dimensiones_cuadrada' class="mt-4">
		<?php
		/*
		<small><strong>Se confeccionan a partir de rollos de 2 ó 4 metros de ancho en función de la medida final solicitada considerando siempre el mínimo desperdicio de material posible sin tener en cuenta el sentido de tramas o dibujos.</strong></small>
		*/
		?>
		<small><strong>Las medidas introducidas se ajustarán automáticamente a las exigencias del fabricante. Consultanos otras opciones</strong></small>
	</div>
    <?php 
    //$this->load->view('frontend/info_opc_seleccionadas'); 
    ?>

</div>

<script>
<!--
function calcularVariante(){

	forma_seleccionada=$("#informacion_extra_forma").val();
    console.log(forma_seleccionada);

	faltan_datos=true;
	precio_variante=0;
    if (forma_seleccionada=='Redonda'){
        precio_variante=$('input[name="precio_variante"]:checked').val();

	    console.log('Precio: '+precio_variante);
	    if(isNumeric(precio_variante) && isNumeric($("#unidades").val())){
			diametro=$('input[name="precio_variante"]:checked').attr("data-tamano-variante");

	        $("#p_diametro").val(diametro.replace(",","."));
	        
			faltan_datos=false;
		}
	}
    if (forma_seleccionada=='Rectangular-cuadrada'){
        //console.log("Cuadrada");
	    if(isNumeric($("#p_ancho").val()) && isNumeric($("#p_alto").val()) && isNumeric($("#unidades").val())){
		    p_ancho= $("#p_ancho").val().replace(",",".");
		    p_alto= $("#p_alto").val().replace(",",".");
		    
		    p_ancho=Math.ceil(p_ancho*10)/10;
		    p_alto=Math.ceil(p_alto*10)/10;

	        //console.log("Ancho: "+p_ancho+" - Largo: "+p_alto);
			faltan_datos=false;
		}
	}
	if (faltan_datos){
		return;
	}
	else{
	    unidades= $("#unidades").val();

		//Si hay descuentos, tenemos que aplicarlos también a los acabados
	    metodo_descuento= $("#metodo_descuento").val();
	    valor_descuento= $("#valor_descuento").val();

	    if (forma_seleccionada=='Redonda'){
			precio_alfombra_final= parseFloat(precio_variante); // precio original`
			precio_alfombra_original= parseFloat(precio_variante); // con descuento
			
			if (metodo_descuento==1){
	            precio_alfombra_final=precio_alfombra_original*(100 - valor_descuento)/100;
		        //console.log("valor_descuento: "+ valor_descuento);
		        //console.log("precio final descuento: "+ precio_alfombra_final);
			}
	    }
	    else{
			preciobase= parseFloat($("#preciobase").val()); // precio original`
			preciounitario= parseFloat($("#preciounitario").val()); // con descuento

	        //console.log("preciobase: "+ preciobase);
	        //console.log("preciounitario: "+ preciounitario);

			metros_pieza=p_ancho*p_alto;
			
			precio_alfombra_original=metros_pieza*preciobase;		
			precio_alfombra_final=metros_pieza*preciounitario;
	    }

		precio_extra_neto_dimensiones_alfombra=25;
		precio_extra_bruto_dimensiones_alfombra=25;
        if (p_ancho>=3 && p_alto>=3){
        	// Si las dimensiones exceden de 3 metros (incluidos)
			precio_extra_neto_dimensiones_alfombra=50;
			precio_extra_bruto_dimensiones_alfombra=50;
	        console.log("sumar 50 a " +precio_alfombra_final);
	        //precio_alfombra_final+=precio_extra_neto_dimensiones_alfombra;
	        //precio_alfombra_original+=precio_extra_bruto_dimensiones_alfombra;
        }

		//Si tiene descuento hay que añadir el porcentaje para que el extra siempre quede en 50 euros netos
		if (metodo_descuento==1){
            precio_extra_bruto_dimensiones_alfombra=precio_extra_neto_dimensiones_alfombra*100/(100 - valor_descuento);
		}

        precio_alfombra_final+=precio_extra_neto_dimensiones_alfombra;
        precio_alfombra_original+=precio_extra_bruto_dimensiones_alfombra;

		$("#total-current-price").html(parseFloat(precio_alfombra_final*unidades).toFixed(2).replace('.', ',')+" €");
		$("#total-regular-price").html(parseFloat(precio_alfombra_original*unidades).toFixed(2).replace('.', ',')+" €");
	   
		if ($("#ficha-total-price").length) {
			$("#ficha-total-price").html($("#total-current-price").html());
		}
		if ($("#ficha-total-price-base").length) {
			$("#ficha-total-price-base").html($("#total-regular-price").html());
		}
	    $("#precio_unitario_final").val(parseFloat(precio_alfombra_final).toFixed(2));
	    $("#precio_unitario_final_sin_desc").val(parseFloat(precio_alfombra_original).toFixed(2));

	}	
  }

-->
</script>

