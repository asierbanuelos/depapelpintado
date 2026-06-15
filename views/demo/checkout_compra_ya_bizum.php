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
		$miObj->setParameter("DS_MERCHANT_PAYMETHODS","Z");
		$miObj->setParameter("DS_MERCHANT_TERMINAL","001");
		$miObj->setParameter("DS_MERCHANT_MERCHANTURL",$urlnext);
		$miObj->setParameter("DS_MERCHANT_URLOK",$urlnext);		
		$miObj->setParameter("DS_MERCHANT_URLKO",$urlnext);
		$params = $miObj->createMerchantParameters();
		$signature = $miObj->createMerchantSignature($key);

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
     <?if($status==1){?>
						<div class="unit-100 proceso linea2">Datos de su pedido:</div>
						<div class="unit-100 proceso">Número de pedido: <b><?php echo $order_number; ?></b></div>


						<div class="unit-100 proceso">Importe Total: <b><?php echo $total; ?> €</b></div><br/><br/>

						<div class="unit-100 proceso linea2">Seleccione su metodo de pago:</div>

	<form action="<?=$tpvurl;?>" target="_blank" method="POST">
		<?php /*<input type="hidden" name="Ds_Merchant_Amount" value="<?=($total*100);?>"/>	
		<input type="hidden" name="Ds_Merchant_Currency" value="978"/>
		<input type="hidden" name="Ds_Merchant_ProductDescription" value="Compra dePapelPintado.es"/>
		<input type="hidden" name="Ds_Merchant_MerchantCode" value="<?=$tpvid?>"/>
		<input type="hidden" name="Ds_Merchant_Order" value="<?= $t.$order_number?>"/>
		<input type="hidden" name="Ds_Merchant_MerchantURL" value="<?=$urlnext?>"/>
		<input type="hidden" name="Ds_Merchant_UrlOK" value="<?=$urlnext?>"/>
		<input type="hidden" name="Ds_Merchant_UrlKO" value="<?=$urlnext?>"/>
		<input type="hidden" name="Ds_Merchant_MerchantName" value="EKAM"/>
		<input type="hidden" name="Ds_Merchant_MerchantSignature" value="<?=$hashpago?>"/>
		<input type="hidden" name="Ds_Merchant_Terminal" value="001"/>
		<input type="hidden" name="Ds_Merchant_TransactionType" value="0"/>*/?>
		<input type="hidden" name="Ds_SignatureVersion" value="<?php echo $version; ?>"/></br>
		<input type="hidden" name="Ds_MerchantParameters" value="<?php echo $params; ?>"/></br>
		<input type="hidden" name="Ds_Signature" value="<?php echo $signature; ?>"/></br>
		<?php
		if(($_SERVER["REMOTE_ADDR"]== $pago->test_ip || $pago->test_ip=="") && $pago->test==0){
			// QUITAMOS EL RELOAD DE LA PÁGINA, NO SÉ POR QUE'SE HACE Y HACE IMPOSIBLE QUE EL USUARIO PERMITA ALAS VENTANAS EMERGENTES PARA PAGAR
			/*<button class="total3" onclick="window.location.reload(true);" type="submit"  >Pago con tarjeta </button>*/
		?>
			<a href="<?=$urlthis?>/paypal"><img src="https://www.paypal.com/es_XC/i/btn/btn_xpressCheckout.gif" align="left" style="padding:7px;margin-right:7px;margin-left: 7px;"></a>
			<button class="total3" type="submit"  >Pago con tarjeta </button>
			<button class="total3" onclick="window.location.reload(true);" type="submit" value="O" name="Ds_Merchant_PayMethods">iupay</button>
			<button class="total3" id="transferencia" type="submit" value="R" name="Ds_Merchant_PayMethods">Transferencia</button>
		<br>
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
  <div style="display:none" id="transferenciaDialog">
  	<?php $trans=$this->contenido_model->get_page(123);
	if(isset($trans->texto))
	echo $trans->texto; ?>
  </div>
                    <div class="men">
                      * puedes realizar tu compra mediante ingreso en cuenta, enviando copia del justificante a: <b><big>pagos@depapelpintado.es</big></b>. Indicando como referencia el <b>número de pedido</b>.<br/>CCC:ES85 2100 4928 75 2200108321
					</div>
					<div class="combo">
						<a  href="<?php echo $base_url; ?>tienda/cerrar_pedido">Volver a la tienda</a>
					</div>
<?}else{?>
<div class="unit-100 proceso linea2">No es posible/necesario realizar ningún pago en este pedido.</div>
<?}?>
  </div>
</div>
	
</div>

<!-- Scripts -->  
<?php //$this->load->view('includes/scripts'); ?> 
<script type='text/javascript'>
	
	$(document).ready(function(){
		$('#transferencia').click(function(e){
			e.preventDefault();
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
		
	})
</script>

<?php $this->load->view('frontend/footer'); ?> 