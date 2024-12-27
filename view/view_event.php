<?php
require_once '../model/DB.php';  


$db = new DB();
$conn = $db->getConnection(); 


$query = "SELECT * FROM events"; 
$result = $conn->query($query);


if ($result->num_rows > 0) {
    echo '<table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>';
    while ($row = $result->fetch_assoc()) {
        echo '<tr>';
        echo '<td>' . htmlspecialchars($row['EventName']) . '</td>';
        echo '<td>' . htmlspecialchars($row['EventDate']) . '</td>';
        echo '<td>
                <a href="delete_event.php?event_id=' . $row['ID'] . '">Delete</a>
              </td>';
        echo '</tr>';
    }
    echo '</tbody></table>';
} else {
    echo '<p>No events found</p>';
}


$db->closeConnection();
?>
