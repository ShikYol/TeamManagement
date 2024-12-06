<?php
session_start();
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password, role FROM Users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result && password_verify($password, $result['password'])) {
        $_SESSION['user_id'] = $result['id'];
        $_SESSION['role'] = $result['role'];

        if ($result['role'] === 'AdminUser') {
            header("Location: ../frontend/admin_dashboard.html");
        } else {
            header("Location: ../frontend/user_dashboard.html");
        }
    } else {
        echo "<script>alert('Invalid username or password!'); history.back();</script>";
    }
}
?>
