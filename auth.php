<?php
    function is_connected (): bool {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return !empty($_SESSION['login']); 
    }
    function connect_user(): void {
        if (!is_connected()) {
            header('Location: login.php');
            exit();
        }
    }
    function disconnect_session(): void {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        unset($_SESSION['login']);
    }

?>