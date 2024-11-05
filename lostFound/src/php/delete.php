<?php
include '../src/php/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['Item_ID'];

    $sql = "DELETE FROM item WHERE Item_ID = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    echo "Record deleted successfully";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Item</title>
    <link rel="stylesheet" href="../src/css/webDesign.css">
</head>
<body>
    <div class="container">
        <h2>Delete Item</h2>
        <form method="post" action="delete.php">
            Item ID: <input type="text" name="Item_ID" required><br>
            <input type="submit" value="Delete">
        </form>
    </div>
</body>
</html>
