<?php
session_start();

function sanitize($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

function hash_password($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

// Check if logged in
function check_login() {
    return isset($_SESSION['user_id']);
}

// Check if admin
function is_admin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Admin access only
function admin_only() {
    if (!is_admin()) {
        header("Location: index.php");
        exit;
    }
}
?>