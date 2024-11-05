<?php
include('db_connect.php');
$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM found_items WHERE id = '$id'");
$item = mysqli_fetch_assoc($query);

echo json_encode($item);
?>