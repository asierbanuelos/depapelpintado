
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
<script>
    ga('require', 'ecommerce', 'ecommerce.js');
    ga('ecommerce:addTransaction', {
        id: '<?= $summary_data[$this->flexi_cart_admin->db_column('order_summary', 'order_number')];?>', 
        affiliation: 'depapelpintado.es', 
        revenue: '<?= number_format($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'total')],2);?>', 
        shipping: '<?= number_format($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'shipping_total')],2);?>' , 
        tax: '<?= number_format($summary_data[$this->flexi_cart_admin->db_column('order_summary', 'tax_total')],2);?>' 
    }); 
    
    <?if (! empty($item_data)) {
	foreach($item_data as $row) {
            $order_detail_id = $row[$this->flexi_cart_admin->db_column('order_details', 'id')];
            if ($row['ord_det_discount_quantity'] > 0){
    ?>
    ga('ecommerce:addItem', {
        id: '<?= $summary_data[$this->flexi_cart_admin->db_column('order_summary', 'order_number')];?>',
        sku: '<?= $order_detail_id?>', 
        name: '<?= $row[$this->flexi_cart_admin->db_column('order_details', 'item_name')];?>',
        category: 'faltaSacar', 
        price: '<?=  str_replace("€", "", $row['ord_det_discount_price'])?>',
        quantity: '<?php echo $row['ord_det_discount_quantity']; ?>'
    }); 
    <?
            }
            if($row[$this->flexi_cart_admin->db_column('order_details', 'item_quantity')]!=$row['ord_det_discount_quantity']){
    ?>
    ga('ecommerce:addItem', {
        id: '<?= $summary_data[$this->flexi_cart_admin->db_column('order_summary', 'order_number')];?>',
        sku: '<?= $order_detail_id?>', 
        name: '<?= $row[$this->flexi_cart_admin->db_column('order_details', 'item_name')];?>',
        category: 'faltaSacar',
        price: '<?=  str_replace("€", "", $row['ord_det_price'])?>',
        quantity: '<?php echo round($row[$this->flexi_cart_admin->db_column('order_details', 'item_quantity')], 2)-$row['ord_det_discount_quantity']; ?>'
    });      
        <?}}}?>
    ga('ecommerce:send');
</script>
