<?php
    include_once("connect.php");
    session_start(); 
    if(!$_SESSION['isAdmin']){
        header("location: index.php");
    }
    $id = $_GET['id'];
    $query = "SELECT * FROM audio WHERE audio_id = $id";
    $res = mysqli_query($conn,$query);
    $row = mysqli_fetch_assoc($res);
    $datapath = $row['Filepath'];
    $datapath1 = $row['Thumbnail'];
    if($_SERVER['REQUEST_METHOD']=='POST'){
      $title = $_POST['Name'];
      $desc = $_POST['Header'];
      $category = $_POST['category'];
      if(isset($_FILES['AudioFile'])){
        $audio_name = $_FILES['AudioFile']['name'];
        $audio_file = $_FILES['AudioFile']['tmp_name'];
        $file_arr = explode('.',$audio_name);
        $file_end = end($file_arr);
        $fileExt = strtolower($file_end);
        $acc = array("mp3","wav","aac");
        if(in_array($fileExt,$acc) === false){
            echo "<script>alert('Audio Extension not allowed');</script>";
            // die;
        }else{
          $datapath = "Audios/".$audio_name;
          move_uploaded_file($audio_file,$datapath);
        }
      }
      if(isset($_FILES['Thumbnail'])){
        $thum_name = $_FILES['Thumbnail']['name'];
        $thum_file = $_FILES['Thumbnail']['tmp_name'];
        $file_arr1 = explode('.',$thum_name);
        $file_end1 = end($file_arr1);
        $fileExt1 = strtolower($file_end1);
        $acc1 = array("png","jpeg","jfif","svg");
        if(in_array($fileExt1,$acc1) === false){
            echo "<script>alert('Thumbnail Extension not allowed');</script>";
            // die;
        }else{
          $datapath1 = "Thumbnail/".$thum_name;
          move_uploaded_file($thum_file,$datapath1);
        }
      }
      // $fileExt = strtolower(end(explode('.',$audio_name)));
      // else{
      //     $thum_name = $_FILES['Thumbnail']['name'];
      //     $thum_file = $_FILES['Thumbnail']['tmp_name'];
      //     // $fileExt1 = strtolower(end(explode('.',$thum_name)));
      //     $file_arr1 = explode('.',$thum_name);
      //     $file_end1 = end($file_arr1);
      //     $fileExt1 = strtolower($file_end1);
      //     $acc1 = array("png","jpeg","jfif","svg");
      //     if(in_array($fileExt1,$acc1) === false){
      //         echo "<script>alert('Thumbnail Extension not allowed');</script>";
      //     }else{
      //         $datapath = "Audios/".$audio_name;
      //         $datapath1 = "Thumbnail/".$thum_name;
      //         move_uploaded_file($audio_file,$datapath);
      //         move_uploaded_file($thum_file,$datapath1);
      //         $query = "UPDATE audio SET Name='$title',Header='$desc',Filepath='$datapath',Thumbnail='$datapath1' WHERE id=$id";
      //         if(!mysqli_query($conn,$query)){
      //             echo "<script>alert('Error');</script>";
      //         }
      //     }
      // }
      $query = "UPDATE audio SET Name='$title',Header='$desc',Filepath='$datapath',Thumbnail='$datapath1',Categories='$category' WHERE audio_id=$id";
      if(!mysqli_query($conn,$query)){
        echo "<script>alert('Error');</script>";
      }else{
        header("location:admin.php");
        // echo "<script>alert('Updated Successfully');</script>";
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
</html>
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
          <h3 style="text-align: center">Edit</h3> <br>
          <form action="" method="post" style="text-align:center;" enctype="multipart/form-data">
              <input type="text" name="Name" id="" style="margin: 0 auto; width: 80%;" class="form-control" value="<?php echo $row['Name'];?>" required> <br>
              Audio : <input type="file" name="AudioFile" id=""> <br>
              <a href="<?php echo $row['Filepath'] ?>" style="text-decoration:none;">View Existing Audio</a> <br>
              Thumbnail : <input type="file" name="Thumbnail" id="" style="margin-top:18px;"> <br>
              <a href="<?php echo $row['Thumbnail'] ?>" style="text-decoration:none;">View Existing Thumbnail</a> <br> 
              <textarea name="Header" id="" cols="55" rows="10" required><?php echo $row['Header'];?></textarea> <br>
              <label for="category">Category : </label> <br>
              <select name="category" id="category" required class="form-control">
                <option value="Motivational" <?php if($row['Categories'] == 'Motivational') echo "selected"; ?>>Motivational</option>
                <option value="Life Science" <?php if($row['Categories'] == 'Life Science') echo "selected"; ?>>Life Science</option>
                <option value="Thriller" <?php if($row['Categories'] == 'Thriller') echo "selected"; ?>>Thriller</option>
                <option value="Romantic" <?php if($row['Categories'] == 'Romantic') echo "selected"; ?>>Romantic</option>
                <option value="Comedy" <?php if($row['Categories'] == 'Comedy') echo "selected"; ?>>Comedy</option>
                <option value="Others" <?php if($row['Categories'] == 'Others') echo "selected"; ?>>Others</option>
              </select> <br>
              <button type="submit" class="btn btn-primary">Update</button>
          </form>
      </div>
</body>