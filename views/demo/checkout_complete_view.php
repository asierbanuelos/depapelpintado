<?php 
$this->load->view('frontend/header'); 
?> 
<div id='checkout' class="wrapper">
	<div id='body_wrap'>
		<input type="hidden" name="url_actual" id='url_actual' value="<?php echo current_url(); ?>" />
		  <div class="container">
		    <div class='row heading-producto'>
		    	<div class='cart-grid-body col-xs-12 col-lg-12' id='ajax_content'>
		    		<div class='border rounded pb-4'>
						<h1 class="h5 mb-4 py-3 px-3 text-left border-bottom border-dark">INFORMACIÓN SOBRE EL PAGO</h1>
						<?php 
						//if ($order_number=='00012391'){
						if (isset($datos_resumen_pantalla['acumulado_pedido']['revenue'])){
							echo "<p class='pl-3 pb-4 h6'>";
							echo "	Muchas gracias {$datos_resumen_pantalla['acumulado_pedido']['ord_demo_ship_name']} ({$datos_resumen_pantalla['acumulado_pedido']['ord_demo_email']}) por su pedido:";
							echo "</p>";
							echo "<h2 class='h6 px-3 pb-2'>Número de pedido: $order_number </h2>";

							echo "<p class='pl-3'>";
				            foreach ($datos_resumen_pantalla['items_pedido'] as $id_item => $item_pedido) {
				            	echo (int)$item_pedido['quantity'].' x '.$item_pedido['name']."<br />";
							}
							echo "</p>";
							echo "<p class='pl-3 pb-4 h6'>";
							echo "	Total pedido: ".number_format($datos_resumen_pantalla['acumulado_pedido']['revenue'], 2, ',', '.')." &euro;";
							echo "</p>";
						}
						else
							echo "<h2 class='h6 px-3 pb-2'>Número de pedido: $order_number </h2>";
						?>
						<p class='px-3'><small><?php echo $msg;?></small></p>
					</div>
					<div>
						<a href="/tienda" class='boton-opciones'>Volver a la tienda</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


<!-- Scripts -->  
<?php
if (isset($_GET['test'])){
}

//$this->load->view('includes/scripts'); 
if(isset($ecommerce)){
    echo $ecommerce;
}

if(isset($ga4_purchase)){
    echo $ga4_purchase;

    // Enviamos el pedido a la sociedad de opiniones contrastadas
    if(isset($datos_resumen_pantalla)){
	    $this->load->view('frontend/cuentas/api_sociedad_opiniones_contrastadas');
    }
}

$this->load->view('frontend/footer');
?> 
