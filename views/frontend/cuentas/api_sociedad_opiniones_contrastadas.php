<?php 

// Define API endpoint and API key 
$apiEndPoint = "https://api.guaranteed-reviews.com/private/v3/orders";
$apiKey = "13436/es/c448df73319ce03e9ec8cca4002e7a41a71a29dbefeb017480a84c785f5224a5";


$datos_pedido_envio=array();
$datos_pedido_envio['id_order']=$datos_resumen_pantalla['acumulado_pedido']['id'];
$datos_pedido_envio['order_date']=date('Y-m-d H:i:s');
$datos_pedido_envio['firstname']=$datos_resumen_pantalla['acumulado_pedido']['ord_demo_ship_name'];
$datos_pedido_envio['lastname']='';
$datos_pedido_envio['email']=$datos_resumen_pantalla['acumulado_pedido']['ord_demo_email'];
$datos_pedido_envio['reference']='';
$datos_pedido_envio['store_id']=0;
$datos_pedido_envio['products']=array();
$kont_productos=0;
foreach ($datos_resumen_pantalla['items_pedido'] as $id_item => $item_pedido) {
    $categ=$item_pedido['category'];
    switch ($categ) {
        case 0: $seccionbase="papel_pintado"; $seccionbase_name="Papel pintado";   break;
        case 1: $seccionbase="fotomurales";$seccionbase_name="Fotomurales";   break;
        case 2: $seccionbase="revestimientos";$seccionbase_name="Revestimientos";   break;
        case 3: $seccionbase="telas";$seccionbase_name="Telas";   break;
        case 4: $seccionbase="alfombras";$seccionbase_name="Alfombras";   break;
        case 5: $seccionbase="herramientas";$seccionbase_name="Herramientas";   break;
        default:   $seccionbase="papel_pintado";$seccionbase_name="Papel pintado"; break;
    }

    $datos_pedido_envio['products'][$kont_productos]['id']=$item_pedido['name'];
    $datos_pedido_envio['products'][$kont_productos]['name']=$item_pedido['id'];
    $datos_pedido_envio['products'][$kont_productos]['category_id']=$item_pedido['category'];
    $datos_pedido_envio['products'][$kont_productos]['category_name']=$seccionbase_name;
    $datos_pedido_envio['products'][$kont_productos]['qty']=$item_pedido['quantity'];
    $datos_pedido_envio['products'][$kont_productos]['unit_price']=$item_pedido['unit_price'];
    /*
    $datos_pedido_envio['products'][$kont_productos]['mpn']=$item_pedido['unit_price'];
    $datos_pedido_envio['products'][$kont_productos]['ean13']=$item_pedido['unit_price'];
    $datos_pedido_envio['products'][$kont_productos]['sku']=$item_pedido['unit_price'];
    $datos_pedido_envio['products'][$kont_productos]['upc']=$item_pedido['unit_price'];
    $datos_pedido_envio['products'][$kont_productos]['url']=$item_pedido['unit_price'];
    */
}


// Prepare data 
$post = array( 
        'api_key' => $apiKey, 
        'orders' => json_encode( 
            array( 
                array( 
                    'id_order' => $datos_resumen_pantalla['acumulado_pedido']['id'], 
                    'order_date' => date('Y-m-d H:i:s'), 
                    'firstname' => $datos_resumen_pantalla['acumulado_pedido']['ord_demo_ship_name'], 
                    'lastname' => '', 
                    'email' => $datos_resumen_pantalla['acumulado_pedido']['ord_demo_email'], 
                    'reference' => '', 
                    'store_id' => 0,
                    'products' => $datos_pedido_envio, 
                ), 
            ), 
        ), 
); 
/*
print '<pre><xmp>';
print_r($post);
print '</xmp></pre>';

echo "<br />dentro api";
*/
// Prepare CURL request 
$ch = curl_init($apiEndPoint); 
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); 
curl_setopt($ch, CURLOPT_POSTFIELDS, $post); 

// Execute CURL request 
$response = curl_exec($ch); 

// Close the connection, release resources used 
curl_close($ch); 

// Do anything you want with your response ! 
//var_dump($response); 


?>