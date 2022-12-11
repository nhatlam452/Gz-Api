<?php


include_once '../controllers/user-controllers.php';



$response = null;

try {
    $response = (new UserController())->getAllStore();
} catch (Exception $ex) {
    $response = new Respone(4, true, "Server down" . $ex->getMessage(), null);
}

echo json_encode($response);
