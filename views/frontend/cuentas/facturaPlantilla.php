<?
if(is_array($summary_data)){
  if(count($summary_data)>0){
    $summary_data=$summary_data[0];
  }
  else{
    exit();
  }
}

$titulo_general='Factura';
$negativo='';
$num_factura=str_pad($summary_data['factura'], 5, 0, STR_PAD_LEFT);
$fecha_factura=$summary_data['fechafactura'];
if (isset($rectificativa) && $rectificativa){
	$titulo_general='Factura Rectificativa';
	$negativo='-';
	$num_factura=str_pad($summary_data['factura_rect'], 5, 0, STR_PAD_LEFT).'-R';
	$fecha_factura=$summary_data['fechafactura_rect'];
}
?>

<table class="contenedor">
<tr>
<td class="contenido">

<?php 
$logo_factura='<td class="logo1"><img src="http://www.depapelpintado.es/includes/images/depapelpintado-logo.jpg"/></td>';
$url_factura='<a href="http://www.depapelpintado.es" title="depapelpintado.es">www.depapelpintado.es</a>';
if ($summary_data['ord_user_ekam_fk']!=0){
  $logo_factura='<td class="logo2"><img src="http://www.depapelpintado.es/includes/images/ekam-logo.jpg"/></td>';
  $url_factura='<a href="http://www.www.ekamdecoracion.com" title="ekamdecoracion">www.ekamdecoracion.com</a>';
}
?>

<table class="caja100">
<tr>
<td style="background-color:#CCC;color:#333;text-align:center;" class="facturatitulo" colspan="3">
<h1 style="text-transform:uppercase;"><?php echo $titulo_general; ?></h1>
</td>
</tr>
<tr>
  <?php 
  echo $logo_factura;
  /*
  <td class="logo1">
    <img src="http://www.depapelpintado.es/includes/images/depapelpintado-logo.jpg"/>
  </td>
  */
  ?>
  <td class="dire1">
    <h2>EDKAR & ALPER S.L. </h2>
    <p>C/ Doctor Areilza 21
    48011 Bilbao
    </p>
    <p>
      <?php 
      echo $url_factura;
      /*
      <a href="http://www.www.ekamdecoracion.com" title="ekamdecoracion">www.ekamdecoracion.com</a><br>
      <a href="http://www.depapelpintado.es" title="depapelpintado.es">www.depapelpintado.es</a> 
      */
      ?>
    </p>
  </td>
  <?php 
  /*
  <td class="logo2">
    <img src="http://www.depapelpintado.es/includes/images/ekam-logo.jpg"/>
  </td>
  */
  ?>

<tr>
<td  colspan="3" class="limpiar"></td>
</tr>
<tr>
<td colspan="3">
<hr>
</td>
</tr>
</table>

<table class="caja100">
<tr>
<td style="width:500px">

Cliente: <?php echo $summary_data['ord_demo_bill_name']." (".$summary_data['ord_demo_phone'].")";?><br/>
CIF: <?php echo $summary_data['ord_demo_bill_company'];?><br/>
Domicilio: <?php echo $summary_data['ord_demo_bill_address_01'];?><br/>
Ciudad: <?php echo $summary_data['ord_demo_bill_city'];?><br/>
C.P.: <?php echo $summary_data['ord_demo_bill_post_code'];?><br/>

</td>
<td  style="width:200px">

Página: 1<br/>
Factura: <? echo $num_factura;?><br/>
Fecha: <? echo $fecha_factura;?><br/>


</td>
</tr>

</table>
<table>
<tr>
<td class="limpiar"></td>
</tr>
</table>

