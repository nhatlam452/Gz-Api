<?php

include_once '../controllers/user-controllers.php';



$respone = null;
try {
    if (isset($_POST["productId"])) {
        $productId = $_POST["productId"];
        $respone = (new UserController())->getAllComment($productId);
    } else {
        $respone = new Respone(3, true, "Client lack information", null);
    }
} catch (Exception $ex) {
    $respone = new Respone(4, true, "Server's down", null);
}
echo json_encode($respone);
