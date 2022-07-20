<?php
    session_start();
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
              <?php if(isset($_SESSION['isAdmin'])){ ?>
              <li class="nav-item test1">
                <a class="nav-link active" href="admin.php">Admin</a>
              </li>
              <?php } ?>
            </ul>
          </div>
        </div>
      </nav>

    <div class="container-fluid">
        <div class="index-content">
            <div class="index-left">
                <h1>Grab the best AudioBooks!!</h1> <br>
               <p>Audios are great source to improve focus and your attention span by learning immense knowledge. Get your Favourite audios by renting it at the best cost.</p>
            </div>
            <div class="index-right">
                <img src="musicalnote.jpg" alt="" style="width: 70%;" >
            </div>
        </div>
        <div class="started-btn">
            <button><a href="getaudios.php" id="hover-btn">Get Audios</a></button>
        </div>
    </div>
</body>
<script>
  console.log("Hi");
  const ele = document.querySelector('#hover-btn');
  console.log(ele);
  ele.onmouseover = () =>{
    ele.innerHTML = 'Yesss Now!!';
  }
  ele.onmouseleave = () =>{
    ele.innerHTML = 'Get Audios';
  }
</script>
</html>