<?php
$conn = mysqli_connect("localhost", "root", "", "lostandfound");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>
