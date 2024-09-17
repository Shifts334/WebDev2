<?php
    include_once("db_connect.php");
    $retVal = "Delete failed.";
    $status = 400;

    $id = trim($_REQUEST['id']);

    try {
        $stmt = $con->prepare("DELETE FROM contact WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $status = 200;
        $retVal = "Contact deleted.";
    } catch (Exception $e) {
        $retVal = $e->getMessage();
    }

    $myObj = array(
        'status' => $status,
        'message' => $retVal
    );

    $myJSON = json_encode($myObj);
    echo $myJSON;
?>