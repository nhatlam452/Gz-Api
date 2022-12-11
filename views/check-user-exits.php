<?php
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
 header("Content-Type: application/json; charset=UTF-8");
include_once '../controllers/user-controllers.php';
 $data = json_decode(file_get_contents("php://input"));


$respone = null;

try {
    if (isset($_POST["phoneNumber"]) ) {
        $phonenumber = $_POST["phoneNumber"];
        $respone = (new UserController())->checkUserExits($phonenumber);
    } else {
        $respone = new Respone(3, true, "Somethings when wrong! Please type exactly", null);
    }
} catch (Exception $ex) {
    $respone = new Respone(4, true, "Server's down " . $ex->getMessage(), null);
}
echo json_encode($respone);