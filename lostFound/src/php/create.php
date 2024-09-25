<?php
include '../src/php/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $date_time = $_POST['date_time'];
    $location_found = $_POST['location_found'];
    $category = $_POST['category'];
    $image = $_FILES['image'];

    // Handle file upload
    $target_dir = "../src/assets/images/";
    $target_file = $target_dir . basename($image["name"]);
    move_uploaded_file($image["tmp_name"], $target_file);

    $sql = "INSERT INTO items (date_time, location_found, category, imageLocation) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$date_time, $location_found, $category, $image["name"]]);

    echo "New record created successfully";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Item</title>
    <link rel="stylesheet" href="../src/css/webDesign.css">
</head>
<body>
    <div class="container">
        <h2>Create New Item</h2>
        <form method="post" action="create.php" enctype="multipart/form-data">
            Date/Time: <input type="datetime-local" name="date_time" required><br>
            Location Found: <input type="text" name="location_found" required><br>
            Category: <input type="text" name="category" required><br>
            Image: <input type="file" name="image" required><br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>