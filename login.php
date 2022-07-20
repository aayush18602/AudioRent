<?php
    session_start();
    if(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true){
        header("location: index.php");
    }
    include_once("connect.php");
    if($_SERVER['REQUEST_METHOD']=="POST"){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $query = "SELECT * FROM user where Username='$username'";
        $res = mysqli_query($conn,$query);
        if(mysqli_num_rows($res) == 0){
            echo "<script>alert('Username does not exist!');</script>";
        }else{
            $row = mysqli_fetch_assoc($res);
        if(password_verify($password,$row['Password'])){
          if(isset($_POST['checkbox'])){
            setcookie("username",$username,time()+(7*24*60*60));
            setcookie("password",$password,time()+(7*24*60*60));
          }else{
            setcookie("username","");
            setcookie("password","");
          }
            session_start();

            
            $_SESSION['isLoggedIn'] = true;
            $_SESSION['id'] = $row['id'];
            $_SESSION['username'] = $row['Username'];
            header("location: index.php");
        }else{
            echo "<script>alert('Wrong password!');</script>";
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
    <title>Login</title>
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
            <?php if(!isset($_SESSION['isLoggedIn'])) {?>
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
            </ul>
          </div>
        </div>
      </nav>  
    <div class="container log-box">
      <h1 style="text-align: center;">Login</h1>
        <form style="margin: 0 auto; width: 90%;" name="logform" onsubmit="return formsubmit()" method="POST">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Username</label>
                <input type="text" class="form-control" id="exampleInputEmail1" name="username" value="<?php if(isset($_COOKIE['username'])) {echo $_COOKIE['username'];} ?>">
              </div>
            <div class="mb-3">
              <label for="exampleInputPassword1" class="form-label">Password</label>
              <input type="password" class="form-control" id="exampleInputPassword1" name="password" value="<?php if(isset($_COOKIE['password'])) {echo $_COOKIE['password'];} ?>">
            </div>
            <div class="mb-3 form-check">
              <input type="checkbox" class="form-check-input" id="exampleCheck1" name="checkbox" <?php if(isset($_COOKIE['username'])) {?> checked<?php }?>>
              <label class="form-check-label" for="exampleCheck1" >Remeber Me</label>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
            <br> <br>
            <a href="adminlogin.php" style="text-decoration:none;font-weight:bold;">Admin Login</a>
          </form>
    </div>
    <script>
      function formsubmit(){
        const username = document.forms['logform']['username'];
        const password = document.forms['logform']['password'];
        if(username.value == "")
        {
          alert("Please fill your username!!");
          username.focus();
          return false;
        }
        if(password.value == "")
        {
          alert("Please fill your password!!");
          password.focus();
          return false;
        }
        return true;
      }
      const useblur = document.querySelector('#exampleInputEmail1');
      useblur.onblur = ()=>{
        const username = document.forms['logform']['username'];
        if(username.value==""){
          alert('Username is empty!!');
        }
      }
    </script>
</body>
</html>