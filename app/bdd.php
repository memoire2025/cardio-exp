<?php
    
    class Database {
        private $connection;

        public function __construct($config) {
            $this->connection = new PDO(
                "mysql:host={$config['host']};dbname={$config['dbname']}",
                $config['username'],
                $config['password']
            );
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }

        public function getConnection() {
            return $this->connection;
        }
    }
?>