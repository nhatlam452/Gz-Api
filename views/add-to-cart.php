<?php


include_once '../controllers/user-controllers.php';



$respone = null;
try {
    if (isset($_POST["userId"]) && isset($_POST["productId"]) && isset($_POST["quantity"])) {
        $userId = $_POST["userId"];
        $productId = $_POST["productId"];
        $quantity = $_POST["quantity"];


        $respone = (new UserController())->addToCart($userId,$productId,$quantity);
    } else {
        $respone = new Respone(3, true, "Client lack information", null);
    }
} catch (Exception $ex) {
    $respone = new Respone(4, true, "Server's down", null);
}
echo json_encode($respone);
