<?php
class DBConnection {
    private $host = "localhost";  // Change if your database is on a remote server
    private $username = "root";   // Default XAMPP MySQL user
    private $password = "";       // Default XAMPP password (empty)
    private $database = "finderkeeper"; // Change this to match your database name

    public $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->conn->connect_error) {
            die("Database Connection Failed: " . $this->conn->connect_error);
        }
    }
}
?>