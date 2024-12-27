<?php
class DB {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "student_activity_management";
    private $connection;

    // Singleton pattern to ensure a single connection instance
    public function getConnection() {
        if ($this->connection === null) {
            try {
                $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

                // Check for connection errors
                if ($this->connection->connect_error) {
                    die("Connection failed: " . $this->connection->connect_error);
                }
            } catch (Exception $e) {
                echo "Connection error: " . $e->getMessage();
            }
        }

        return $this->connection;
    }

    // Method to close the database connection
    public function closeConnection() {
        if ($this->connection !== null) {
            $this->connection->close();
            $this->connection = null;
        }
    }
}
?>