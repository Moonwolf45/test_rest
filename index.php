<?php

require_once 'controller/productsApi.php';
require_once 'controller/ordersApi.php';

try {
    $nameApi = explode('/', trim($_SERVER['REQUEST_URI'],'/'));
    if ($nameApi[1] == 'products') {
        $api = new productsApi();
        echo $api->run();
    } elseif ($nameApi[1] == 'orders') {
        $api = new ordersApi();
        echo $api->run();
    }
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}

