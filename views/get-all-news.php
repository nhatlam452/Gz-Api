<?php
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json; charset=UTF-8");

include_once '../controllers/user-controllers.php';



$response = null;

try {
    $response = (new UserController())->getAllNews();
} catch (Exception $ex) {
    $response = new Respone(4, true, "Server down" . $ex->getMessage(), null);
}

echo json_encode($response);
