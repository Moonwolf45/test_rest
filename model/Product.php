<?php

class Product {

    private $conn;
    private $table_name = "products";

    public $id;
    public $title;
    public $price;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll () {
        $query = "SELECT * FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }

    public function create() {
        try {
            $this->conn->beginTransaction();
            for ($p = 1; $p <= 20; $p++) {
                $query = "INSERT INTO " . $this->table_name . " SET title=:title, price=:price";

                $stmt = $this->conn->prepare($query);

                $stmt->execute([':title' => 'Товар_' . $p, ':price' => rand(1, 10000)]);
            }
        } catch (PDOException $e) {
            $this->conn->rollBack();
            echo 'PDOException: ' . $e->getCode() . '|' . $e->getMessage();
            return false;
        }
        $this->conn->commit();
        return true;
    }

}
