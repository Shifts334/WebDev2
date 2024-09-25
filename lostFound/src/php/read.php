<?php
include 'db_connect.php';

$sql = "SELECT id, date_time, location_found, category, imageLocation FROM items";
$result = $pdo->query($sql);

if ($result->rowCount() > 0) {
    // Output data of each row
    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "ID: " . $row["id"]. " - Date/Time: " . $row["date_time"]. " - Location Found: " . $row["location_found"]. " - Category: " . $row["category"]. " - Image Location: " . $row["imageLocation"]. "<br>";
    }
} else {
    echo "0 results";
}
?>