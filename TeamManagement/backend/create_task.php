<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["message" => "Unauthorized. Please log in."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $task_name = $_POST['task_name'];
    $task_description = $_POST['task_description'];
    $task_deadline = $_POST['task_deadline'];

    // Validate inputs
    if (empty($task_name) || empty($task_description) || empty($task_deadline)) {
        echo json_encode(["message" => "All fields are required."]);
        exit;
    }

    if ($task_deadline < 1 || $task_deadline > 10) {
        echo json_encode(["message" => "Deadline must be between 1 and 10."]);
        exit;
    }

    // Insert the new task as "Unassigned"
    $stmt = $conn->prepare("INSERT INTO Tasks (task_name, task_description, task_deadline, task_state) VALUES (?, ?, ?, 'Unassigned')");
    $stmt->bind_param('ssi', $task_name, $task_description, $task_deadline);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Task created successfully."]);
    } else {
        echo json_encode(["message" => "Failed to create task."]);
    }
}
?>