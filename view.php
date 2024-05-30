<?php
include './connection.php';
if (isset ($_GET['view'])) {
    $id = $_GET['view'];
    $select_By_Id = "SELECT * FROM `courses` WHERE id = '$id' ";
    $mydata = mysqli_query($connect, $select_By_Id);
    $row = mysqli_fetch_assoc($mydata);
    $name = $row["name"];
    $code = $row["code"];
    $cost = $row["cost"];
    $image = $row["image"];

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



    <div class="container mt-4 col-md-3">
        <h1 class=" text-center text-primary">List Courses</h1>
        <div class="card">
            <img src="./upload/<?= $row['image']?>" alt="" class="image-fluid">
            <div class="card-body">
                <h5>Name: <?= $row['name'] ?> </h5>
                <hr>
                <h5>Name: <?= $row['code'] ?> </h5>
                <hr>
                <h5>Name: <?= $row['cost'] ?> </h5>
                <hr>

            </div>
        </div>
    </div>



</body>

</html>