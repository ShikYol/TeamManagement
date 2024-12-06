<?php
session_start();
include 'connect.php';

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["message" => "Unauthorized. Please log in."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_id = $_POST['task_id'];
    $new_status = $_POST['status'];

    // Validate inputs
    if (empty($task_id) || empty($new_status)) {
        echo json_encode(["message" => "Task ID and status are required."]);
        exit;
    }

    // Check if the task belongs to the logged-in user
    $user_id = $_SESSION['user_id'];
    $stmt = $conn->prepare("SELECT id FROM Tasks WHERE id = ? AND assigned_to = ?");
    $stmt->bind_param('ii', $task_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo json_encode(["message" => "Task not found or unauthorized."]);
        exit;
    }

    // Update task status
    $stmt = $conn->prepare("UPDATE Tasks SET status = ? WHERE id = ?");
    $stmt->bind_param('si', $new_status, $task_id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Task status updated successfully."]);
    } else {
        echo json_encode(["message" => "Failed to update task status."]);
    }
}
?>