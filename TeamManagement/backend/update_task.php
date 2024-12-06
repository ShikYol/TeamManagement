<?php
session_start(); // Start session for user authentication
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('Unauthorized Access! Please log in.'); window.location.href='../frontend/signin.html';</script>";
        exit;
    }

    $user_id = $_SESSION['user_id']; // Logged-in user's ID
    $task_id = $_POST['task_id'];
    $status = $_POST['status'];
    $task_name = $_POST['task_name']; // New task name
    $task_description = $_POST['task_description']; // New task description
    $task_deadline = $_POST['task_deadline']; // New task deadline

    // Check if the task belongs to the logged-in user
    $stmt = $conn->prepare("SELECT id FROM Tasks WHERE id = ? AND assigned_to = ?");
    $stmt->bind_param('ii', $task_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Task not found or unauthorized access.'); history.back();</script>";
        exit;
    }

    // Update the task details
    $stmt = $conn->prepare("UPDATE Tasks SET status = ?, task_name = ?, task_description = ?, task_deadline = ? WHERE id = ? AND assigned_to = ?");
    $stmt->bind_param('sssiii', $status, $task_name, $task_description, $task_deadline, $task_id, $user_id);

    if ($stmt->execute()) {
        echo "<script>alert('Task Updated Successfully!'); history.back();</script>";
    } else {
        echo "<script>alert('Task Update Failed!'); history.back();</script>";
    }
}
?>