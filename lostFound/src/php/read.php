<?php
include '../src/php/db_connect.php';

$sql = "SELECT Item_ID, Date, Location, Description, Item_Image FROM item";
$result = $pdo->query($sql);

if ($result->rowCount() > 0) {
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "Item ID: " . $row["Item_ID"] . " - Date: " . $row["Date"] . " - Location: " . $row["Location"] . " - Description: " . $row["Description"] . " - Image: " . $row["Item_Image"] . "<br>";
    }
} else {
    echo "0 results";
}
?>
