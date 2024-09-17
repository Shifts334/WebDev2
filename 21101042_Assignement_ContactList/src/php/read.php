<?php
    include_once("db_connect.php");
    $status = 200;
    $data = array();
    $count = 0;

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        $stmt = $con->prepare("SELECT * FROM contact WHERE id = ?");
        $stmt->bind_param("i", $id);
    } else {
        $stmt = $con->prepare("SELECT * FROM contact ORDER BY lastName");
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $count = $result->num_rows;

    while($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    $stmt->close();

    $myObj = array(
        'status' => $status,
        'data' => $data,
        'count' => $count
    );

    $myJSON = json_encode($myObj);
    echo $myJSON;
?>