<?php
require("config/index.php");

try{
    $id = $get["id"];
    $stmt = $conn->prepare("SELECT * FROM notes where user_id = ? order by id desc");
    $stmt->execute([$id]);
    $rows = $stmt->fetchAll(PDO::FETCH_OBJ);

    $res = new stdClass;
    $res->status = 1;
    $res->message = "";
    $res->notes = $rows;
    echo json_encode($res);
    

}
catch(Exception $e)
{
    $res = new stdClass;
    $res->status = 0;
    $res->message = $e->getMessage();
    echo json_encode($res);

}