<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Envía un pedido a la API de Sociedad de Opiniones Contrastadas
 * para que soliciten una reseña al cliente
 *
 * @param string $order_number Número de pedido
 * @param string $order_date Fecha del pedido (YYYY-MM-DD HH:MM:SS)
 * @param string $email Email del cliente
 * @param string $firstname Nombre del cliente
 * @param string $lastname Apellido del cliente
 * @param array $products Array de productos [{id, name, qty, unit_price, sku, url}]
 * @return array|false Respuesta de la API o false si falla
 */
function enviar_pedido_resenas($order_number, $order_date, $email, $firstname, $lastname, $products = array())
{
    $apiEndPoint = "https://api.guaranteed-reviews.com/private/v3/orders";
    $apiKey = "13436/es/c448df73319ce03e9ec8cca4002e7a41a71a29dbefeb017480a84c785f5224a5";

    // Preparar productos
    $api_products = array();
    foreach ($products as $p) {
        $api_products[] = array(
            'id' => isset($p['id']) ? $p['id'] : '',
            'name' => isset($p['name']) ? $p['name'] : '',
            'qty' => isset($p['qty']) ? $p['qty'] : 1,
            'unit_price' => isset($p['unit_price']) ? $p['unit_price'] : 0,
            'sku' => isset($p['sku']) ? $p['sku'] : '',
            'url' => isset($p['url']) ? $p['url'] : '',
        );
    }

    $post = array(
        'api_key' => $apiKey,
        'orders' => json_encode(
            array(
                array(
                    'id_order' => $order_number,
                    'order_date' => $order_date,
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'email' => $email,
                    'reference' => $order_number,
                    'store_id' => 0,
                    'products' => $api_products,
                ),
            )
        ),
    );

    $ch = curl_init($apiEndPoint);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $response = curl_exec($ch);
    curl_close($ch);

    if ($response) {
        return json_decode($response, true);
    }

    return false;
}
