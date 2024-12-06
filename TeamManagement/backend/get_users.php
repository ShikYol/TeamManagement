<?php
include 'connect.php';

$query = "SELECT id, first_name, last_name FROM Users WHERE role = 'GeneralUser'";
$result = $conn->query($query);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode($users);
?>
