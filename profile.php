<?php
    session_start();
    include_once("connect.php");
    if(!(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true)){
        header("location: login.php");
    }
    $username = $_SESSION['username'];
    $query = "SELECT * FROM user where Username='$username'";
    $res = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($res);
    if(mysqli_num_rows($res) == 0){
      $username = $_SESSION['username'];
      $query = "SELECT * FROM admin where Username='$username'";
      $res = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($res);
    }
    $u_id = $_SESSION['id'];
    $qu = "SELECT * FROM rents WHERE user_id=$u_id";
    $res1 = mysqli_query($conn,$qu);
    $dates_array = array();
    $a_name = array();
    $a_text = array();
    $a_thumbnail = array();
    $a_audio = array();
    while($row1 = mysqli_fetch_assoc($res1)){
      $a_id = $row1['audio_id'];
      $getdate = $row1['date_field'];
      $exp = explode("-",$getdate);
      $d = mktime(0,0,0,$exp[1],$exp[2],$exp[0]);
      $date = date("Y-m-d",$d);
      $currdate = date("Y-m-d");
      // echo "<script>alert('$currdate');</script>";
      if($currdate > $date) {
        $rowid = $row1['rent_id'];
        $q3 = "DELETE FROM rents WHERE rent_id = $rowid";
        if(!mysqli_query($conn,$q3)) {
            echo "<script>alert('Error);</script>";
        }
      }
      else{
        array_push($dates_array,$row1['date_field']);
        $q2 = "SELECT * FROM audio WHERE audio_id=$a_id";
        $r11 = mysqli_query($conn,$q2);
        $row2 = mysqli_fetch_assoc($r11);
        array_push($a_name,$row2['Name']);
        array_push($a_text,$row2['Header']);
        array_push($a_thumbnail,$row2['Thumbnail']);
        array_push($a_audio,$row2['Filepath']);
      }
      

    }
    if($_SERVER['REQUEST_METHOD']=="POST"){
        if(isset($_POST['name_btn'])){
          $name = $_POST['getname'];
          $q1 = "UPDATE user set Name = '$name' WHERE Username='$username'";
          if(!(mysqli_query($conn,$q1))){
              echo "<script>alert('Error');</script>";
          }else{
              header("location: profile.php");
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
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/bbc02c6b72.js" crossorigin="anonymous"></script>
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
    <h1 style="text-align: center; margin-top: 15px;">Profile</h1>
    <div class="profile-box" style="font-weight: bolder;margin:40px">
        <div class="username-box">
            <p style="margin-bottom: 5px;"> Username:&nbsp; <?php echo $row["Username"]; ?> </p>
            <p style="margin-bottom: 5px;"> Email:&nbsp; <?php echo $row["Email"]; ?> </p>
            <p style="margin-bottom: 5px;"> Credits:&nbsp; <?php echo $row["Credits"]; ?> </p>
            <form action="" method="post">
                Name: <input type="text" required name="getname" value="<?php echo $row['Name'];?>">&nbsp;&nbsp; <input type="submit" value="Add" name="name_btn">
            </form>
        </div>
    </div>
    <h1 style="text-align: center;">Your Rented audios</h1>
    <?php for($i=0;$i<count($dates_array);$i++) { ?>
    <div class="card" style="width: 18rem; display: inline-block; margin: 30px 50px;">
        <img src="<?php echo $a_thumbnail[$i]; ?>" class="card-img-top" alt="..." style="height: 250px;" > 
        <div class="card-body">
          <h5 class="card-title"><?php echo $a_name[$i]; ?></h5>
          <p class="card-text"><?php echo $a_text[$i]; ?></p>
          <!-- <a href="#" class="btn btn-primary">Watch</a> -->
          <audio controls style="width: 95%;">
            <source src="<?php echo $a_audio[$i];?>">
          </audio>
          <p class="card-text">Last Day: <?php echo $dates_array[$i];?></p>
        </div>
    </div>
    <?php } ?>

<script>
  const val = document.querySelectorAll('.card');
  for(let i=0;i<val.length;i++)
  {
    val[i].onmouseenter = ()=>{
      val[i].style.width = '20rem';
      val[i].style.boxShadow = "10px 10px 10px 10px #515254";
    }
    val[i].onmouseleave = ()=>{
      val[i].style.width = '18rem';
      val[i].style.boxShadow = "0px 0px 0px 0px black";
    }
  }
</script>
</body>
</html>