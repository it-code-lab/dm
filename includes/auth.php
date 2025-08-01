<?php
function requireLogin() {
    session_start();
    if (!isset($_SESSION['user_id'])) {
        $_SESSION['redirect_after_login'] = $_SERVER['REQUEST_URI'];
        header("Location: login.php");
        exit();
    }
}

function requireAdmin() {
    if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
        header('Location: login.php');
        exit;
    }
}

function requireAdminAndLoginFromParent() {
    if (!isset($_SESSION['is_admin']) || !$_SESSION['is_admin']) {
        header('Location: ../login.php');
        exit;
    }
}

function isAdmin()
{
    // Example: check if the logged-in user has admin role
    return isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true;

}

function isLoggedIn()
{
    // Example: check if the user is logged in
    return isset($_SESSION['user_id']);
}
?>
