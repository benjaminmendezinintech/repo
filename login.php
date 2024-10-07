<?php
session_start();
require_once 'includes/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $user = validate_user($username, $password);
    if ($user) {
        $_SESSION['user'] = $username;
        $user_info = get_user_info($username);
        $_SESSION['user_info'] = $user_info;
        header("Location: dashboard.php");
        exit();
    } else {
        header("Location: index.php?error=1");
        exit();
    }
}
?>