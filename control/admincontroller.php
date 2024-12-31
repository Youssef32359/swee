<?php
require_once __DIR__ . '/../model/DB.php';

class AdminController {
    private $conn;

    public function __construct() {
        $db = DB::getInstance();
        $this->conn = $db->getConnection();
    }

    public function getAllUsers() {
        $stmt = $this->conn->prepare("SELECT id, fullname, email, role FROM users");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createUser($fullname, $email, $password, $mobile, $role) {
        $stmt = $this->conn->prepare("INSERT INTO users (fullname, email, password, mobile, role) VALUES (?, ?, ?, ?, ?)");
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt->bind_param("sssss", $fullname, $email, $hashedPassword, $mobile, $role);

        if ($stmt->execute()) {
            return "User successfully created!";
        } else {
            return "Error creating user: " . $stmt->error;
        }
    }

    public function deleteUser($userId) {
        $stmt = $this->conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $userId);

        if ($stmt->execute()) {
            return "User successfully deleted!";
        } else {
            return "Error deleting user: " . $stmt->error;
        }
    }

    public function getAllEvents() {
        $stmt = $this->conn->prepare("SELECT id, title, description, time, location, member_limit FROM events");
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function createEvent($title, $description, $time, $location, $member_limit, $created_by) {
        $stmt = $this->conn->prepare("INSERT INTO events (title, description, time, location, member_limit, created_by) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssii", $title, $description, $time, $location, $member_limit, $created_by);

        if ($stmt->execute()) {
            return "Event successfully created!";
        } else {
            return "Error creating event: " . $stmt->error;
        }
    }

    public function deleteEvent($eventId) {
        $stmt = $this->conn->prepare("DELETE FROM events WHERE id = ?");
        $stmt->bind_param("i", $eventId);

        if ($stmt->execute()) {
            return "Event successfully deleted!";
        } else {
            return "Error deleting event: " . $stmt->error;
        }
    }

    public function generateReport($type) {
        $filename = '';
        $data = [];
        $headers = [];

        if ($type === 'users') {
            $filename = 'users_report_' . date('Ymd') . '.csv';
            $stmt = $this->conn->prepare("SELECT id, fullname, email, role FROM users");
            $stmt->execute();
            $result = $stmt->get_result();
            $headers = ['ID', 'Full Name', 'Email', 'Role'];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        } elseif ($type === 'events') {
            $filename = 'events_report_' . date('Ymd') . '.csv';
            $stmt = $this->conn->prepare("SELECT id, title, description, time, location, member_limit, created_by FROM events");
            $stmt->execute();
            $result = $stmt->get_result();
            $headers = ['ID', 'Title', 'Description', 'Time', 'Location', 'Member Limit', 'Created By'];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }

        if (!empty($filename)) {
            header('Content-Type: text/csv');
            header('Content-Disposition: attachment; filename="' . $filename . '"');
            $output = fopen('php://output', 'w');
            fputcsv($output, $headers);
            foreach ($data as $row) {
                fputcsv($output, $row);
            }
            fclose($output);
            exit;
        } else {
            return "Invalid report type selected.";
        }
    }
}
?>