<table class="caja100">
<tr>
<td>
<table style="border:thin solid #CCC;" class="borde-gral" cellspacing="0" cellpadding="0">
  <col width="89">
  <col width="52">
  <col width="85">
  <col width="68">
  <col width="122">
  <col width="73">
  <col width="91">
  <col width="92">
  <col width="29">
  <tr style="border-bottom: thin solid #CCC;" class="borde-bottom">
    <td colspan="2" width="141">&nbsp;</td>
    <td width="85">&nbsp;</td>
    <td width="68">&nbsp;</td>
    <td width="122">&nbsp;</td>
    <td width="73">Bultos:</td>
    <td width="91">&nbsp;</td>
    <td width="92">Kilogramos:</td>
    <td width="29">&nbsp;</td>
  </tr>
  <tr style="border-bottom: thin solid #CCC;background-color:#dedede;" class="borde-bottom fondocelda">
    <td colspan="2" style="border-right: thin solid #CCC;" class="borde-right">Por Mediación de:</td>
    <td colspan="3" style="border-right: thin solid #CCC;" class="borde-right">N.-Albarán</td>
    <td colspan="4">Dirección de Envío:</td>
  </tr>
  <tr style="border-bottom: thin solid #CCC;" class="borde-bottom">
    <td colspan="2" style="border-right: thin solid #CCC;" class="borde-right">Online</td>
    <td colspan="3" style="border-right: thin solid #CCC;" class="borde-right"><?php echo $summary_data[$this->flexi_cart_admin->db_column('order_summary', 'order_number')];?></td>
    <td colspan="4"><?php echo $summary_data['ord_demo_ship_address_01'];?> <br/><?php echo $summary_data['ord_demo_ship_post_code'];?> - <?php echo $summary_data['ord_demo_ship_city'];?> - <?php echo $summary_data['ord_demo_ship_state'];?></td>
  </tr>
  <tr style="border-bottom: thin solid #CCC;background-color:#dedede;" class="borde-bottom fondocelda">
    <?php
    /*
    <td style="border-right: thin solid #CCC;" class="borde-right">Referencia</td>
    */
    ?>
    <td style="border-right: thin solid #CCC;" class="borde-right" colspan="5">Concepto</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">Cantidad</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">Precio</td>
    <td colspan="2" width="121">Importe</td>
  </tr>
  <?//15 lineas
  $i=0;
  if (! empty($item_data)) {
    /*
    */
    $restar_total=0;  
    $restar_descuento=0;  
    $restar_impuestos=0;  
    foreach($item_data as $row) {
      if ($row['ord_det_quantity_cancelled']>0){
        /*
        print '<pre><xmp>';
        print_r($row);
        print '</xmp></pre>';
        $restar_total+=$row['ord_det_price']*$row['ord_det_quantity_cancelled'];  
        $restar_descuento+=($row['ord_det_price'] - $row['ord_det_discount_price'])*$row['ord_det_quantity_cancelled'];  
        $restar_impuestos+=$row['ord_det_tax']*$row['ord_det_quantity_cancelled'];  
        */
      }
      if ($row['ord_det_quantity_shipped']>0){
        $i++;
        ?>
        <tr>
        <?php
        /*
        <td style="border-right: thin solid #CCC;" class="borde-right"><?=$row[$this->flexi_cart_admin->db_column('order_details', 'id')]?></td>
        */
        ?>
        <td colspan="5" style="border-right: thin solid #CCC;" class="borde-right"><?=$row[$this->flexi_cart_admin->db_column('order_details', 'item_name')]?>
        <?php 
        if (! empty($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_description')])) { 
        $i++;
        ?>
        <div style="font-size: 0.75em"><Descuentos: <?php echo $row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_description')];?></div>
        <?php }?>
        </td>
        <td width="73" style="border-right: thin solid #CCC;" class="borde-right"><?=round($row[$this->flexi_cart_admin->db_column('order_details', 'item_quantity')], 2)?></td>
        <td style="border-right: thin solid #CCC;" class="borde-right"><?
        if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0){
          if ($row['ord_det_discount_quantity'] > 0) {
            echo $negativo.'<span style="text-decoration:line-through;">' . $row['ord_det_price'] . '</span><br/>';
            echo $negativo.$row['ord_det_discount_price'];
          }
        }
        else{
          echo $negativo.$this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price')], TRUE, 2, TRUE);
        }
        ?></td>
        <td colspan="2"><?
        if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0){
          echo $negativo.'<span style="text-decoration:line-through;">'.$this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price_total')], TRUE, 2, TRUE).'</span><br/>';
          echo $negativo.$this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_price_total')], TRUE, 2, TRUE);
        }
        else{
          echo $negativo.$this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price_total')], TRUE, 2, TRUE);
        }
        ?></td>
        </tr>
        <?
      }
  } 
  for ($j=$i;$j<14;$j++){
   ?>
  <tr>
    <?php
    /*
    <td style="border-right: thin solid #CCC;" class="borde-right">&nbsp;</td>
    */
    ?>
    <td style="border-right: thin solid #CCC;" colspan="5" class="borde-right">&nbsp;</td>
    <td style="border-right: thin solid #CCC;" width="73" class="borde-right">&nbsp;</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <?}
}?>
  
  <?php if ($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'reward_voucher_total')] > 0) { ?>
<tr>
    <?php
    /*
    <td style="border-right: thin solid #CCC;" class="borde-right">&nbsp;</td>
    */
    ?>
    <td style="border-right: thin solid #CCC;" colspan="5" class="borde-right">
<?php echo $negativo.$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'reward_voucher_description')];?>
    </td>
    <td style="border-right: thin solid #CCC;" width="73" class="borde-right">&nbsp;</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">&nbsp;</td>
    <td colspan="2"><?php echo $negativo.$this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'reward_voucher_total')], TRUE, 2, TRUE);?></td>
