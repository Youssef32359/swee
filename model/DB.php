<?php
class DB {
    private $host = "localhost"; 
    private $username = "root";  
    private $password = "";  
    private $db_name = "student_activity_management";  
    public $conn;
   
    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db_name);
            if ($this->conn->connect_error) {
                die("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            echo "Connection error: " . $e->getMessage();
        }
        return $this->conn;
    }
}
?>