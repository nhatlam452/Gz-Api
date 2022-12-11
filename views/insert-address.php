<?php
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json; charset=UTF-8");

include_once '../controllers/user-controllers.php';


$data = json_decode(file_get_contents("php://input"));


$respone = null;
try {
    if (isset($data->addressName) &&isset($data->address) && isset($data->uId) 
    && isset($data->city) && isset($data->ward) && isset($data->district)) {
        $respone = (new UserController())->insertAddress($data);
    } else {
        $respone = new Respone(3, true, "Client lack information", null);
    }
} catch (Exception $ex) {
    $respone = new Respone(4, true, "Server's down", null);
}
echo json_encode($respone);
