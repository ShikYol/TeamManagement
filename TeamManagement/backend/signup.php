<?php
include 'connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $role = $_POST['role'];
    $preset_password = $_POST['preset_password'] ?? '';

    if ($role === 'AdminUser') {
        $result = $conn->query("SELECT preset_password FROM AdminPresetPin LIMIT 1");
        $preset = $result->fetch_assoc()['preset_password'];

        if ($preset_password !== $preset) {
            echo "<script>alert('Invalid Admin Password!'); history.back();</script>";
            exit;
        }
    }

    $stmt = $conn->prepare("INSERT INTO Users (first_name, last_name, username, password, role) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param('sssss', $first_name, $last_name, $username, $password, $role);

    if ($stmt->execute()) {
        echo "<script>alert('Sign Up Successful!'); window.location.href='../frontend/signin.html';</script>";
    } else {
        echo "<script>alert('Sign Up Failed!'); history.back();</script>";
    }
}
?>
