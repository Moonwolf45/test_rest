<?php


class Database {

    private $host = "localhost";
    private $db_name = "restapi";
    private $username = "rest";
    private $password = "msoOkE4j73PNAvPB";
    private $driver = [PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES `utf8`'];
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username,
                $this->password, $this->driver);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
