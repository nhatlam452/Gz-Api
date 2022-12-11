<?php


include_once '../controllers/user-controllers.php';


$respone = null;

try {
  
    if (isset($_POST["param"]) && isset($_POST["value"])  && isset($_POST["userId"]) ) {
        $param = $_POST["param"];
        $value = $_POST["value"];
        $userId = $_POST["userId"];
        $respone = (new UserController())->updateUser($param,$value,$userId);
    } else {
        $respone = new Respone(3, true, "Client lack information", null);
    }
} catch (Exception $ex) {
    $respone = new Respone(4, true, "Server's down", null);
}
echo json_encode($respone);
