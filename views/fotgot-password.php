<?php


include_once '../controllers/user-controllers.php';


$respone = null;

try {
    // if(isset($data -> phoneNubumber) && isset($data ->password))
    if (isset($_POST["phoneNumber"]) && isset($_POST["newPassword"])) {
        $phonenumber = $_POST["phoneNumber"];
        $password = $_POST["password"];
        $respone = (new UserController())->forgotPassword($phonenumber, $password);
    } else {
        $respone = new Respone(3, true, "Somethings when wrong! Please type exactly", null);
    }
} catch (Exception $ex) {
    $respone = new Respone(4, true, "Server's down " . $ex->getMessage(), null);
}
echo json_encode($respone);