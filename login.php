<?php
require("config/index.php");

try{
    $email = $body->email;
    $password = $body->password;
    $hash = md5($password);

    $stmt = $conn->prepare("SELECT * FROM users where email = ? AND hash = ?");
    $stmt->execute([$email, $hash]);
    if($stmt->rowCount() === 0)
    throw new Exception("Invalid Username or Password");

    $row = $stmt->fetch(PDO::FETCH_OBJ);

    $res = new stdClass;
    $res->status = 1;
    $res->message = "Login Successful!";
    $res->user = new stdClass;
    $res->user->name = $row->name;
    $res->user->email = $row->email;
    $res->user->image = $row->image;
    $res->user->id = $row->id;

    echo json_encode($res);
    
    // $res->name  

}
catch(Exception $e)
{
    $res = new stdClass;
    $res->status = 0;
    $res->message = $e->getMessage();
    echo json_encode($res);

}