<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $task_id = $_POST['task_id'];

    // Check user task count
    $stmt = $conn->prepare("SELECT COUNT(*) as task_count FROM Tasks WHERE assigned_to = ?");
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $task_count = $stmt->get_result()->fetch_assoc()['task_count'];

    if ($task_count < 5) {
        // Assign the task to the user
        $stmt = $conn->prepare("UPDATE Tasks SET assigned_to = ? WHERE id = ?");
        $stmt->bind_param('ii', $user_id, $task_id);

        if ($stmt->execute()) {
            // Fetch the details of the assigned task
            $stmt = $conn->prepare("SELECT task_name, task_description, task_deadline FROM Tasks WHERE id = ?");
            $stmt->bind_param('i', $task_id);
            $stmt->execute();
            $task = $stmt->get_result()->fetch_assoc();

            // Return success message with task details
            echo "<script>
                    alert('Task Assigned Successfully!\\nTask Name: {$task['task_name']}\\nDescription: {$task['task_description']}\\nDeadline: {$task['task_deadline']}');
                    history.back();
                  </script>";
        } else {
            echo "<script>alert('Task Assignment Failed!'); history.back();</script>";
        }
    } else {
        echo "<script>alert('User already has 5 tasks. Please delete a task first.'); history.back();</script>";
    }
}
?>

