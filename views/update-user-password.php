<?php
include_once '../controllers/user-controllers.php';

$respone = null;

try {
    if(isset($_POST["password"]) == null){
        if (isset($_POST["phoneNumber"]) && isset($_POST["newPassword"]) ) {
            $phoneNumber = $_POST["phoneNumber"];
            $newPassword = $_POST["newPassword"];
    
            $respone = (new UserController())->updateUserPassword($phoneNumber,$newPassword,null);
        } else {
            $respone = new Respone(3, true, "Client lack information", null);
        }
    }else{
        if (isset($_POST["phoneNumber"]) && isset($_POST["newPassword"]) && isset($_POST["password"])) {
            $phoneNumber = $_POST["phoneNumber"];
            $newPassword = $_POST["newPassword"];
            $password = $_POST["password"];
            $respone = (new UserController())->updateUserPassword($phoneNumber,$newPassword,$password);
        } else {
            $respone = new Respone(3, true, "Client lack information", null);
        }
    }
   
} catch (Exception $ex) {
    $respone = new Respone(4, true, "Server's down", null);
}
echo json_encode($respone);
