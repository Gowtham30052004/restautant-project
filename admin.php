<?php
class SessionManager {
    public function startSession() {
        session_start();
        if (!isset($_SESSION['name'])) {
            header('Location: userlogin.php');
            exit();
        }
    }

    public function logoutIfRequested() {
        if (isset($_POST['logout'])) {
            session_destroy();
            header("Location: userlogin.php");
            exit();
        }
    }

    public function getUserName() {
        return $_SESSION['name'] ?? 'Guest';
    }
}
?>
