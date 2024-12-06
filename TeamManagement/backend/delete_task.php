<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];

    $stmt = $conn->prepare("DELETE FROM Tasks WHERE id = ?");
    $stmt->bind_param('i', $task_id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Task deleted successfully"]);
    } else {
        echo json_encode(["message" => "Failed to delete task"]);
    }
}
?>