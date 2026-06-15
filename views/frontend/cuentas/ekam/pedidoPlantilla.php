<?
if(is_array($summary_data)){
  if(count($summary_data)>0){
    $summary_data=$summary_data[0];
  }
  else{
    exit();
  }
}
?>

<table class="caja100">
<tr>
<td style="width:500px">

Cliente: <?php if($summary_data['ord_demo_bill_name']!="")echo $summary_data['ord_demo_bill_name'];else echo $summary_data['ord_demo_ship_name'];?><br/>
<?php if($summary_data['ord_demo_bill_company']!="")echo "CIF: ".$summary_data['ord_demo_bill_company']."<br/>";?><br/>
Domicilio: <?php if($summary_data['ord_demo_bill_address_01']!="")echo $summary_data['ord_demo_bill_address_01'];else echo $summary_data['ord_demo_ship_address_01']?><br/>
Ciudad: <?php if($summary_data['ord_demo_bill_city']!="")echo $summary_data['ord_demo_bill_city'];else echo $summary_data['ord_demo_ship_city']?><br/>
C.P.: <?php if($summary_data['ord_demo_bill_post_code']!="")echo $summary_data['ord_demo_bill_post_code'];else echo $summary_data['ord_demo_ship_post_code'];?><br/>

</td>
<td style="width:200px">

Página: 1<br/>
Fecha: <?php echo date('j-m-Y', strtotime($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'date')]));?><br/>


</td>
</tr>

</table>
<!--fin cabecera con datos-->
<table>
<tr>
<td class="limpiar"></td>
</tr>
</table>
<!--contenido-->
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
    <td style="border-right: thin solid #CCC;" class="borde-right">Referencia</td>
    <td style="border-right: thin solid #CCC;" class="borde-right" colspan="4">Concepto</td>
    <?if($this->input->post('update_status')==6){?>
    <td style="border-right: thin solid #CCC;" class="borde-right">Enviado</td>
    <?}?>
    <td style="border-right: thin solid #CCC;" class="borde-right">Cantidad</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">Precio</td>
    <td colspan="2" width="121">Importe</td>
  </tr>
  <?//15 lineas
  $i=0;
  if (! empty($item_data)) {
    foreach($item_data as $row) {
    $i++;
  ?>
  <tr>
    <td style="border-right: thin solid #CCC;" class="borde-right"><?=$row[$this->flexi_cart_admin->db_column('order_details', 'id')]?></td>
    <td colspan="4" style="border-right: thin solid #CCC;" class="borde-right"><?=$row[$this->flexi_cart_admin->db_column('order_details', 'item_name')]?>
<?php 
	if (! empty($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_description')])) { 
$i++;
?>
        <div style="font-size: 0.75em">Descuentos: <?php echo $row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_description')];?></div>
<?php }?>
    </td>
    <?if($this->input->post('update_status')==6){?>
    <td width="73" style="border-right: thin solid #CCC;" class="borde-right"><?=round($row[$this->flexi_cart_admin->db_column('order_details', 'item_quantity_shipped')], 2)?></td>
    <?}?>
    <td width="73" style="border-right: thin solid #CCC;" class="borde-right"><?=round($row[$this->flexi_cart_admin->db_column('order_details', 'item_quantity')], 2)?></td>
    <td style="border-right: thin solid #CCC;" class="borde-right"><?
    if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0) 
    {
        if ($row['ord_det_discount_quantity'] > 0) {
            echo '<span style="text-decoration:line-through;">' . $row['ord_det_price'] . '</span><br/>';
            echo $row['ord_det_discount_price'];
        }
    }
    else//*/
    {
        echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price')], TRUE, 2, TRUE);
    }
  ?></td>
    <td colspan="2"><?
    if ($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_quantity')] > 0)
    {
        echo '<span style="text-decoration:line-through;">'.$this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price_total')], TRUE, 2, TRUE).'</span><br/>';
        echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_discount_price_total')], TRUE, 2, TRUE);
    }
    else//*/
    {
        echo $this->flexi_cart_admin->format_currency($row[$this->flexi_cart_admin->db_column('order_details', 'item_price_total')], TRUE, 2, TRUE);
    }
    ?></td>
  </tr>
  <?}
  for ($j=$i;$j<14;$j++){
   ?>
  <tr>
    <td style="border-right: thin solid #CCC;" class="borde-right">&nbsp;</td>
    <td style="border-right: thin solid #CCC;" colspan="4" class="borde-right">&nbsp;</td>
    <td style="border-right: thin solid #CCC;" width="73" class="borde-right">&nbsp;</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <?}
}?>
  <?php if ($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'reward_voucher_total')] > 0) { ?>
<tr>
    <td style="border-right: thin solid #CCC;" class="borde-right">&nbsp;</td>
    <td colspan="4" style="border-right: thin solid #CCC;" class="borde-right">
<?php echo $summary_data[$this->flexi_cart_admin->db_column('order_summary', 'reward_voucher_description')];?>
    </td>
    <td style="border-right: thin solid #CCC;" width="73" class="borde-right">&nbsp;</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">&nbsp;</td>
    <td colspan="2"><?php echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'reward_voucher_total')], TRUE, 2, TRUE);?></td>
