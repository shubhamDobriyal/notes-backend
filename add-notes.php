<?php
require("config/index.php");

try{
    $id = $body->id;
    $note_id = $body->noteId;
    $title = $body->title;
    $content = $body->content;
    if($note_id){
        $stmt = $conn->prepare("UPDATE notes set title = ?, content = ? where id = ?");
        $stmt->execute([$title, $content, $note_id]);
    } else {
        $stmt = $conn->prepare("INSERT INTO notes (user_id, title, content) values (?, ?, ?)");
        $stmt->execute([$id, $title, $content]);
    }

    $res = new stdClass;
    $res->status = 1;
    $res->message = $note_id ? "Updated Successfully" : "Added Successfully";
    echo json_encode($res);
}
catch(Exception $e)
{
    $res = new stdClass;
    $res->status = 0;
    $res->message = $e->getMessage();
    echo json_encode($res);

}