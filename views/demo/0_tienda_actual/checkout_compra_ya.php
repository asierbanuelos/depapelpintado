<?php $this->load->view('frontend/header'); 
$t=substr(time(),-4);
$this->load->library("Redsys");
$version="HMAC_SHA256_V1";
$tpvid="058976879";
if (isset($prueba)&& $prueba){
	$tpvurl="https://sis-t.redsys.es:25443/sis/realizarPago";
	$key=REDSYS_DEVKEY;
}
else{
	$tpvurl="https://sis.redsys.es/sis/realizarPago";
	$key=REDSYS_KEY;
}
$miObj=new Redsys;
$miObj->setParameter("DS_MERCHANT_AMOUNT",$total*100);
$miObj->setParameter("DS_MERCHANT_ORDER",$t.$order_number);
$miObj->setParameter("DS_MERCHANT_MERCHANTCODE",$tpvid);
$miObj->setParameter("DS_MERCHANT_CURRENCY","978");
$miObj->setParameter("DS_MERCHANT_TRANSACTIONTYPE","0");
//~ $miObj->setParameter("DS_MERCHANT_PAYMETHODS","z");
$miObj->setParameter("DS_MERCHANT_TERMINAL","001");
$miObj->setParameter("DS_MERCHANT_MERCHANTURL",$urlnext);
$miObj->setParameter("DS_MERCHANT_URLOK",$urlnext);		
$miObj->setParameter("DS_MERCHANT_URLKO",$urlnext);
$params = $miObj->createMerchantParameters();
$signature = $miObj->createMerchantSignature($key);

$miObj_bizum=new Redsys;
$miObj_bizum->setParameter("DS_MERCHANT_AMOUNT",$total*100);
$miObj_bizum->setParameter("DS_MERCHANT_ORDER",$t.$order_number);
$miObj_bizum->setParameter("DS_MERCHANT_MERCHANTCODE",$tpvid);
$miObj_bizum->setParameter("DS_MERCHANT_CURRENCY","978");
$miObj_bizum->setParameter("DS_MERCHANT_TRANSACTIONTYPE","0");
$miObj_bizum->setParameter("DS_MERCHANT_PAYMETHODS","z");
$miObj_bizum->setParameter("DS_MERCHANT_TERMINAL","001");
$miObj_bizum->setParameter("DS_MERCHANT_MERCHANTURL",$urlnext);
$miObj_bizum->setParameter("DS_MERCHANT_URLOK",$urlnext);		
$miObj_bizum->setParameter("DS_MERCHANT_URLKO",$urlnext);
$params_bizum = $miObj_bizum->createMerchantParameters();
$signature_bizum = $miObj_bizum->createMerchantSignature($key);

?> 

<div id="checkout">
<div id="body_wrap">
<div class="units-row units-padding">
 	
