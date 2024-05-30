<?php
include './connection.php';

//CRUD

//Create
$create = "INSERT INTO `courses` (id , `name` , cost) VALUES (null , 'data science' , 2000)";

//SELECT
$select = "SELECT * FROM `courses`";

//SELECT BY ID
$select_By_Id = "SELECT * FROM `courses` WHERE id = 2 ";

//UPDATE

$update = "UPDATE `courses` SET `name` = 'c++'  WHERE id = 1";

//DELETE 
$delete = "DELETE FROM `courses` WHERE id = 5 ";

// mysqli_query($connect, $delete); //Execute database


try {
    mysqli_query($connect, $update);

} catch (Exception $e) {
    $e->getMessage();
}

$mydata = mysqli_query($connect, $select);


foreach ($mydata as $item) {
    echo $item['id'] . "<br>";
    echo $item['name'] . "<br>";
    echo $item['cost'] . "<hr>";
}
?>