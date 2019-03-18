<?php
$datum = date('Y-m-d h:i:s', time());
// $data = array(
//     'name' => 'Chrone Group',
//     'createDate' => date('Y-m-d h:i:s', time()),
//     'IsActive' => true,
//     'userId' => 10
// );

$conn = new mysqli('localhost', 'root', '', 'datadata');

$sql = "INSERT INTO groups (name, createDate, IsActive, userId)
VALUES ('Chrone Group', '$datum', true, 10)";

mysqli_query($conn, $sql);

//echo $sql;


?>