<?php
    if (isset($_POST['logout'])) {
        $_SESSION =  array();
        session_destroy();
        header("Location: ../main/login.php");
    }
?>