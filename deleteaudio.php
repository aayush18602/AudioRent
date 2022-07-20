<?php
    include_once("connect.php");
    session_start(); 
    if(!$_SESSION['isAdmin']){
        header("location: index.php");
    }
    $id = $_GET['del_id'];
    // echo $id;
    $query = "DELETE FROM audio WHERE audio_id=$id";
    $res = mysqli_query($conn, $query);
    header("location: admin.php")
?>