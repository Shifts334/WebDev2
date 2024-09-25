<?php
include '../src/php/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $date_time = $_POST['date_time'];
    $location_found = $_POST['location_found'];
    $category = $_POST['category'];
    $image = $_FILES['image'];

    // Handle file upload if a new image is provided
    if ($image['name']) {
        $target_dir = "../src/assets/images/";
        $target_file = $target_dir . basename($image["name"]);
        move_uploaded_file($image["tmp_name"], $target_file);
        $imageLocation = $image["name"];
    } else {
        $imageLocation = $_POST['current_image'];
    }

    $sql = "UPDATE items SET date_time = ?, location_found = ?, category = ?, imageLocation = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$date_time, $location_found, $category, $imageLocation, $id]);

    echo "Record updated successfully";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Item</title>
    <link rel="stylesheet" href="../src/css/webDesign.css">
</head>
<body>
    <div class="container">
        <h2>Update Item</h2>
        <form method="post" action="update.php" enctype="multipart/form-data">
            ID: <input type="text" name="id" required><br>
            Date/Time: <input type="datetime-local" name="date_time" required><br>
            Location Found: <input type="text" name="location_found" required><br>
            Category: <input type="text" name="category" required><br>
            Image: <input type="file" name="image"><br>
            <input type="hidden" name="current_image" id="currentImage">
            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>