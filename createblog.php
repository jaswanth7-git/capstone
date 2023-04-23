<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">Blogs</a>
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
    <li class="nav-item">
        <a class="nav-link" href="./index.php">Home</a>
      </li>
      </ul>
  </div>
  </nav>
    <div class="container">
      
        <div class="blogform">
        <center> <legend>Please fill the form </legend></center>
            <form action="" method="post">
            <b>Title</b>
            <input class="form-control" name="title" type="text"><br>
            <b>Image Link</b>
            <input class="form-control" name="imagelink" type="text"> <br>
            <b>Description</b>
            <textarea class="form-control" name="description" id="" cols="50" rows="10"></textarea><br>
            <input class="btn btn-dark" type="submit">
            </form>
        </div>
    </div>
</body>
</html>


<?php 
include('./config.php');
require 'autoload.php';
if(isset($_POST['description'])){
// Use the API key from your account
$ml = new MonkeyLearn\Client('2bcef996844ce233e2c17324fb6da94a469d8db9');

$data = array();
array_push($data,$_POST['description']);
$model_id = 'cl_NDBChtr7';
$res = $ml->classifiers->classify($model_id, $data);
// var_dump($res->result);
$tag = strval($res->result[0]["classifications"][0]["tag_name"]);
$score = strval($res->result[0]["classifications"][0]["confidence"]);
$title = strval($_POST['title']);
$imgl = strval($_POST['imagelink']);
$desc = strval($_POST['description']);
$sql = "INSERT INTO blogs (title, image, score,sentiment,description) VALUES ('$title','$imgl','$score','$tag','$desc');";

if ($conn->query($sql)) {
  echo "New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . $conn->error;
}

}


?>