<?php
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json; charset=UTF-8");

include_once '../controllers/user-controllers.php';




$data = json_decode(file_get_contents("php://input"));


$respone = null;
try {
    if (isset($data->phoneNumber) && isset($data->firstName) && isset($data->lastName)
    && isset($data->password) && isset($data->dob)
    && isset($data->address)&& isset($data->city)&& isset($data->district)&& isset($data->ward)
    && isset($data->salutation) && isset($data->notification)
    && isset($data->role) && isset($data -> addressName)
    ) {
        $respone = (new UserController())->insertUser($data);
    } else {
        $respone = new Respone(3, true, "Client lack information", null);
    }
} catch (Exception $ex) {
    $respone = new Respone(4, true, "Server's down", null);
}
echo json_encode($respone);
