<?php
include 'connect.php';

$query = "SELECT id, task_name FROM Tasks WHERE task_state = 'Unassigned'";
$result = $conn->query($query);

$tasks = [];
while ($row = $result->fetch_assoc()) {
    $tasks[] = $row;
}

echo json_encode($tasks);
?>
