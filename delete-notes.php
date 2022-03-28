<?php
require("config/index.php");

try{
    $id = $get["id"];
    $stmt = $conn->prepare("DELETE FROM notes where id = ? ");
    $stmt->execute([$id]);

    $res = new stdClass;
    $res->status = 1;
    $res->message = "Deleted Successfully";
    echo json_encode($res);
}
catch(Exception $e)
{
    $res = new stdClass;
    $res->status = 0;
    $res->message = $e->getMessage();
    echo json_encode($res);

}