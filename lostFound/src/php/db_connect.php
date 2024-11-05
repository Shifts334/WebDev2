<?php
$conn = mysqli_connect("localhost", "root", "", "found_items_db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>