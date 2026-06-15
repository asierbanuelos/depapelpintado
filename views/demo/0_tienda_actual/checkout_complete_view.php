<?php $this->load->view('frontend/header'); ?> 

<body id="checkout">
<div class="units-row units-padding">
 <div class="unit-centered unit-80 cuerpocentral blancobg estatica sombra">		
        
        <div style="display:block;height: 75px;"></div>					
				<ul>
					<li>
						<h4>Número de pedido: <?php echo $order_number; ?></h4>
					</li>
					<li>
						<p><?php echo $msg;?></p>
					</li>
					<li>
						<a href="<?php echo $base_url; ?>tienda/">Volver a la tienda</a>
					</li>
				</ul>
		</div>
	</div>
	
	<!-- Footer -->  
	<?//php $this->load->view('includes/footer'); ?> 


<!-- Scripts -->  
<?php
$this->load->view('includes/scripts'); 
if(isset($ecommerce)){
    echo $ecommerce;
}

if(isset($ga4_purchase)){
    echo $ga4_purchase;
}

?> 

</body>
</html>