<?php
try {
    $get = $_GET;
    $json = file_get_contents("php://input");
    $body = json_decode($json);
} catch(Exception $e) {
    $body = new stdClass;
}