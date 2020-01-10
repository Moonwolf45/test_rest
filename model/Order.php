<?php

class Order {

    private $conn;
    private $table_name = "orders";

    public $id;
    public $user_id;
    public $amount;
    public $status;
    public $products;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        try {
            $this->conn->beginTransaction();

            $order = $this->conn->prepare("INSERT INTO " . $this->table_name . " SET user_id=:user_id, amount=:amount, 
                status=:status");

            $order->execute([
                'user_id' => htmlspecialchars(strip_tags($this->user_id)),
                'amount' => htmlspecialchars(strip_tags($this->amount)),
                'status' => 1
            ]);

            $orderId = $this->conn->lastInsertId();

            foreach ($this->products as $product) {
                $query = "INSERT INTO `orders_product` SET order_id=:order_id, product_id=:product_id, quantity=:quantity";
                $stmt = $this->conn->prepare($query);

                $stmt->execute([':order_id' => $orderId, ':product_id' => htmlspecialchars(strip_tags($product->product_id)),
                    ':quantity' => htmlspecialchars(strip_tags($product->quantity))]);
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo 'PDOException: ' . $e->getCode() . '|' . $e->getMessage();
            return false;
        }
        $this->conn->commit();
        return ['res' => true, 'id' => $orderId, 'status' => 1];
    }

    public function update() {
        $order = $this->conn->prepare("SELECT * FROM " . $this->table_name . " WHERE id=:id");
        $order->execute([
            'id' => htmlspecialchars(strip_tags($this->id))
        ]);
        $row = $order->fetch(PDO::FETCH_ASSOC);
        $code = '';
        if ($row['amount'] == htmlspecialchars(strip_tags($this->amount)) && $row['status'] == 1) {
            $request = curl_init();
            curl_setopt($request, CURLOPT_URL, "https://ya.ru/");
            curl_setopt($request, CURLOPT_RETURNTRANSFER, 1);
            curl_exec($request);
            $code = curl_getinfo ($request, CURLINFO_HTTP_CODE);
            curl_close($request);
        }

        if ($code == 200) {
            $order = $this->conn->prepare("UPDATE " . $this->table_name . " SET status=:status WHERE id=:id");

            $order->execute([
                'id' => htmlspecialchars(strip_tags($this->id)),
                'status' => 2
            ]);
            return ['res' => true];
        }

        return ['res' => false];
    }

}
