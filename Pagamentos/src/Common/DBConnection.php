<?php

namespace Implyestudos\Pagamentos\Common;

use PDO;

class DBConnection {
    private $_dbHostname = "localhost";
    private $_dbName = "desafio3_2";
    private $_dbUsername = "postgres";
    private $_dbPassword = "123";

    public function getConnection() {
        try {
            $pdo = new PDO("pgsql:host=" . $this->_dbHostname . ";dbname=" . $this->_dbName, $this->_dbUsername, $this->_dbPassword);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (\PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function runDBConnection() {
        return $this->getConnection();
    }
}
?>