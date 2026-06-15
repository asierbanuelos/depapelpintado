<?php 
if(isset($datosok)){
  //AKI HAY QUE PONER EL MENSAJE DE CAMBIO CORRECTO
  echo "<p class='titulo-2 text-center mt-4 pt-4 mb-4 pb-4'>$datosok</p>";
}
if(isset($datosko)){
  //AKI HAY QUE PONER EL MENSAJE DE CAMBIO INCORRECTO
  echo "<p class='titulo-2 text-center mt-4 pt-4 mb-4 pb-4'>$datosko</p>";
}
//echo '<section  class="page-content card card-block m-auto p-4">';
echo form_open(current_url()); 
?>
<h2 class="h5 mt-2">Datos Contacto</h2>
<section class="page-content card card-block p-4 mt-2">
  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_phone">
      Teléfono:
    </label>
    <div class="col-md-8">
      <input class='form-control' type="text" name="phone" id="checkout_phone" value="<?php echo set_value('phone',$usuario->phone);?>" placeholder="Teléfono"/>
    </div>
  </div>
</section>

<h2 class="h5 mt-4">Datos Envío</h2>
<section class="page-content card card-block p-4 mt-2">
  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_shipping_name">
      Nombre y Apellidos / Razón Social:
    </label>
    <div class="col-md-8">
      <input class='form-control' type="text" name="s_name" id="checkout_shipping_name" value="<?php echo set_value('s_name', $usuario->ord_demo_ship_name); ?>" placeholder="Nombre y Apellidos / Razón Social" />
    </div>
  </div>

  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_shipping_company">
      NIF:
    </label>
    <div class="col-md-8">
      <input class='form-control' type="text" name="s_company" id="checkout_shipping_company" value="<?php echo set_value('s_company', $usuario->ord_demo_ship_company); ?>" placeholder="NIF / CIF" />
    </div>
  </div>


  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_shipping_add_01">
      Dirección 1:
    </label>
    <div class="col-md-8">
      <input class='form-control' type="text" name="s_add_01" id="checkout_shipping_add_01" value="<?php echo set_value('s_add_01', $usuario->ord_demo_ship_address_01); ?>" placeholder="Dirección 1" />
    </div>
  </div>

  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_shipping_city">
      Población:
    </label>
    <div class="col-md-8">
      <input class='form-control' type="text" name="s_city" id="checkout_shipping_city" value="<?php echo set_value('s_city', $usuario->ord_demo_ship_city); ?>" placeholder="Población" />
    </div>
  </div>

  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_shipping_state">
      Provincia:
    </label>
    <div class="col-md-8">
        <input class='form-control' type="text" name="s_state" id="checkout_shipping_state" value="<?php echo set_value('s_state', $usuario->ord_demo_ship_state); ?>" placeholder="Provincia" />
    </div>
  </div>

  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_shipping_post_code">
      Código Postal:
    </label>
    <div class="col-md-8">
        <input class='form-control' type="text" name="s_post_code" id="checkout_shipping_post_code" value="<?php echo set_value('s_post_code', $usuario->ord_demo_ship_post_code); ?>" placeholder="Código Postal" />
    </div>
  </div>

  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_shipping_country">
      País:
    </label>
    <div class="col-md-8">
      <select id="checkout_shipping_country" name="s_country" class='form-control'>
      <option value="0"> - País - </option>
      <?php 
      foreach($countries as $country){ 
        //$country_selected=($this->flexi_cart->match_shipping_location_id($country['loc_id'])) ? ' selected="selected" ' : NULL;
        $country_selected='';
        if($country['loc_id']==trim($usuario->ord_demo_ship_country))
          $country_selected=' selected="selected" ';
        ?>
        <option data-texto-limpio="<?php echo $country['loc_name'];?>" value="<?php echo $country['loc_id'];?>" <?php echo $country_selected;?> >
          <?php echo $country['loc_name'];?>
        </option>
      <?php 
      } ?>
      </select>
    
    </div>
  </div>
</section>


<h2 class="h5 mt-4">Datos Facturación</h2>
<section class="page-content card card-block p-4 mt-2">
  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_billing_name">
      Nombre y Apellidos / Razón Social:
    </label>
    <div class="col-md-8">
      <input class='form-control' type="text" name="b_name" id="checkout_billing_name" value="<?php echo set_value('b_name', $usuario->ord_demo_bill_name); ?>" placeholder="Nombre y Apellidos / Razón Social" />
    </div>
  </div>

  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_billing_company">
      NIF:
    </label>
    <div class="col-md-8">
      <input class='form-control' type="text" name="b_company" id="checkout_billing_company" value="<?php echo set_value('b_company', $usuario->ord_demo_bill_company); ?>" placeholder="NIF / CIF" />
    </div>
  </div>

  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_billing_add_01">
      Dirección 1:
    </label>
    <div class="col-md-8">
      <input class='form-control' type="text" name="b_add_01" id="checkout_billing_add_01" value="<?php echo set_value('b_add_01', $usuario->ord_demo_bill_address_01); ?>" placeholder="Dirección 1" />
    </div>
  </div>

  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_billing_city">
      Población:
    </label>
    <div class="col-md-8">
        <input class='form-control' type="text" name="b_city" id="checkout_billing_city" value="<?php echo set_value('b_city', $usuario->ord_demo_bill_city); ?>" placeholder="Población" />
    </div>
  </div>

  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_billing_state">
      Provincia:
    </label>
    <div class="col-md-8">
        <input class='form-control' type="text" name="b_state" id="checkout_billing_state" value="<?php echo set_value('b_state', $usuario->ord_demo_bill_state); ?>" placeholder="Provincia" />
    </div>
  </div>

  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_billing_post_code">
      Código Postal:
    </label>
    <div class="col-md-8">
        <input class='form-control' type="text" name="b_post_code" id="checkout_billing_post_code" value="<?php echo set_value('b_post_code', $usuario->ord_demo_bill_post_code); ?>" placeholder="Código Postal" />
    </div>
  </div>

  <div class="form-group row ">
    <label class="col-md-4 form-control-label" for="checkout_billing_country">
      País:
    </label>
    <div class="col-md-8">
      <select id="checkout_billing_country" name="b_country" class='form-control'>
      <option value="0"> - País - </option>
      <?php 
      foreach($countries as $country){ 
        //$country_selected=($this->flexi_cart->match_shipping_location_id($country['loc_id'])) ? ' selected="selected" ' : NULL;
        $country_selected='';
        if($country['loc_id']==trim($usuario->ord_demo_bill_country))
          $country_selected=' selected="selected" ';
        ?>
        <option data-texto-limpio="<?php echo $country['loc_name'];?>" value="<?php echo $country['loc_id'];?>" <?php echo $country_selected;?> >
          <?php echo $country['loc_name'];?>
        </option>
      <?php 
      } ?>
      </select>
    </div>
  </div>
</section>

        
<div class="form-group row ">
  <div class="col-12">
    <input class="boton-opciones" type="submit" name="cambiodatos" value="Guardar">
  </div>
</div>


<?php 
echo form_close(); 
//echo '</section>';

?>
