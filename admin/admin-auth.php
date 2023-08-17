<?php
    function admin_is_connected(): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return !empty($_SESSION['admin']); 
    }
    function connect_admin(): void {
        if (!admin_is_connected()) {
            header('Location: login.php');
            exit();
        }
    }
    function disconnect_admin(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['admin']);
    }
?>