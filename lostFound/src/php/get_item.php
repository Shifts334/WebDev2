<?php
include '../src/php/db_connect.php';

$id = $_GET['id'];
$sql = "SELECT * FROM items WHERE id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

echo json_encode($item);
?>