</tr>
  <?}

  $total_pedido_original=$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_total')]+$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')];
  $total_descuento=$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')]+$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'summary_savings_total')];
  $total_impuestos=$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'tax_total')];
  $total_final=$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'total')];
  
  $total_pedido_original-=$restar_total;
  $total_descuento-=$restar_descuento;
  $total_impuestos-=$restar_impuestos;

  $total_final=$total_pedido_original - $total_descuento;
  /*
  
  */
  $total_base_imponible=$total_final-$total_impuestos;
  ?>
  
  <tr style="background-color:#dedede;" class="fondocelda">
    <td style="border-right: thin solid #CCC;" class="borde-right">Total Bruto:</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">%</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">Importe dto.</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">Portes</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">Base Imponible</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">21% IVA</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">Subtotal</td>
    <td colspan="2">
      <?php 
      //echo $negativo.$this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_total')]+$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')], TRUE, 2, TRUE);
      echo $negativo.$this->flexi_cart_admin->format_currency($total_pedido_original, TRUE, 2, TRUE);
      ?>
    </td>
  </tr>
  <tr>
    <td class="borde-right">
      <?php 
      //echo $negativo.$this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_total')]+$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')] - $restar_total, TRUE, 2, TRUE);
      echo $negativo.$this->flexi_cart_admin->format_currency($total_pedido_original, TRUE, 2, TRUE);
      ?>
    </td>
   <td class="borde-right">&nbsp;</td>
    <td class="borde-right">
      <?php 
      if ($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'summary_savings_total')]+$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')] > 0) 
        echo $negativo.$this->flexi_cart_admin->format_currency($total_descuento, TRUE, 2, TRUE);
      ?>
    </td>
    <td class="borde-right">
      <?php echo $negativo.$this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'shipping_total')], TRUE, 2, TRUE);?>
    </td>
    <td class="borde-right">
      <?php 
      echo $negativo.$this->flexi_cart_admin->format_currency($total_base_imponible, TRUE, 2, TRUE);?>
    </td>
    <td class="borde-right">
      <?php echo $negativo.$this->flexi_cart_admin->format_currency($total_impuestos, TRUE, 2, TRUE);?>
        
      </td>
    <td class="borde-right">Total</td>
    <td colspan="2">
      <?php echo $negativo.$this->flexi_cart_admin->format_currency($total_final, TRUE, 2, TRUE);?>
    </td>
  </tr>
</table>
</td>
</tr>
</table>
<p>&nbsp;</p>
<table cellspacing="0" cellpadding="0" class="borde-gral">
  <col width="89">
  <col width="52">
  <col width="85">
  <col width="68">
  <col width="122">
  <tr  style="background-color:#dedede;" class="fondocelda">
    <!--<td colspan="3" width="226" class="borde-right"></td>-->
    <td colspan="5" width="190">TOTAL</td>
  </tr>
  <tr>
    <!--<td colspan="3" class="borde-right">&nbsp;</td>-->
    <td colspan="5">
      <?php 
      //echo $negativo.$this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'total')], TRUE, 2, TRUE);
      echo $negativo.$this->flexi_cart_admin->format_currency($total_final, TRUE, 2, TRUE);
      ?>
    </td>
  </tr>
</table>

<table>
<tr>
<td>
<hr>

<p style="font-size:10px;margin:0;" class="datospie1">
  De conformidad con el RGPD 2016/679 del Parlamento Europeo, le informamos que sus datos personales serán incluidos dentro de un fichero informatizado, del cual es responsable EDKAR ALPER SL, con la
  finalidad de gestionar, presupuestar, facturar y poder atender los compromisos derivados de la relación que mantenemos con usted. Podrá ejercer sus derechos, en los términos que establece la Ley, a la dirección:
</p>
<p style="font-size:10px;margin:0;" class="datospie2">
  EDKAR &amp; ALPER S.L. - C/ Doctor Areilza 21 48011 Bilbao (Vizcaya) - CIF: B95690749<br>
  Tlf y Fax: 94 405 66 16 Email: <a href="mailto:info@decoracionbilbao.es">info@decoracionbilbao.es</a> /  <a href="mailto:info@depapelpintado.es">info@depapelpintado.es</a><br>
  web: <a href="http://www.ekamdecoracion.com" title="www.ekamdecoracion.com">www.ekamdecoracion.com</a> /  <a href="https://www.depapelpintado.es" title="www.depapelpintado.es">www.depapelpintado.es</a>
</p>

<?php
/*
<p style="font-size:10px;margin:0;" class="datospie1">
	Sus datos personales serán incluidos en fichero de EDKAR & ALPER S.L., para la gestión de facturación, obligaciones fiscales y contabilidad. 
	<br />
	Vd. puede ejercitar sus derechos de acceso, rectificación, cancelación y oposición, mediante petición escrita dirigida a EDKAR & ALPER S.L. 
</p>
<p style="font-size:9px;text-align:center;margin:0;" class="datospie1">
	<strong>Información básica sobre Protección de Datos</strong>
	<br />
	<strong>Responsable</strong> EDKAR ALPER S.L. <strong>Finalidad</strong> Ejecución del contrato mercantil. <strong>Legitimación</strong> Consentimiento del interesado. 
	<strong>Destinatarios</strong> No se cederán datos a terceros, salvo obligación legal Derechos Acceder, rectificar y suprimir los datos, así como otros derechos, como se explica en la información adicional.
	<br />
	<strong>Información adicional</strong> Puede consultar la información adicional y detallada sobre Protección de Datos en nuestra sede social.
</p>
*/
?>
</td>
</tr>
</table>




</td>
</tr>
</table>

