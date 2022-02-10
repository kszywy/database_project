<?php
    session_start();
    if ($_SESSION['zalogowany'] != 1){
        header("Location: ../main/login.php");
    }
?>