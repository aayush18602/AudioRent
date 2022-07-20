<?php 
    include_once("connect.php");
    session_start(); 
    if(!$_SESSION['isAdmin']){
        header("location: index.php");
    }
    if($_SERVER['REQUEST_METHOD']=='POST'){
        $title = $_POST['Name'];
        $desc = $_POST['Header'];
        $category = $_POST['category'];
        $audio_name = $_FILES['AudioFile']['name'];
        $audio_file = $_FILES['AudioFile']['tmp_name'];
        // $fileExt = strtolower(end(explode('.',$audio_name)));
        $file_arr = explode('.',$audio_name);
        $file_end = end($file_arr);
        $fileExt = strtolower($file_end);
        $acc = array("mp3","wav","aac","m4a");
        if(in_array($fileExt,$acc) === false){
            echo "<script>alert('Audio Extension not allowed');</script>";
        }else{
            $thum_name = $_FILES['Thumbnail']['name'];
            $thum_file = $_FILES['Thumbnail']['tmp_name'];
            // $fileExt1 = strtolower(end(explode('.',$thum_name)));
            $file_arr1 = explode('.',$thum_name);
            $file_end1 = end($file_arr1);
            $fileExt1 = strtolower($file_end1);
            $acc1 = array("png","jpeg","jfif","svg","jpg");
            if(in_array($fileExt1,$acc1) === false){
                echo "<script>alert('Thumbnail Extension not allowed');</script>";
            }else{
                $datapath = "Audios/".$audio_name;
                $datapath1 = "Thumbnail/".$thum_name;
                move_uploaded_file($audio_file,$datapath);
                move_uploaded_file($thum_file,$datapath1);
                $query = "INSERT INTO audio (Name,Filepath,Thumbnail,Header,Categories) VALUES ('$title','$datapath','$datapath1','$desc','$category')";
                if(!mysqli_query($conn,$query)){
                    echo "<script>alert('Error');</script>";
                }
            }
        }
    }
    $q1 = "SELECT * FROM audio";
    $res = mysqli_query($conn,$q1);
    $j=2;$i=0;
    $html = '<table border="2" cellspacing="0"><tr><th>Audio Id</th> <th>Audio Name</th> <th>Description</th> <th>Filepath</th><th>Thumbnail</th><th>Edit</th><th>Delete</th></tr>';
    while($row = mysqli_fetch_assoc($res)){
      $html.= '<tr><td>'.$row['audio_id'].'</td><td>'.$row['Name'].'</td><td>'.$row['Header'].'</td><td>'.$row['Filepath'].'</td><td>'.$row['Thumbnail'].'</td><td><form method="get" action="editaudio.php"><input type="hidden" value="'.$row['audio_id'].'" name="id"><input type="submit" class="btn btn-primary" value="Edit"></form></td><td><form method="get" action="deleteaudio.php"><input type="hidden" value="'.$row['audio_id'].'" name="del_id"><input type="submit" class="btn btn-danger" value="Delete"></form></td>';
    }
    $html.='<table>';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/bbc02c6b72.js" crossorigin="anonymous"></script>
    <style>
      th,td{
            padding: 10px;
            text-align: center;
            border: 2px solid black;
        }
        table{
          margin: 0 auto;
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
          <h3 style="text-align: center">Add Audios</h3> <br>
          <form action="" method="post"style="width:80%;margin: 0 auto;" enctype="multipart/form-data">
              <input type="text" name="Name" id="" class="form-control" placeholder="Test" required> <br>
              Audio : <input type="file" name="AudioFile" id="" required> 
              Thumbnail : <input type="file" name="Thumbnail" id="" style="margin-top:18px;" required>
              <textarea name="Header" id="" cols="50" rows="7" class="form-control" style="margin-top:18px;" required placeholder="Description"></textarea> <br>
              <label for="category">Category : </label> <br>
              <select name="category" id="category" required class="form-control">
                <option value="Motivational">Motivational</option>
                <option value="Life Science">Life Science</option>
                <option value="Thriller">Thriller</option>
                <option value="Romantic">Romantic</option>
                <option value="Comedy">Comedy</option>
                <option value="Others">Others</option>
              </select> <br>
              <button type="submit" class="btn btn-primary" style="margin-top:10px;">Submit</button>
          </form>
      </div> <br> <br>
      <div class="container">
          <?php echo $html; ?>
      </div>
</body>
</html>