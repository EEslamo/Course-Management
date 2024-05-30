<?php

include './connection.php';

$message = null;    // Alerting Message
$index = 1;         // index to replace the ID of the database

if (isset ($_POST["senddata"])) {
    $name = $_POST["courseName"];
    $code = $_POST["courseCode"];
    $cost = $_POST["courseCost"];

    //Image code

    $Image_name = time() . rand(0, 255) . rand(0, 255) . $_FILES['courseImage']['name'];   //first index --> [image name] , secomd index --> [name] constant
    $Image_tmp = $_FILES['courseImage']['tmp_name'];    //first index --> [image name] , secomd index --> [tmp_name] constant
    $location = "./upload/" . $Image_name;                // location of the image

    //moving the image actually
    move_uploaded_file($Image_tmp, $location);

    // Create
    $create = "INSERT INTO `courses` (id , `name` , cost , code , `image`) VALUES (null , '$name' , '$cost' , '$code' , '$Image_name')";
    $i = mysqli_query($connect, $create);   //Executing the "create" statement
    if ($i) {
        $message = "Course Added Successfully";

    }
}


//SELECT
$select = "SELECT * FROM `courses`";
$mydata = mysqli_query($connect, $select);



$name = "";
$code = "";
$cost = "";

//UPDATE
if (isset ($_GET["edit"])) {
    $id = $_GET['edit'];          // Get id from URL
    $select_By_Id = "SELECT * FROM `courses` WHERE id = '$id' ";
    $mydata = mysqli_query($connect, $select_By_Id);
    $row = mysqli_fetch_assoc($mydata);
    $name = $row["name"];
    $code = $row["code"];
    $cost = $row["cost"];
    // $image = $row["image"];


    if (isset ($_POST["updatedata"])) {
        $name = $_POST["courseName"];
        $code = $_POST["courseCode"];
        $cost = $_POST["courseCost"];
        // $image = $_POST["courseImage"];

        if (empty ($_FILES['courseImage']['name'])) {
            $Image_name = $row['image'];
        } else {
            
            $image_With_Path = "./upload/" . $row['image'];
            unlink("$image_With_Path");

            $Image_name = time() . rand(0, 255) . rand(0, 255) . $_FILES['courseImage']['name'];   //first index --> [image name] , secomd index --> [name] constant
            $Image_tmp = $_FILES['courseImage']['tmp_name'];    //first index --> [image name] , secomd index --> [tmp_name] constant
            $location = "./upload/" . $Image_name;                // location of the image
            //moving the image actually
            move_uploaded_file($Image_tmp, $location);
        }

        //Update
        $update = "UPDATE `courses` SET `name` = '$name' , `code` = '$code' , `cost` = '$cost' , `image` = '$Image_name'  WHERE `id` = '$id' ";
        $i = mysqli_query($connect, $update);   //Executing the "Update" statement
        if ($i) {
            $message = "Course Updated Successfully";
        }
        header("location: index.php");
    }
}

// Delete
if (isset ($_GET['delete'])) {
    $id = $_GET['delete'];
    $select_By_Id = "SELECT `image` FROM `courses` WHERE id = '$id' ";
    $mydata = mysqli_query($connect, $select_By_Id);
    $row = mysqli_fetch_assoc($mydata);
    $image_With_Path = "./upload/" . $row['image'];
    unlink("$image_With_Path");

    $delete = "DELETE FROM `courses` WHERE id = '$id' ";
    $e = mysqli_query($connect, $delete); //Execute database
    header("location: index.php");  // Reload Page
}

if (isset ($_GET['deleteAll'])) {
    $id = $_GET['delete'];
    $delete = "DELETE FROM `courses`";
    $e = mysqli_query($connect, $delete); //Execute database
    header("location: index.php");  // Reload Page
}


$onetheme = "SELECT color from `theme` where id=2";
$selectColor = mysqli_query($connect, $onetheme);
$row = mysqli_fetch_assoc($selectColor);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./css/all.min.css">
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/main.css">
    <?php if (isset ($_POST['light'])): ?>
        <link rel="stylesheet" href="./css/main.css">
    <?php elseif (isset ($_POST['dark'])): ?>
        <link rel="stylesheet" href="./css/dark.css">
    <?php endif; ?>


</head>

<body>

    <form method="POST">
        <div class="container text-center my-3 col-3">
            <button class="btn btn-light" name="light">Light</button>
            <button class="btn btn-dark" name="dark">Dark</button>
        </div>
    </form>

    <div class="container col-md-6">
        <h1 class=" text-center text-info ">Add New Course</h1>
        <div class="card">
            <?php if ($message != null): ?>
                <div class="alert alert-success">
                    <?= $message ?>
                </div>
            <?php endif; ?>
            <div class="card-body">
                <form method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="">Course Name</label>
                        <input type="text" value="<?= $name ?>" class="form-control" name="courseName"
                            placeholder="Enter course name">
                    </div>
                    <div class="form-group">
                        <label for="">Course Code</label>
                        <input type="text" value="<?= $code ?>" class="form-control" name="courseCode"
                            placeholder="Enter course code">
                    </div>
                    <div class="form-group">
                        <label for="">Course Cost</label>
                        <input type="text" value="<?= $cost ?>" class="form-control" name="courseCost"
                            placeholder="Enter course cost">
                    </div>
                    <div class="form-group">
                        <label for="">Course Icon</label>
                        <input type="file" class="form-control" name="courseImage" placeholder="Enter course icon">
                    </div>
                    <?php if (!isset ($_GET['edit'])): ?>
                        <div class="d-grid">
                            <button class="btn btn-info" name="senddata">
                                Add Course</button>
                        </div>
                    <?php endif; ?>
                    <?php if (isset ($_GET['edit'])): ?>
                        <div class="d-grid">
                            <button class="btn btn-info my-2" name="updatedata"> Update</button>
                        </div>
                    <?php endif; ?>
                </form>

            </div>
        </div>
    </div>


    <div class="container col-md-6">
        <h1 class=" text-center ">List Courses</h1>
        <div class="card">
            <form action="./searchResult.php" method="POST">
                <div class="form-group search-div">
                    <input type="text" name="search" placeholder="Search By Name" class="form-control">
                    <button name="searchbtn" class="btn btn-info">Search</button>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-grid">
                            <a href="index.php?deleteAll=2" class="btn btn-danger"
                                onclick="return confirm('Are you sure you want to delete all the employees')">Delete
                                All</a>
                        </div>
                    </div>
                </div>

            </form>
            <div class="card-body">
                <table class="table text-center">
                    <tr>
                        <th>ID</th>
                        <th>Course Name</th>
                        <th colspan="3">Action</th>
                    </tr>
                    <?php foreach ($mydata as $item): ?>
                        <tr>
                            <th>
                                <?= $index++ ?>
                            </th>
                            <th>
                                <?= $item['name'] ?>
                            </th>
                            <th> <a href="index.php?delete=<?= $item['id'] ?>" class="btn btn-danger">Delete</a> </th>
                            <th> <a href="index.php?edit=<?= $item['id'] ?>" class="btn btn-primary">Edit</a>
                            <th> <a href="view.php?view=<?= $item['id'] ?>" class="btn btn-primary">View</a>
                            </th>
                        </tr>
                    <?php endforeach; ?>

                </table>
            </div>
        </div>
    </div>



</body>

</html>