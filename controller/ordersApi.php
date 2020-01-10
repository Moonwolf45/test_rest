<?php
require_once 'config/Api.php';
require_once 'config/Database.php';
require_once 'model/Order.php';

class ordersApi extends Api {
    public $apiName = 'orders';

    public function createAction() {
        $data = json_decode(file_get_contents("php://input"));

        $user_id = 1;
        $amount = $data->amount ?? 0;
        $products = $data->products ?? [];
        if ($user_id && $amount != 0 && !empty($products)) {
            $database = new Database();
            $db = $database->getConnection();
            $order = new Order($db);

            $order->user_id = $user_id;
            $order->amount = $amount;
            $order->products = $products;

            $result = $order->create();

            if ($result['res']) {
                return $this->response($result, 201);
            }

            return $this->response('Error creating order', 500);
        }
        return $this->response("Not enough data", 400);
    }

    public function updateAction() {
        $data = json_decode(file_get_contents("php://input"));

        $order_id = $data->order_id ?? 0;
        $amount = $data->amount ?? 0;
        if ($order_id != 0 && $amount != 0) {
            $database = new Database();
            $db = $database->getConnection();
            $order = new Order($db);

            $order->id = $order_id;
            $order->amount = $amount;

            $result = $order->update();

            if ($result['res']) {
                return $this->response($result, 200);
            }

            return $this->response('Error updating order', 500);
        }
        return $this->response("Not enough data", 400);
    }

    public function indexAction() {
        return $this->response('Method locked', 423);
    }

    public function viewAction() {
        return $this->response('Method locked', 423);
    }

    public function deleteAction() {
        return $this->response('Method locked', 423);
    }
}