<div class="unit-centered unit-100 cuerpocentral blancobg estatica sombra">	
	<div class="units-row units-split"> 	
		<div class="unit-100 end proceso">Proceso de compra en 2 pasos:</div>
		<div class="unit-50 end proceso2 cajapro2">Paso 1</div>
		<div class="unit-50 end proceso1 cajapro">Paso 2</div> <br/><br/>
        </div>	
	<?
	if($status==1){
	?>
		<div class="units-row units-split"> 	
			<div class="unit-50 no-padding">
				<form id='form_tpv' action="<?=$tpvurl;?>" target="_blank" method="POST" >
					<input type="hidden" name="Ds_SignatureVersion" value="<?php echo $version; ?>"/>
					<input type="hidden" name="Ds_MerchantParameters" value="<?php echo $params; ?>"/>
					<input type="hidden" name="Ds_Signature" value="<?php echo $signature; ?>"/>
					<?php
					if(($_SERVER["REMOTE_ADDR"]== $pago->test_ip || $pago->test_ip=="") && $pago->test==0){
						// QUITAMOS EL RELOAD DE LA PÁGINA, NO SÉ POR QUE'SE HACE Y HACE IMPOSIBLE QUE EL USUARIO PERMITA ALAS VENTANAS EMERGENTES PARA PAGAR
						/*
						<button class="total3" onclick="window.location.reload(true);" type="submit"  >Pago con tarjeta </button>
						*/
					?>
						<div class="unit-50 text-centered">
							<a id="pago_paypal" href="<?=$urlthis?>/paypal"><img src="https://www.paypal.com/es_XC/i/btn/btn_xpressCheckout.gif" style="padding:7px;"></a>
						</div>	
						<div class="unit-50">
							<button id="pago_tarjeta" class="total4" type="submit"  >Pago con tarjeta </button>
						</div>	
					<?php
					}
					else{
					?>
						<button class="total2" onclick="window.location.reload(true);" type="submit" >Pago con tarjeta </button>
						<button class="total2" onclick="window.location.reload(true);" type="submit" value="O" name="Ds_Merchant_PayMethods">iupay</button>
						<button class="total2" id="transferencia" type="submit" value="R" name="Ds_Merchant_PayMethods">Transferencia</button>
					<?php
					}
					?>
				</form>
			</div>	
			<div class="unit-50 no-padding">
				<form id='form_bizum' action="<?=$tpvurl;?>" target="_blank" method="POST"  >
					<input type="hidden" name="Ds_SignatureVersion" value="<?php echo $version; ?>"/>
					<input type="hidden" name="Ds_MerchantParameters" value="<?php echo $params_bizum; ?>"/>
					<input type="hidden" name="Ds_Signature" value="<?php echo $signature_bizum; ?>"/>
					<?php
					if(($_SERVER["REMOTE_ADDR"]== $pago->test_ip || $pago->test_ip=="") && $pago->test==0){
					?>
						<div class="unit-50">
							<button class="total4" id="pago_bizum" type="submit"  >Pago con Bizum </button>
						</div>	
						<div class="unit-50">
							<button class="total4" id="transferencia" type="submit" value="R" name="Ds_Merchant_PayMethods">Transferencia</button>
						</div>	
					<?php
					}
					else{
					?>
						<button class="total2" onclick="window.location.reload(true);" type="submit" >Pago con tarjeta </button>
						<button class="total2" onclick="window.location.reload(true);" type="submit" value="O" name="Ds_Merchant_PayMethods">iupay</button>
						<button class="total2" id="transferencia" type="submit" value="R" name="Ds_Merchant_PayMethods">Transferencia</button>
					<?php
					}
					?>
				</form>
			</div>	
		</div>	
		<div style="display:none" id="transferenciaDialog">
			<?php 
			$trans=$this->contenido_model->get_page(123);
			if(isset($trans->texto))
				echo $trans->texto; 
			?>
		</div>
		<div class="men">
			* puedes realizar tu compra mediante ingreso en cuenta, enviando copia del justificante a: <b><big>pagos@depapelpintado.es</big></b>. Indicando como referencia el <b>número de pedido</b>.<br/>CCC:ES85 2100 4928 75 2200108321
		</div>
		<div class="combo">
			<a  href="<?php echo $base_url; ?>tienda/cerrar_pedido">Volver a la tienda</a>
		</div>
	<?
	}
	else{
	?>
		<div class="unit-100 proceso linea2">No es posible/necesario realizar ningún pago en este pedido.</div>
	<?
	}
	?>
</div>
</div>
</div>


<?php 
//if (isset($_GET['test'])){
	foreach($mini_cart_items as $row){
		$trozos_nombre=explode(' - ', $row['name']);
		$marca='';
		$coleccion='';
		$nombre_item='';
		$referencia='';
		if ($row['tipo']==5){
			$pre='Herramientas';
			if (isset($trozos_nombre[0]))
				$marca=$trozos_nombre[0];
			if (isset($trozos_nombre[1]))
				$nombre_item=$trozos_nombre[1];
			if (isset($trozos_nombre[2]))
				$referencia=$trozos_nombre[2];

			$nombre_completo="Herramientas ".$nombre_item;
		}
		else{
			if($row['tipo']==0)$pre="Papel pintado";
			else if($row['tipo']==1)$pre="Fotomural";
			else if($row['tipo']==2)$pre="Revestimento";
			else if($row['tipo']==3)$pre="Tela";
			else if($row['tipo']==4)$pre="Alfombra";

			if (isset($trozos_nombre[0]))
				$marca=$trozos_nombre[0];
			if (isset($trozos_nombre[1]))
				$coleccion=$trozos_nombre[1];
			if (isset($trozos_nombre[2]))
				$referencia=$trozos_nombre[2];
		
			$nombre_completo=$pre." ".$coleccion." ".$referencia;
		}

		$datos_ga4[$row['id']]['name']=$nombre_completo;
		$datos_ga4[$row['id']]['price']=str_replace('€', '', $row['discount_price']);
		$datos_ga4[$row['id']]['brand']=$marca;
		$datos_ga4[$row['id']]['category']=$pre;
		$datos_ga4[$row['id']]['quantity']=$row['quantity'];
	}
    /*
    echo '<pre>';
    print_r($datos_ga4);
    echo '</pre>';
    exit;
    */
