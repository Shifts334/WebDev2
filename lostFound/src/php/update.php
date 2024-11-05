<?php
include '../src/php/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['Item_ID'];
    $date = $_POST['Date'];
    $location = $_POST['Location'];
    $description = $_POST['Description'];
    $image = $_FILES['image'];

    if ($image['name']) {
        $target_dir = "../src/assets/images/";
        $target_file = $target_dir . basename($image["name"]);
        move_uploaded_file($image["tmp_name"], $target_file);
        $imageLocation = $image["name"];
    } else {
        $imageLocation = $_POST['current_image'];
    }

    $sql = "UPDATE item SET Date = ?, Location = ?, Description = ?, Item_Image = ? WHERE Item_ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$date, $location, $description, $imageLocation, $id]);

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
            Item ID: <input type="text" name="Item_ID" required><br>
            Date: <input type="date" name="Date" required><br>
            Location: <input type="text" name="Location" required><br>
            Description: <input type="text" name="Description" required><br>
            Image: <input type="file" name="image"><br>
            <input type="hidden" name="current_image" id="currentImage">
            <input type="submit" value="Update">
        </form>
    </div>
</body>
</html>
