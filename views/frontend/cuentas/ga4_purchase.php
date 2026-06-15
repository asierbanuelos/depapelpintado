<script>
// OPCION PURCHASE  
// Send transaction data with a pageview if available
// when the page loads. Otherwise, use an event when the transaction
// data becomes available.
dataLayer.push({ ecommerce: null });  // Clear the previous ecommerce object.
dataLayer.push({
    event: "purchase",
    'ecommerce': {
        'currencyCode': 'EUR', 
        'purchase': {
            'actionField': {
            'id': '<?php echo $acumulado_pedido['id']; ?>',           // Transaction ID. Required for purchases and refunds.
            'revenue': <?php echo $acumulado_pedido['revenue']; ?>, // Total transaction value (incl. tax and shipping)
            'tax':<?php echo $acumulado_pedido['tax']; ?>,
            'shipping': <?php echo $acumulado_pedido['shipping']; ?>,
            'email': '<?php echo $acumulado_pedido['ord_demo_email']; ?>',
            'coupon': ''
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
            'price': <?php echo $item_pedido['unit_price']; ?>,
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
</script>

