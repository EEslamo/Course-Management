<?php

include './connection.php';
$message = null;    // Alerting Message
$index = 1;         // index to replace the ID of the database

if (isset($_POST["searchbtn"])) {
    $searchValue = $_POST["search"];
    $select = "SELECT * FROM `courses` WHERE `name` LIKE '%$searchValue%'";
    $mydata = mysqli_query($connect, $select);

}



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
</head>

<body>



    <div class="container col-md-6">
        <h1 class=" text-center ">List Courses</h1>
        <div class="card">
            <div class="form-group search-div">
                <input type="text" placeholder="search" class="form-control">
                <button class="btn btn-info">Search</button>
            </div>
            <div class="card-body">
                <table class="table">
                    <tr>
                        <th>ID</th>
                        <th>Course Name</th>
                        <th>Course Code</th>
                        <th>Course Cost</th>
                        <th colspan="2">Action</th>
                    </tr>
                    <?php foreach ($mydata as $item): ?>
                        <tr>
                            <th>
                                <?= $index++ ?>
                            </th>
                            <th>
                                <?= $item['name'] ?>
                            </th>
                            <th>
                                <?= $item['cost'] ?>
                            </th>
                            <th>
                                <?= $item['code'] ?>
                            </th>
                            <th> <a href="index.php?delete=<?= $item['id'] ?>" class="btn btn-danger">Delete</a> </th>
                            <th> <a class="btn btn-primary">Edit</a> </th>
                        </tr>
                    <?php endforeach; ?>

                </table>
            </div>
        </div>
    </div>



</body>

</html>