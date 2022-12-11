<?php

include_once '../controllers/user-controllers.php';
$respone = null;

try {
    if (isset($_POST["phoneNumber"])) {
        $phonenumber = $_POST["phoneNumber"];
        $respone = (new UserController())->getUserByUsername($phonenumber);
    } else {
        $respone = new Respone(3, true, "Somethings when wrong! Please type exactly", null);
    }
} catch (Exception $ex) {
    $respone = new Respone(4, true, "Server's down " . $ex->getMessage(), null);
}
echo json_encode($respone);