<?php
    include_once("connect.php");
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $username = $_POST['Us_name'];
        $password = $_POST['pass'];
        $name = $_POST['F_name'];
        $email = $_POST['Email'];

        $query = "INSERT INTO user (Username,Password,Name,Email) VALUES ('$username','$password','$name','$email')";
        if(mysqli_query($conn,$query)){
            echo "Added";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INSERT</title>
</head>
<style>
    input{
        margin: 10px;
    }
</style>
<body>
    <form action="" method="post">
        <input type="text" name="Us_name" id="" placeholder="Pic0" required> <br>
        <input type="password" name="pass" id="" placeholder="abcd123" required> <br>
        <input type="text" name="F_name" id="" placeholder="Aayush" required> <br>
        <input type="email" name="Email" id="" placeholder="aasudhd@gmail.com" required> <br>
        <input type="submit" value="Register">
    </form>
</body>
</html>