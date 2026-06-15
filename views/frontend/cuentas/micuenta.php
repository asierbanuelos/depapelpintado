<div class="wrapper mi-cuenta">
  <div class="container">
    <div class="row ">
      <div class="col-xl-3 col-lg-3 col-md-4 d-none d-md-block">
      </div>
      <div class="col-xl-9 col-lg-9 col-md-8 col-12">
      	<h1 class='titulo-1 border-bottom border-dark pb-2 mb-4'>
      		<?php 
      		/*
					Hola <i class="fa fa-user"></i> 
					<span style="text-transform: capitalize;">
					<?php echo ($this->data['usuario']->ord_demo_ship_name!='')?$this->data['usuario']->ord_demo_ship_name:$this->data['usuario']->ord_demo_bill_name; ?>
					</span>
					&nbsp;&nbsp;&nbsp;&nbsp;
					<i class="fa fa-envelope-o"></i> <?php echo $this->data['usuario']->email; ?>
      		*/
      		?>
					Hola, 
					<?php echo ($this->data['usuario']->ord_demo_ship_name!='')?$this->data['usuario']->ord_demo_ship_name:$this->data['usuario']->ord_demo_bill_name; ?>
					-
					<?php echo $this->data['usuario']->email; ?>
				</h1>
      </div>
		</div>
		<?php 
    $margin_top='mt-2';
    //if (trim($texto_descripcion)!='')
    //  $margin_top='';
		?>
    <div class="row ">
      <div class="col-xl-3 col-lg-3 col-md-4 d-none d-md-block">
        <div class='columna-filtros <?php echo $margin_top; ?>'>
          <?php 
					$this->load->view('frontend/cuentas/menu25', $this->data);
          ?>
        </div>
      </div>
      
      <div class="col-xl-9 col-lg-9 col-md-8 col-12">
				<?php
				$this->load->view('frontend/cuentas/mis_datos', $this->data);
				?>
      </div>
    </div>		
	</div>
</div>

<script>
/*
$(function() 
{
	// Toggle show/hide cart session array
	$('#copy_billing_details').click(function()
	{
    //  if($("#checkout_billing_country").val()=="<?php echo $this->flexi_cart->shipping_location_name(1);?>"){
		$('input[name^="b_"]').each(function()
		{
         
			// Target textboxes only, no hidden fields
			if ($(this).attr('type') == 'text')
			{
				var name = $(this).attr('name').replace('b_', 's_');
				var value = ($('#copy_billing_details').is(':checked')) ? $(this).val() : '';
				
				$('input[name="'+name+'"]').val(value);
			}
		});
   //   }
  //    else alert("No es posible copiar la dirección, los paises no coinciden.");
	
	});
});
*/
</script>