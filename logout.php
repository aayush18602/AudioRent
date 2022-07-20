<?php
    session_start();
    if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true){
        $_SESSION = array();
        session_destroy();
        header("location: login.php");
    }else{
        header("location: index.php");
    }
?>