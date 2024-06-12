<?php
//A database model that connects to a mysql database
class Database {
    private $envPath = '.env';
    private $host ;
    private $user ;
    private $pass ;
    private $name ;
    private $conn;

    public function __construct() {
        $this->loadEnv();
        $this->host = getenv('DB_HOST');
        $this->user = getenv('DB_USER');
        $this->pass = getenv('DB_PASS');
        $this->name = getenv('DB_NAME');
        $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->name);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function query($sql) {
        return $this->conn->query($sql);
    }
    //Function to allow parameterized queries
    public function prepare($sql) {
        return $this->conn->prepare($sql);
    }

    public function __destruct() {
        $this->conn->close();
    }
    private function loadEnv() {
        if (!file_exists($this->envPath)) {
            echo 'The .env file does not exist';
            return;
        }
    
        $lines = file($this->envPath, FILE_IGNORE_NEW_LINES);
        foreach ($lines as $line) {
            if (trim($line) == '' || $this->starts_with($line, '#')) {
                continue;
            }
    
            list($name, $value) = explode('=', $line, 2);
            putenv(trim($name) . '=' . trim($value));
        }
    }
    
    function starts_with($haystack, $needle) {
        return substr_compare($haystack, $needle, 0, strlen($needle)) === 0;
    }
}

new Database();