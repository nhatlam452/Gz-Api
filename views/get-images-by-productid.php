<?php
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Content-Type: application/json; charset=UTF-8");

include_once '../controllers/product-controllers.php';


$data = json_decode(file_get_contents("php://input"));

$response = null;

try {
    if (
        isset($data->productid)
    ) {
        $response = (new ProductController())->getImagesByProductID($data->productid);
    } else {
        $response = new Respone(3, true, "Can't load image product you choose", null);
    }
} catch (Exception $ex) {
    $response = new Respone(4, true, "Server down", null);
}

echo json_encode($response);
