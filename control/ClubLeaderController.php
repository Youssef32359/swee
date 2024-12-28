<?php
require_once '../model/DB.php';

class ClubLeaderController {
    private $conn;

    public function __construct($conn) {
        if ($conn == null) {
            throw new Exception("Database connection is not initialized.");
        }
        $this->conn = $conn;
    }

    // Method to create an event
    public function createEvent($title, $description,  $time, $location, $member_limit, $created_by) {
        $query = "INSERT INTO events (title, description, time, location, member_limit, created_by)
                  VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssii", $title, $description, $time, $location, $member_limit, $created_by);
        if ($stmt->execute()) {
            return "Event created successfully!";
        } else {
            return "Error creating event: " . $this->conn->error;
        }
    }

    // Method to edit an event
    public function editEvent($id, $title, $description,  $time, $location, $member_limit) {
        $query = "UPDATE events SET title = ?, description = ?, time = ?, location = ?, member_limit = ?
                  WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("ssssii", $title, $description, $time, $location, $member_limit, $id);

        if ($stmt->execute()) {
            return "Event updated successfully!";
        } else {
            return "Error updating event: " . $this->conn->error;
        }
    }

    // Method to get events created by the current club leader
    public function getEventsByCreator($creator_id) {
        $query = "SELECT * FROM events WHERE created_by = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $creator_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getEventById($event_id) {
        $query = "SELECT * FROM events WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_assoc(); // Return the event details as an associative array
        } else {
            return null; // Event not found
        }
    }

    // Method to get participants for a specific event
    public function getParticipants($event_id) {
        $query = "SELECT u.id, u.fullname, u.email FROM participants p
                  JOIN users u ON p.user_id = u.id
                  WHERE p.event_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $event_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function deleteEvent($event_id) {
        $query = "DELETE FROM events WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $event_id);
    
        if ($stmt->execute()) {
            return "Event deleted successfully!";
        } else {
            return "Error deleting event: " . $this->conn->error;
        }
    }
}

