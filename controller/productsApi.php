<?php

require_once 'config/Api.php';
require_once 'config/Database.php';
require_once 'model/Product.php';

class productsApi extends Api {
    public $apiName = 'products';

    /**
     * @return false|string
     */
    public function indexAction() {
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        $stmt = $product->getAll();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $products = [];

            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $product_item = [
                    "id" => $row['id'],
                    "title" => $row['title'],
                    "price" => $row['price']
                ];
                array_push($products, $product_item);
            }

            return $this->response($products, 200);
        }
        return $this->response('Товары не найдены', 404);
    }

    /**
     * @return false|string
     */
    public function createAction() {
        $database = new Database();
        $db = $database->getConnection();
        $product = new Product($db);

        $stmt = $product->getAll();
        $num = $stmt->rowCount();

        if ($num == 0) {
            if ($product->create()) {
                return $this->response('Products successfully created', 201);
            }

            return $this->response('Error creating products', 500);
        }

        return $this->response("Items already created", 200);
    }

    public function viewAction() {
        return $this->response('Method locked', 423);
    }

    public function updateAction() {
        return $this->response('Method locked', 423);
    }

    public function deleteAction() {
        return $this->response('Method locked', 423);
    }
}
