<?php 
    session_start();
    include_once("connect.php");
    if(!(isset($_SESSION['isLoggedIn']) && $_SESSION['isLoggedIn'] == true)){
        header("location: login.php");
    }
    $query = "SELECT * FROM audio ORDER BY name";
    $f = 0;
    if($_SERVER['REQUEST_METHOD']=="POST"){
      if($_POST['sort'] == "DESC"){
        $query = "SELECT * FROM audio ORDER BY name DESC";
        $f = 1;
      }
    }
    $res = mysqli_query($conn,$query);
    $u_id = $_SESSION['id'];
    $q1 = "SELECT * FROM user WHERE id = $u_id";
    $r1 = mysqli_query($conn,$q1);
    $row1 = mysqli_fetch_assoc($r1);
    $pref = $row1['Preferences'];
    $val = false;
    if($pref == ""){
      $val = true;
    }
      $q2 = "SELECT * FROM audio WHERE Categories = '$pref'";
      $res1 = mysqli_query($conn,$q2);

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
    <h1 style="text-align:center; margin-top: 20px;">Audios</h1>
    <br>
    <div class="sort-body container">
      <form action="" method="post">
        <label for="sort">Sort by:</label>
        <select name="sort" id="sort">
          <option value="ASC" <?php if($f==0) echo "selected"; ?>>A-Z</option>
          <option value="DESC" <?php if($f==1) echo "selected"; ?>>Z-A</option>
        </select>
        <input type="submit" value="Go">
      </form>
    </div>
    <div class="container-fluid moba">
        <!-- <a href="#" >Podcast by Ranveer Show</a> <br> <br>
        <a href="#">Warickoo Podcast</a> <br> <br>
        <a href="#">Honestly by tanmay bhatt</a> <br> <br> -->
        <?php while($row=mysqli_fetch_assoc($res)) { ?>
        <div class="card browse-card" style="width: 18rem; display: inline-block; ">
            <img src="<?php echo $row['Thumbnail'];?>" class="card-img-top" alt="..." style="height: 250px;" > 
            <div class="card-body">
              <h5 class="card-title"><?php echo $row['Name']?></h5>
              <p class="card-text"><?php echo $row['Header']; ?></p>
              <a href="rent.php?id=<?php echo $row['audio_id'] ?>" class="btn btn-primary">Get It</a>
            </div>
        </div>
        <?php } ?>
        
       <!-- <div class="log-box"> -->
         <?php
          if(mysqli_num_rows($res1) !=0){
          ?>
          <h1 style="text-align:center;">You may also like</h1>
          <?php
            while($row3 = mysqli_fetch_assoc($res1) ){
         ?>
          <div class="card browse-card" style="width: 18rem; display: inline-block; ">
            <img src="<?php echo $row3['Thumbnail'];?>" class="card-img-top" alt="..." style="height: 250px;" > 
            <div class="card-body">
              <h5 class="card-title"><?php echo $row3['Name']?></h5>
              <p class="card-text"><?php echo $row3['Header']; ?></p>
              <a href="rent.php?id=<?php echo $row3['audio_id'] ?>" class="btn btn-primary">Get It</a>
            </div>
        </div>
         <?php  }} ?>
       <!-- </div> -->
        
    </div>
</body>
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
</html>