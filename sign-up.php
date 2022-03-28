<?php
require("config/index.php");

try {
    $email = $body->email;
    $password = $body->password;
    $c_password = $body->c_password;
    $name = $body->name;
    
    $stmt = $conn->prepare("SELECT * FROM users where email = ?");
    $stmt->execute([$email]);
    if($stmt->rowCount() > 0)
        throw new Exception("Email already exists");
    if($password !== $c_password)
        throw new Exception("Password do not match");
    
    $stmt = $conn->prepare("INSERT INTO `users`(`email`, `hash`, `name`) VALUES (?, ?, ?)");
    $stmt->execute([$email, md5($password), $name]);
    $id = $conn->lastInsertId();
    $res = new stdClass;
    $res->status = 1;
    $res->message = "Sign Up Successful!";
    $res->user = new stdClass;
    $res->user->email = $email;
    $res->user->name = $name;
    $res->user->id = $id;
    $res->user->image = "";

    echo json_encode($res);
} catch(Exception $e) {
    $res = new stdClass;
    $res->status = 0;
    $res->message = $e->getMessage();
    // ! associative array = object in json
    // $response = [
    //     "status" => 0,
    //     "message" => $e->getMessage()
    // ];
    echo json_encode($res);

}