<?php
    session_start();
    include_once("connect.php");
    if(!(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true)){
        header("location: login.php");
    }
    if(!isset($_GET['id'])){
        header("location: getaudios.php");
    }
    $a_id = $_GET['id'];
    $u_id = $_SESSION['id'];
    $q = "SELECT * FROM audio WHERE audio_id=$a_id";
    $res = mysqli_query($conn,$q);
    $row = mysqli_fetch_assoc($res);
    $pref = $row['Categories'];
    if(mysqli_num_rows($res) == 0){
        header("location: getaudios.php");
    }
    $query = "SELECT * FROM rents where user_id=$u_id AND audio_id=$a_id";
    $res1 = mysqli_query($conn,$query);
    if(mysqli_num_rows($res1)!=0){
        header("location:profile.php");
    }else{
        if($_SERVER['REQUEST_METHOD'] == "POST"){
          $rentfee = $_POST['rent'];
          $u_id = $_SESSION['id'];
          $q1 = "SELECT * FROM user WHERE id=$u_id";
          $res12 = mysqli_query($conn,$q1);
          $roww = mysqli_fetch_assoc($res12);
          if($rentfee < $roww['Credits']){
            $diff  = intval($roww['Credits']) - intval($rentfee);
            $x = "UPDATE user SET Credits = $diff,Preferences='$pref' WHERE id=$u_id";
            $resultss = mysqli_query($conn,$x);
            $gdate = $_POST['date'];
            $qu = "INSERT INTO rents (date_field,user_id,audio_id) VALUES ('$gdate',$u_id,$a_id)";
            $res2 = mysqli_query($conn,$qu);
            if($res2){
                header("location:profile.php");
            }
          }else{
            echo "<script>alert('You do not have enough credits');</script>";
          }
          
      }
        
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AudioFlix</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/bbc02c6b72.js" crossorigin="anonymous"></script>
    <style>
      .index-left{
        text-align: center;
      }
      #rent{
        border: none;
      }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
          <a class="navbar-brand" href="index.php" style="font-size: x-large;"><i class="fas fa-headphones" style="margin-right: 10px;"></i>Flix</a>
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
              <?php if(isset($_SESSION['isLoggedIn'])){ ?>
                <li class="nav-item test1">
                <a class="nav-link active" href="credits.php">Credits</a>
              </li>
              <li class="nav-item test1">
                <a class="nav-link active" href="logout.php">Logout</a>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </nav>
      <div class="container" style="display: flex;">
      <div class="container log-box" style="margin: 10% 30%;">
      <h1 style="text-align: center;">Rent</h1>
        <form style="margin: 0 auto; width: 90%;" name="logform" onsubmit="return formsubmit()" method="POST">
            <div class="mb-3">
            <label class="form-label">Choose last day</label>
            <input type="date" name="date" class="form-control" required id="getdate" onchange="throwprice();">
            <div class="mb-3" style="margin: 15px 2px;">
                <h6>Audio Name: <?php echo $row['Name']; ?></h6>
            </div>
            <div class="mb-3" style="margin: 15px 2px;">
                <label for="rent" class="form-label">Rent fee : </label>
                <input type="number" name="rent" id="rent" readonly>
            </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
          </form>
    </div>
   
      </div>
    <script>
        function formsubmit(){
            // const cardnum = document.querySelector('#card-num').value;
            const getdate = document.querySelector('#getdate').value;
            const gdate = new Date(getdate);
            const cdate = new Date();
            
            if(gdate <= cdate){
                alert('End date should be greater than last date');
                return false;
            }
            const diff = Math.ceil((gdate - cdate)/(1000*60*60*24));
            if(diff > 7){
                alert("You can't rent audio for more than 7 days!");
                return false;
            }
            return true;
        }
        function throwprice(){
          const getdate = document.querySelector('#getdate').value;
          const gdate = new Date(getdate);
          const cdate = new Date();
          const diff = Math.ceil((gdate - cdate)/(1000*60*60*24));
          const rent = document.querySelector('#rent');
          console.log(rent);
          rent.value = diff*10;
        }
    </script>
</body>

</html>