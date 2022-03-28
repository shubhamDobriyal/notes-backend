<?php
require("config/index.php");

try{
    $id = $_POST["id"];
    $name = $_POST["name"];
    $image = $_FILES["image"];
    if($image["error"] === 0)
    {
        $fileType = explode("/", $image["type"])[1];
        $fileName = md5($image["name"])."_".$id.".".$fileType;
        $filePath = "images/".$fileName;
        move_uploaded_file($image["tmp_name"], $filePath);
        $stmt = $conn->prepare("UPDATE users set image = ?, name = ? where id = ?");
        $stmt->execute([$fileName, $name, $id]);
    }else{
        $stmt = $conn->prepare("UPDATE users set name = ? where id = ?");
        $stmt->execute([$name, $id]);
    }
   

    $res = new stdClass;
    $res->status = 1;
    $res->message = "Updated successfully";
    $res->user = new stdClass;
    $res->user->name = $name;
    if(isset($fileName)) {
        $res->user->image = $fileName;
    }
    $res->user->id = $id;
    echo json_encode($res);
    

}
catch(Exception $e)
{
    $res = new stdClass;
    $res->status = 0;
    $res->message = $e->getMessage();
    echo json_encode($res);

}