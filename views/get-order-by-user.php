<?php
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json; charset=UTF-8");

include_once '../controllers/user-controllers.php';


$data = json_decode(file_get_contents("php://input"));

$response = null;

try {
    if (isset($_POST["userId"])) {
        $userId = $_POST["userId"];
        $response = (new UserController())->getOrderByPhoneNumber($userId);
    } else {
        $response = new Respone(3, true, "clack info", null);
    }
} catch (Exception $ex) {
    $response = new Respone(4, true, "Server down", null);
}

echo json_encode($response);
