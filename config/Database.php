<?php
    // create db object
    class Database {
        //Set variables
        private $host;
        private $port;
        private $db_name;
        private $username;
        private $password;
        private $conn;

        // get data from env variables
        public function __construct() {
            $this->username = getenv('USERNAME');
            $this->password = getenv('PASSWORD');
            $this->db_name = getenv('DBNAME');
            $this->host = getenv('HOST');
            $this->port = getenv('PORT');
        }

        // create connection
        public function connect() {
            $this->conn = null;
            $dsn = "pgsql:host={$this->host};port={$this->port};dbname={$this->db_name}";

            // build PDO
            try {

                $this->conn = new PDO($dsn, $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            }
            // if PDO errors
            catch (PDOException $e){
                echo 'Connect Error '. $e->getMessage();

            }
             return $this->conn;

        }
    }
