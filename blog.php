<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">Blogs</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="./createblog.php">Create Blog</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./index.php">Home</a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container-blog">
        <div class="left">
            <?php
            include('./config.php');
            $id = $_GET['id'];
            $query = "SELECT * FROM `blogs` where id = $id;";

            // FETCHING DATA FROM DATABASE
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                // OUTPUT DATA OF EACH ROW
                while ($row = $result->fetch_assoc()) {
                    echo "
        <img src='$row[image]' alt=''>
        </center>
        <h3>$row[title]</h3>
        <p>$row[description]</p>   
              ";
                }
            } else {
                echo "0 results";
            }

            ?>
        </div>
        <div class="right">
            <h1>
                Comments
            </h1>
            <div class="cmtform">
                <form action="" method="POST">
                    <div class="input-group mb-3">
                        <input type="text" name="mycmt" class="form-control" placeholder="Enter your comment">
                        <input class="btn btn-dark" type="submit">
                    </div>
                </form>
                <?php
                include('./config.php');
                require 'autoload.php';
                if (isset($_POST['mycmt'])) {
                    $mycmnt = $_POST['mycmt'];
                    // Use the API key from your account
                    // $ml = new MonkeyLearn\Client('2bcef996844ce233e2c17324fb6da94a469d8db9');
                    // $data = array();
                    // array_push($data, $_POST['mycmt']);
                    // $model_id = 'cl_NDBChtr7';
                    // $res = $ml->classifiers->classify($model_id, $data);
                    // var_dump($res->result);
                    //$tag = strval($res->result[0]["classifications"][0]["tag_name"]);
                    //$score = strval($res->result[0]["classifications"][0]["confidence"]);
                    $sql = "INSERT INTO comments (blog_id, score,sentiment, comment) VALUES ('$id','score','tag','$mycmnt');";

                    if ($conn->query($sql)) {
                        echo "Your comment added successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                }


                ?>
            </div>

            <?php
            $id = $_GET['id'];
            $query = "SELECT * FROM `comments` where blog_id = $id;";

            // FETCHING DATA FROM DATABASE
            $result = $conn->query($query);
            if ($result->num_rows > 0) {
                // OUTPUT DATA OF EACH ROW
                while ($row = $result->fetch_assoc()) {
    echo " 
        <div class='comment'>
        <h5>user@44</h5>
        <div class='score'>
            <b>score : $row[score]</b>
            <b> $row[sentiment] </b>
        </div>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Quas tempora sequi et quisquam quo? Fugiat repudiandae asperiores dolor mollitia excepturi, quidem, saepe eius eaque culpa ipsa minus beatae autem consequuntur.</p>
    </div> 
              ";
                }
            } else {
                echo "0 results";
            }
            ?>
    </div>
</body>