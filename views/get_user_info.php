<?php


include_once '../controllers/user-controllers.php';


$respone = null;

try {
    if (isset($_POST["userId"]) ) 
    {
        $userId = $_POST["userId"];
        $respone = (new UserController())->getUserByUsername($userId);
    } else {
        $respone = new Respone(3, true, "Somethings when wrong! Please type exactly", null);
    }
} catch (Exception $ex) {
    $respone = new Respone(4, true, "Server's down " . $ex->getMessage(), null);
}
echo json_encode($respone);
