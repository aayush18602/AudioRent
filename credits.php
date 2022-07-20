<?php 
    session_start(); 
    include_once("connect.php");
    if(!(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true)){
        header("location: login.php");
    }
    if($_SERVER['REQUEST_METHOD'] =="POST"){
        // $_POST['card'];
        $cred =  $_POST['cred'];
        $u_id = $_SESSION['id'];
        $query = "SELECT * FROM user where id=$u_id";
        $res =  mysqli_query($conn,$query);
        $row = mysqli_fetch_assoc($res);
        $cred += $row['Credits'];
        $q1 = "UPDATE user SET Credits=$cred WHERE id=$u_id";
        $res1 = mysqli_query($conn,$q1);
        if($res1){
            echo "<script>alert('Credits Added');</script>";
        }else{
            echo "<script>alert('Unable to add Credits');</script>";
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent Your Audios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/bbc02c6b72.js" crossorigin="anonymous"></script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.html" style="font-size: x-large;"><i class="fas fa-headphones" style="margin-right: 10px;"></i>Flix</a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav test1">
            <?php if(!isset($_SESSION['isLoggedIn'])){?>
              <li class="nav-item test2">
                <a class="nav-link active" aria-current="page" href="login.php">Login</a>
              </li>
              <li class="nav-item test1">
                <a class="nav-link active" href="register.php">Register</a>
              </li>
              
              <?php } ?>
              <li class="nav-item test1">
                <a class="nav-link active" href="profile.php">Profile</a>
              </li>
              <li class="nav-item test1">
                <a class="nav-link active" href="getaudios.php">Browse</a>
              </li>
              <?php if(isset($_SESSION['isLoggedIn'])){?>
                <li class="nav-item test1">
                <a class="nav-link active" href="credits.php">Credits</a>
              </li>
              <li class="nav-item test1">
                <a class="nav-link active" href="logout.php">Logout</a>
              </li>
              <?php } ?>
              <?php if(isset($_SESSION['isAdmin'])){ ?>
              <li class="nav-item test1">
                <a class="nav-link active" href="admin.php">Admin</a>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
    </nav> 
    <div class="container log-box">
            <h1 style="text-align:center;">Credits</h1> <br>
            <form action="" method="post" style="margin: 0 auto; width: 80%;" onsubmit="return validateForm();">
                <!-- <label for="card">Card Number : </label> -->
                <input type="text" name="card" id="card" required class="form-control" placeholder="Card Number">
                <br>
                <input type="number" name="cred" id="cred" class="form-control" placeholder="Amount" required>
                <br>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>
    </div>
    <script>
        function isNumeric(num){
            return !isNaN(num)
        }
        function validateForm(){
            let card = document.getElementById("card").value;
            let amount = document.getElementById("cred").value;
            if(card.length != 12){
                alert('Invalid Card');
                return false;
            }
            if(!isNumeric(card)){
                alert('Invalid Card');
                return false;
            }
            return true;
        }
    </script>
</body>
</html>