//}
?>
<!-- Scripts -->  
<?php //$this->load->view('includes/scripts'); ?> 
<script type='text/javascript'>
	$(document).ready(function(){
		$('#transferencia').click(function(e){
			e.preventDefault();
			data_layer_forma_pago('Transferencia');

			$( "#transferenciaDialog" ).dialog({
			title:"Pago por transferencia",
			resizable: false,
			height:300,
			width:500,
			modal: true,
			buttons: {
			"Entendido": function() {
				$( this ).dialog( "close" );
			},
			
			}
			});
			
		})
		
		$('#pago_bizum').click(function(e){
			e.preventDefault();
			data_layer_forma_pago('Bizum');
			$('#form_bizum').submit();
		})
		$('#pago_paypal').click(function(e){
			e.preventDefault();
			data_layer_forma_pago('Paypal');
			location.href = $(this).attr("href");
		})
		$('#pago_tarjeta').click(function(e){
			e.preventDefault();
			data_layer_forma_pago('TPV');
			$('#form_tpv').submit();
		})
		
	})

	function data_layer_forma_pago(forma_pago){
		/**
		* A function to handle a click on a checkout button. This function uses the eventCallback
		* data layer variable to handle navigation after the ecommerce data has been sent to Google Analytics.
		*/
		dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
		dataLayer.push({
		  'event': 'add_payment_info',
		  'ecommerce': {
		    'currencyCode': 'EUR',
		    'checkout': {
		      'actionField': {'step': 4,  'option': forma_pago},
		      'products': [
				<?php 
				foreach ($datos_ga4 as $idproducto => $datos_producto) {
					echo "{ \n";
					echo "  name: '{$datos_producto['name']}',  \n";       // Name or ID is required.
					echo "  id: '$idproducto', \n";
					echo "  price: {$datos_producto['price']}, \n";
					echo "  brand: '{$datos_producto['brand']}', \n";
					echo "  category: '{$datos_producto['category']}', \n";
					//echo "  item_category2: "Mens", \n";
					//echo "  item_category3: "Shirts", \n";
					//echo "  item_category4: "Tshirts", \n";
					//echo "  item_variant: "Gray", \n";
					echo "  quantity: '{$datos_producto['quantity']}' \n";
					echo "}, \n";
				}
				?>
		      ]
		    }
		  }
		});
	}

</script>
<script>
// OPCION PURCHASE	
// Send transaction data with a pageview if available
// when the page loads. Otherwise, use an event when the transaction
// data becomes available.
/*	
dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
dataLayer.push({
  'ecommerce': {
	'currencyCode': 'EUR', 
    'purchase': {
      'actionField': {
        'id': '<?php echo $acumulado_pedido['id']; ?>',           // Transaction ID. Required for purchases and refunds.
        'revenue': '<?php echo $acumulado_pedido['revenue']; ?>', // Total transaction value (incl. tax and shipping)
        'tax':'<?php echo $acumulado_pedido['tax']; ?>',
        'shipping': '<?php echo $acumulado_pedido['shipping']; ?>'
      },
      'products': [
      	<?php 
      	foreach ($items_pedido as $id_item => $item_pedido) {
      	
			$categ=$item_pedido['category'];
			switch ($categ) {
			  case 0: $seccionbase="papel_pintado";   break;
			  case 1: $seccionbase="fotomurales";   break;
			  case 2: $seccionbase="revestimientos";   break;
			  case 3: $seccionbase="telas";   break;
			  case 4: $seccionbase="alfombras";   break;
			  case 5: $seccionbase="herramientas";   break;
			  default:   $seccionbase="papel_pintado"; break;
			}
	      	?>
			{                           
		        'name': '<?php echo $item_pedido['name']; ?>',     // Name or ID is required.
		        'id': '<?php echo $item_pedido['id']; ?>',
		        'price': '<?php echo $item_pedido['unit_price']; ?>',
		        'brand': '<?php echo $item_pedido['brand']; ?>',
		        'category': '<?php echo ucwords(str_replace('_', ' ', $seccionbase)); ?>',
		        'quantity': '<?php echo $item_pedido['quantity']; ?>',
			},
      	<?php
      	}
      	?>
       ]
    }
  }
});
*/
</script>

<?php  
$this->load->view('frontend/footer'); 
?> 