</tr>
  <?}?>
  
  <tr style="background-color:#dedede;" class="fondocelda">
    <td style="border-right: thin solid #CCC;" class="borde-right">Total Bruto:</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">%</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">Importe dto.</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">Portes</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">Base Imponible</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">21% IVA</td>
    <td style="border-right: thin solid #CCC;" class="borde-right">Subtotal</td>
    <td colspan="2"><?php echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_total')]+$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')], TRUE, 2, TRUE);?></td>
  </tr>
  <tr>
    <td style="border-right: thin solid #CCC;" class="borde-right"><?php echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_total')]+$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')], TRUE, 2, TRUE);?></td>
   <td style="border-right: thin solid #CCC;" class="borde-right">&nbsp;</td>
    <td style="border-right: thin solid #CCC;" class="borde-right"><?php if ($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'summary_savings_total')]+$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')] > 0)echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'item_summary_savings_total')]+$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'summary_savings_total')], TRUE, 2, TRUE);?></td>
    <td style="border-right: thin solid #CCC;" class="borde-right"><?php echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'shipping_total')], TRUE, 2, TRUE);?></td>
    <td style="border-right: thin solid #CCC;" class="borde-right"><?php echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'total')]-$summary_data[$this->flexi_cart_admin->db_column('order_summary', 'tax_total')], TRUE, 2, TRUE);?></td>
    <td style="border-right: thin solid #CCC;" class="borde-right"><?php echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'tax_total')], TRUE, 2, TRUE);?></td>
    <td style="border-right: thin solid #CCC;" class="borde-right">Total</td>
    <td colspan="2"><?php echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'total')], TRUE, 2, TRUE);?></td>
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
  <tr style="background-color:#dedede;" class="fondocelda">
    <td style="border-right: thin solid #CCC;" colspan="3" width="226" class="borde-right">Estado del pedido</td>
    <td colspan="2" width="190">TOTAL</td>
  </tr>
  <tr>
    <td style="border-right: thin solid #CCC;" colspan="3" class="borde-right">
    <?php
								if ($summary_data[$this->flexi_cart_admin->db_column('order_status', 'cancelled')] == 1)
								{
									echo '<strong class="highlight_red">'.$summary_data[$this->flexi_cart_admin->db_column('order_status', 'status')].'</strong>';
								}
								else
								{
									echo $summary_data[$this->flexi_cart_admin->db_column('order_status', 'status')];									
								}
							?>
    </td>
    <td colspan="2"><?php echo $this->flexi_cart_admin->format_currency($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'total')], TRUE, 2, TRUE);?></td>
  </tr>
</table>

<table>
<tr>
<td>
<hr>

<p class="datospie1">Sus datos personales serán incluidos en fichero de EDKAR & ALPER S.L., para la gestión de facturación, obligaciones fiscales y contabilidad. </p>
<p class="datospie1">
	Ud. puede ejercitar sus derechos de acceso, rectificación, cancelación y oposición, mediante petición escrita dirigida a EDKAR & ALPER S.L. por correo electrónico 
	<a href="mailto:info@decoracionbilbao.es">info@decoracionbilbao.es</a>
</p>
<p class="datospie2">
	EDKAR &amp; ALPER S.L. - C/ Doctor Areilza 21 48011 Bilbao (Vizcaya)<br>
	Tlf y Fax: 94 405 66 16 Email: <a href="mailto:info@decoracionbilbao.es">info@decoracionbilbao.es</a><br>
	web: <a href="https://www.decoracionbilbao.es" title="www.decoracionbilbao.es">www.decoracionbilbao.es</a><br>
	CIF B95690749
</p>
</td>
</tr>
</table>




</td>
</tr>
</table>
